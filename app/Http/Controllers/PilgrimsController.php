<?php

namespace App\Http\Controllers;

use App\Models\DepartureInformation;
use App\Models\Pilgrims;
use App\Models\Saldo;
use App\Models\TransactionalSavings;
use Illuminate\Http\Request;

class PilgrimsController extends Controller
{
    protected $pilgrim;

    public function __construct(Pilgrims $pilgrim)
    {
        $this->pilgrim = $pilgrim;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request()->all();
        $page = isset($request['page']) ? $request['page'] : 1;
        $request['limit'] = isset($request['limit']) ? $request['limit'] : 10;
        $offset = ($page - 1) * $request['limit'];
        $data = Pilgrims::join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
            ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
            ->offset($offset)->limit($request['limit'])->get();
        return response()->json([
            'status' => true,
            'message' => 'Saving Categories Retrieved Successfully',
            'data' => [
                'totalPage' => ceil(Pilgrims::count() / $request['limit']),
                'totalRows' => Pilgrims::count(),
                'pageNumber' => $page,
                'data' => $data,
            ]
        ]);
    }

    public function dashboard()
    {
        try {
            $id = auth()->user()->user_account_id;
            $category = Pilgrims::join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')->where('pilgrims.user_account_id', $id)->first();
            $saldo = Saldo::join('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')->where('user_account.user_account_id', $id)->first();
            $deposit_avg = Pilgrims::join('transactional_savings', 'pilgrims.pilgrims_id', '=', 'transactional_savings.pilgrims_id')->where('pilgrims.user_account_id', $id)->avg('transactional_savings.nominal');
            return response()->json([
                'status' => true,
                'message' => 'Dashboard Retrieved Successfully',
                'data' => [
                    'category' => $category->name,
                    'saldo' => $saldo->nominal,
                    'deposit_avg' => $deposit_avg
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function saldo()
    {
        try {
            $id = auth()->user()->user_account_id;
            $saldo = Saldo::join('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')->where('user_account.user_account_id', $id)->first();
            return response()->json([
                'status' => true,
                'message' => 'Saldo Retrieved Successfully',
                'data' => [
                    'kategori' => $saldo->name,
                    'saldo' => $saldo->nominal
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function setor()
    {
        try {
            $id = auth()->user()->user_account_id;
            $data = TransactionalSavings::create([
                'pilgrims_id' => Pilgrims::where('user_account_id', $id)->first()->pilgrims_id,
                'nominal' => request()->input('nominal'),
                'type' => 'belum',
                'file_id' => request()->input('file_id')
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Saldo Retrieved Successfully',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function keberangkatan()
    {
        try {
            $tgl_daftar = Pilgrims::where('user_account_id', auth()->user()->user_account_id)->first()->created_at;
            $tgl_berangkat = DepartureInformation::join('pilgrims', 'departure_informations.pilgrims_id', '=', 'pilgrims.pilgrims_id')->where('pilgrims.user_account_id', auth()->user()->user_account_id)->first()->time;
            $tgl_lunas = Saldo::where('pilgrims_id', Pilgrims::where('user_account_id', auth()->user()->user_account_id)->first()->pilgrims_id)->first()->created_at;
            return response()->json([
                'status' => true,
                'message' => 'Keberangkatan Retrieved Successfully',
                'data' => [
                    'tgl_daftar' => $tgl_daftar,
                    'tgl_berangkat' => $tgl_berangkat,
                    'tgl_lunas' => $tgl_lunas,
                ]
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = new Pilgrims();
            $data->user_account_id = $request->input('user_account_id');
            $data->kode = 'PILGRIMS-' . $request->input('user_account_id');
            $data->saving_category_id = $request->input('saving_category_id');
            $data->bank_name = $request->input('bank_name');
            $data->no_rekening = $request->input('no_rekening');
            $data->nik = $request->input('nik');
            $data->no_kk = $request->input('no_kk');
            $data->bank_account_name = $request->input('bank_account_name');
            $data->gender = $request->input('gender');
            $data->phone = $request->input('phone');
            $data->address = $request->input('address');
            $data->birth_date = $request->input('birth_day');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Pilgrims::join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
                ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
                ->where('user_account.user_account_id', $id)->first();

            return response()->json([
                'status'  => true,
                'message' => 'Pilgrims Retrieved Successfully',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Pilgrims::where('pilgrims_id', $id)->first();
            $data->user_account_id = $request->input('user_account_id');
            $data->saving_category_id = $request->input('saving_category_id');
            $data->bank_name = $request->input('bank_name');
            $data->no_rekening = $request->input('no_rekening');
            $data->nik = $request->input('nik');
            $data->no_kk = $request->input('no_kk');
            $data->gender = $request->input('gender');
            $data->bank_account_name = $request->input('bank_account_name');
            $data->phone = $request->input('phone');
            $data->address = $request->input('address');
            $data->birth_date = $request->input('birth_day');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Pilgrims::where('pilgrims_id', $id)->first();
            $data->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data Berhasil Dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
