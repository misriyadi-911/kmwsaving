<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Saldo;
use App\Models\TransactionalSavings;
use App\Models\DepartureInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Utils\Notification;
use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    protected $admin;
    public function __construct(\App\Models\Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        $data = Admin::All();
        return response($data);
    }

    public function dashboard()
    {
        try {
            // $jml_saldo = Saldo::select('nominal', DB::raw('SUM(nominal) as total_saldo'))->get();
            $total_saldo = DB::select("SELECT SUM(saldo.nominal) AS total FROM saldo")[0];
            $jml_jamaah  = DB::select("SELECT COUNT(pilgrims.pilgrims_id) AS jml_jamaah FROM pilgrims")[0];
            $jml_verified = DB::select("SELECT COUNT(transactional_savings.type) AS terverfikasi FROM transactional_savings WHERE transactional_savings.type='belum'")[0];
            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => [
                    'total' => $total_saldo->total ? $total_saldo->total : 0,
                    'total_pilgrims' => $jml_jamaah->jml_jamaah,
                    'not_verified' => $jml_verified->terverfikasi,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function data_tabungan()
    {
        try {
            $request = request()->all();
            $page = isset($request['page']) ? $request['page'] : 1;
            $request['limit'] = isset($request['limit']) ? $request['limit'] : 10;
            $offset = ($page - 1) * $request['limit'];
            $data = Saldo::rightJoin('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->leftJoin('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
                ->leftJoin('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id');
            if (isset($request['search'])) {
                $data = $data->orWhere('pilgrims.kode', 'like', '%' . $request['search'] . '%')
                    ->orWhere('user_account.username', 'like', '%' . $request['search'] . '%')
                    ->orWhere('saving_categories.name', 'like', '%' . $request['search'] . '%')
                    ->orWhere('pilgrims.address', 'like', '%' . $request['search'] . '%')
                    ->orWhere('saldo.nominal', 'like', '%' . $request['search'] . '%');
            }
            $total = $data->get()->count();
            $data = $data->offset($offset)->limit($request['limit'])->get();

            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => [
                    'totalPage' => ceil($total / $request['limit']),
                    'totalRows' => $total,
                    'pageNumber' => intval($page),
                    'data' => $data,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function detail_tabungan($id)
    {
        try {
            $data_tabungan = DB::select("SELECT saldo.*, pilgrims.*, saving_categories.*, user_account.* FROM saldo 
             RIGHT JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
             RIGHT JOIN user_account ON pilgrims.user_account_id = user_account.user_account_id
             RIGHT JOIN saving_categories ON pilgrims.saving_category_id = saving_categories.saving_category_id WHERE pilgrims.pilgrims_id = '$id'");
            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => $data_tabungan[0]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function setor_tabungan(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data_tabungan = DB::select("SELECT saldo.saldo_id, saldo.nominal, pilgrims.bank_account_name, pilgrims.address, pilgrims.saving_category_id, saving_categories.limit, pilgrims.pilgrims_id, pilgrims.user_account_id, user_account.email, user_account.username
            FROM saldo 
            JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
            JOIN user_account ON pilgrims.user_account_id = user_account.user_account_id
            JOIN saving_categories ON pilgrims.saving_category_id = saving_categories.saving_category_id
            WHERE pilgrims.pilgrims_id = '$id'");

            if(empty($data_tabungan)){
                $data = Saldo::create([
                    'pilgrims_id' => $id,
                    'nominal' => 0
                ]);
                $data_tabungan = DB::select("SELECT saldo.saldo_id, saldo.nominal, pilgrims.bank_account_name, pilgrims.address, pilgrims.saving_category_id, saving_categories.limit, pilgrims.pilgrims_id, pilgrims.user_account_id, user_account.email, user_account.username
                FROM saldo 
                JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
                JOIN user_account ON pilgrims.user_account_id = user_account.user_account_id
                JOIN saving_categories ON pilgrims.saving_category_id = saving_categories.saving_category_id
                WHERE pilgrims.pilgrims_id = '$id'");
            }
           

            if ($data_tabungan[0]->limit < $data_tabungan[0]->nominal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Jamaah ini sudah melebihi limit pembayaran',
                    'data' => $data_tabungan[0]
                ]);
            }

            $data = new TransactionalSavings();
            $data->pilgrims_id = $id;
            $data->nominal = $request->input('nominal');
            $data->type = $request->input('type') ? 'belum' : 'diverifikasi';
            $data->save();
            $nominal = 0;
            if ($data->type == 'diverifikasi') {
                $saldo = Saldo::find($data_tabungan[0]->saldo_id);
                $saldo->nominal = $data_tabungan[0]->nominal + $data->nominal;
                $nominal = $saldo->nominal;
                $saldo->save();
            }


            $publishResponse = new Notification();
            $publishResponse->sendNotification('jamaah-' . $data_tabungan[0]->user_account_id, 'Pemberitahuan', 'Saldo anda telah diverifikasi oleh administrator');

            ModelsNotification::create([
                'user_account_id' => $data_tabungan[0]->user_account_id,
                'transactional_savings_id' => $data->transactional_savings_id,
                'message' => 'Tabungan anda telah diverifikasi oleh administrator'
            ]);

            $nominalPembayaran = number_format($request->input('nominal'), 0, ',', '.');
            $nominal = number_format($nominal, 0, ',', '.');

             Mail::send('email.diterima', [
                'status_pembayaran' => $data->type == 'diverifikasi' ? 'Diverifikasi' : 'Belum diverifikasi',
                'invoice_id' => "INV-" . $data->transactional_savings_id . $data_tabungan[0]->pilgrims_id . date('YmdHis'),
                'nominal' => $nominalPembayaran,
                'metode_pembayaran' => 'Setor Tunai Via Admin',
                'waktu_pembayaran' => date('d-m-Y H:i') . ' WIB',
                'total_saldo' => $nominal
             ], function ($message) use ($data_tabungan) {
                $message->to($data_tabungan[0]->email, $data_tabungan[0]->username)->subject('Pemberitahuan Pembayaran');
                $message->from('bincangbudidayaudang@gmail.com', 'noreply@kmwsaving.com');
            });

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Setor tabungan berhasil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function data_verifikasi()
    {
        try {
            $request = request()->all();
            $page = isset($request['page']) ? $request['page'] : 1;
            $limit = isset($request['limit']) ? $request['limit'] : 10;
            $offset = ($page - 1) * $limit;

            $data_tabungan = TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
                ->where('transactional_savings.type', 'belum');

            if (isset($request['search'])) {
                $data_tabungan = $data_tabungan
                    ->orWhere('pilgrims.kode', 'like', '%' . $request['search'] . '%')
                    ->orWhere('user_account.username', 'like', '%' . $request['search'] . '%')
                    ->orWhere('transactional_savings.nominal', 'like', '%' . $request['search'] . '%');
            }

            $total = $data_tabungan->get()->count();
            $data_tabungan = $data_tabungan->offset($offset)->limit($limit)->get();

            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => [
                    'totalPage' => ceil($total / $limit),
                    'totalRows' => $total,
                    'pageNumber' => intval($page),
                    'data' => $data_tabungan,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function lihat_gambar($id)
    {
        try {
            $data_tabungan = TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
                ->join('files', 'transactional_savings.file_id', '=', 'files.file_id')
                ->where('transactional_savings.transactional_savings_id', '=', $id)
                ->get();
            if ($data_tabungan[0]) {
                return response()->json([
                    'status'  => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $data_tabungan[0]
                ]);
            }
            return response()->json([
                'status'  => false,
                'message' => 'Data not found',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function ganti_verifikasi(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data_tabungan = TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
                ->where('transactional_savings.transactional_savings_id', '=', $id)
                ->first();
            $data_tabungan->type = $request->input('type');
            $data_tabungan->saldo = $data_tabungan->saldo + $data_tabungan->nominal;

            $nominal = 0;
            $nominalPembayaran = number_format($data_tabungan->nominal, 0, ',', '.');
            if ($request->type == 'diverifikasi') {
                $exist = Saldo::where('pilgrims_id', $data_tabungan->pilgrims_id)->first();
                if ($exist) {
                    $exist->nominal = $exist->nominal + $data_tabungan->nominal;
                    $nominal = $exist->nominal + $data_tabungan->nominal;
                    $exist->save();
                } else {
                    $nominal = $data_tabungan->nominal;
                    Saldo::create([
                        'pilgrims_id' => $data_tabungan->pilgrims_id,
                        'nominal' => $data_tabungan->nominal
                    ]);
                }
                $nominal = number_format($nominal, 0, ',', '.');
                Mail::send('email.diterima', [
                    'status_pembayaran' => 'Diverifikasi',
                    'invoice_id' => "INV-" . $data_tabungan->transactional_savings_id . $data_tabungan->pilgrims_id . date('YmdHis'),
                    'nominal' => $nominalPembayaran,
                    'metode_pembayaran' => 'Transfer Bank',
                    'waktu_pembayaran' => date('d-m-Y H:i') . ' WIB',
                    'total_saldo' => $nominal
                 ], function ($message) use ($data_tabungan) {
                    $message->to($data_tabungan->email, $data_tabungan->username)->subject('Pemberitahuan Pembayaran');
                    $message->from('bincangbudidayaudang@gmail.com', 'noreply@kmwsaving.com');
                });
            }

            
            if ($request->input('comment')) {
                $data_tabungan->comment = $request->input('comment');
                Mail::send('email.ditolak', [
                    'status_pembayaran' => 'Diverifikasi',
                    'invoice_id' => "INV-" . $data_tabungan->transactional_savings_id . $data_tabungan->pilgrims_id . date('YmdHis'),
                    'nominal' => $nominalPembayaran,
                    'metode_pembayaran' => 'Transfer Bank',
                    'waktu_pembayaran' => date('d-m-Y H:i') . ' WIB',
                    'total_saldo' => $nominal,
                    'alasan' => $request->input('comment')
                 ], function ($message) use ($data_tabungan) {
                    $message->to($data_tabungan->email, $data_tabungan->username)->subject('Pemberitahuan Pembayaran');
                    $message->from('bincangbudidayaudang@gmail.com', 'noreply@kmwsaving.com');
                });
            }
            $data_tabungan->save();
           
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Sukses mengubah status',
                'data' => $data_tabungan
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function data_pemberangkatan()
    {
        try {
            $request = request()->all();
            $page = isset($request['page']) ? $request['page'] : 1;
            $limit = isset($request['limit']) ? $request['limit'] : 10;
            $offset = ($page - 1) * $limit;

            $data = Saldo::join('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
                ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
                ->leftjoin('departure_informations', 'pilgrims.pilgrims_id', '=', 'departure_informations.pilgrims_id')
                ->select('pilgrims.created_at as tanggal_mendaftar', 'saldo.updated_at as tanggal_lunas', 'pilgrims.kode as kode', 'user_account.username as nama', 'saving_categories.name as kategori', 'pilgrims.address as alamat', 'pilgrims.pilgrims_id as id', 'departure_informations.time as waktu_keberangkatan')
                ->where('saldo.nominal', '>=', DB::raw('saving_categories.limit'));
            if (isset($request['search'])) {
                $data = $data->where('pilgrims.kode', 'like', '%' . $request['search'] . '%')
                    ->orWhere('user_account.username', 'like', '%' . $request['search'] . '%')
                    ->orWhere('saving_categories.name', 'like', '%' . $request['search'] . '%')
                    ->orWhere('pilgrims.address', 'like', '%' . $request['search'] . '%')
                    ->orWhere('departure_informations.time', 'like', '%' . $request['search'] . '%')
                    ->orWhere('saldo.nominal', 'like', '%' . $request['search'] . '%');
            }
            $data = $data->offset($offset)->limit($limit)->get();
            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => [
                    'totalPage' => ceil($data->count() / $limit),
                    'totalRows' => $data->count(),
                    'pageNumber' => intval($page),
                    'data' => $data,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function input_pemberangkatan(Request $request)
    {
        try {
            $exist = DepartureInformation::where('pilgrims_id', $request->input('id'))->first();

            if ($exist) {
                $exist->time = $request->input('time');
                $exist->save();
            } else {
                $data_pemberangkatan = new DepartureInformation();
                $data_pemberangkatan->pilgrims_id = $request->input('id');
                $data_pemberangkatan->time = $request->input('time');
                $data_pemberangkatan->save();
            }
            return response()->json([
                'status'  => true,
                'message' => 'Sukses mengubah status'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = new Admin();
            $data->user_account_id = $request->input('user_account_id');
            $data->address = $request->input('address');
            $data->phone = $request->input('phone');
            $data->gender = $request->input('gender');
            $data->save();
            return response()->json([
                'status'  => true,
                'message' => response($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Admin::where('employe_id', $id)->first();
            return response()->json([
                'status'  => true,
                'message' => response($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Admin::where('employe_id', $id)->first();
            $data->address = $request->input('address');
            $data->phone = $request->input('phone');
            $data->gender = $request->input('gender');
            $data->save();
            return response()->json([
                'status'  => true,
                'message' => response($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = Admin::where('employe_id', $id)->first();
            $data->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function editSetor(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $saldo = Saldo::where('pilgrims_id', $id)->first();
            if(!$saldo) {
                $saldo = Saldo::create([
                    'pilgrims_id' => $id,
                    'nominal' => 0
                ]);
            }
            if ($saldo->nominal < $request->input('nominal')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Saldo tidak mencukupi',
                    'data' => $saldo
                ]);
            }
            
            $data = TransactionalSavings::create([
                'pilgrims_id' => $id,
                'nominal' => $request->input('nominal') * -1,
                'type' => 'belum'
            ]);

            
            // $data_tabungan = T



            // $publishResponse = new Notification();
            // $publishResponse->sendNotification('jamaah-' . $data_tabungan->user_account_id, 'Pemberitahuan', 'Saldo anda ditarik oleh administrator, sebesar Rp. ' . number_format($request->input('nominal'), 0, ',', '.'));

            // ModelsNotification::create([
            //     'user_account_id' => $data_tabungan->user_account_id,
            //     'transactional_savings_id' => $data->transactional_savings_id,
            //     'message' => 'Saldo anda ditarik oleh administrator, sebesar Rp. ' . number_format($request->input('nominal'), 0, ',', '.')
            // ]);
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Sukses mengubah status',
                'data' => $data_tabungan
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
