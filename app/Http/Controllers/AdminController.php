<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pilgrims;
use App\Models\Saldo;
use App\Models\TransactionalSavings;
use App\Models\DepartureInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesDB;

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
            $data = Saldo::join('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->join('user_account', 'user_account.user_account_id', '=', 'pilgrims.user_account_id')
                ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')->offset($offset)->limit($request['limit'])->get();

            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => [
                    'totalPage' => ceil(Saldo::count() / $request['limit']),
                    'totalRows' => Saldo::count(),
                    'pageNumber' => $page,
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
             JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
             JOIN user_account ON pilgrims.user_account_id = user_account.user_account_id
             JOIN saving_categories ON pilgrims.saving_category_id = saving_categories.saving_category_id WHERE pilgrims.pilgrims_id = '$id'");
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
            $data_tabungan = DB::select("SELECT saldo.saldo_id, saldo.nominal, pilgrims.bank_account_name, pilgrims.address, pilgrims.saving_category_id FROM saldo 
            INNER JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
            WHERE pilgrims.pilgrims_id = '$id'");

            $data = new TransactionalSavings();
            $data->pilgrims_id = $id;
            $data->nominal = $request->input('nominal');
            $data->type = $request->input('type') ? 'belum' : 'diverifikasi';
            $data->save();

            if ($data->type == 'diverifikasi') {
                $saldo = Saldo::find($data_tabungan[0]->saldo_id);
                $saldo->nominal = $data_tabungan[0]->nominal + $data->nominal;
                $saldo->save();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Setor tabungan berhasil',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
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
                ->where('transactional_savings.type', 'belum')
                ->offset($offset)->limit($limit)->get();

            return response()->json([
                'status'  => true,
                'message' => 'Data retieved successfully',
                'data' => [
                    'totalPage' => ceil(TransactionalSavings::count() / $limit),
                    'totalRows' => TransactionalSavings::count(),
                    'pageNumber' => $page,
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
                ->where('pilgrims.pilgrims_id', '=', $id)
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
            $data_tabungan = TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->where('pilgrims.pilgrims_id', '=', $id)
                ->first();
                dd($data_tabungan);

            $data_tabungan->type = $request->input('type');

            if($request->type == 'diverifikasi'){
                $saldo = Saldo::find($data_tabungan->saldo_id);
                $saldo->nominal = $saldo->nominal + $data_tabungan->nominal;
                $saldo->save();
            }

            if ($request->input('comment')) {
                $data_tabungan->comment = $request->input('comment');
            }
            $data_tabungan->save();

            return response()->json([
                'status'  => true,
                'message' => 'Sukses mengubah status',
                'data' => $data_tabungan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function data_pemberangkatan()
    {
        try {
            $data_pemberangkatan = Saldo::join('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')
                ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
                ->get();
            return response()->json([
                'status'  => true,
                'message' => response($data_pemberangkatan)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function input_pemberangkatan(Request $request, $id)
    {
        try {
            $data_pemberangkatan = new DepartureInformation();
            $data_pemberangkatan->pilgrims_id = $id;
            $data_pemberangkatan->time = $request->input('time');
            $data_pemberangkatan->save();
            return response()->json([
                'status'  => true,
                'message' => response($data_pemberangkatan)
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
}
