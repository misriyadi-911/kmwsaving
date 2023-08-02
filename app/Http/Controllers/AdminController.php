<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pilgrims;
use App\Models\Saldo;
use App\Models\TransactionalSavings;
use Illuminate\Http\Request;

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

    public function dashboard ()
    {
        try {
            // $jml_saldo = Saldo::select('nominal', \DB::raw('SUM(nominal) as total_saldo'))->get();
            $total_saldo = \DB::select("SELECT SUM(saldo.nominal) AS total FROM saldo");
            $jml_jamaah  = \DB::select("SELECT COUNT(pilgrims.pilgrims_id) AS jml_jamaah FROM pilgrims");
            $jml_verified = \DB::select("SELECT COUNT(transactional_savings.type) AS terverfikasi FROM transactional_savings WHERE transactional_savings.type='diverifikasi'");
            return response()->json([
                'status'  => true,
                'message' => response([$total_saldo, $jml_jamaah, $jml_verified])
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function data_tabungan ()
    {
        // $exist = DB::select("SELECT kimias.*, ponds.name as pond_name FROM kimias INNER JOIN ponds ON kimias.pond_id = ponds.id WHERE kimias.id = $id");
        try {
            // $jml_saldo = Saldo::select('nominal', \DB::raw('SUM(nominal) as total_saldo'))->get();
            $data_tabungan= Saldo::join('pilgrims', 'saldo.pilgrims_id', '=', 'pilgrims.pilgrims_id')
            ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')->get();
            return response()->json([
                'status'  => true,
                'message' => response($data_tabungan)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function detail_tabungan ($id)
    {
        // $exist = DB::select("SELECT kimias.*, ponds.name as pond_name FROM kimias INNER JOIN ponds ON kimias.pond_id = ponds.id WHERE kimias.id = $id");
        try {
            // $jml_saldo = Saldo::select('nominal', \DB::raw('SUM(nominal) as total_saldo'))->get();
            $data_tabungan= \DB::select("SELECT saldo.*, pilgrims.*, saving_categories.* FROM saldo 
            INNER JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
            INNER JOIN saving_categories ON pilgrims.saving_category_id = saving_categories.saving_category_id WHERE pilgrims.pilgrims_id = '$id'");
            return response()->json([
                'status'  => true,
                'message' => response($data_tabungan)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function setor_tabungan (Request $request, $id)
    {
        try {
            // $jml_saldo = Saldo::select('nominal', \DB::raw('SUM(nominal) as total_saldo'))->get();
            $data_tabungan= \DB::select("SELECT saldo.nominal, pilgrims.bank_account_name, pilgrims.address, pilgrims.saving_category_id FROM saldo 
            INNER JOIN pilgrims ON saldo.pilgrims_id = pilgrims.pilgrims_id 
            WHERE pilgrims.pilgrims_id = '$id'");
            $data = new TransactionalSavings();
            $data->pilgrims_id = $id;
            $data->nominal = $request->input('nominal');
            $data->type = $request->input('type');
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

    public function data_verifikasi () 
    {
        try {
            // $jml_saldo = Saldo::select('nominal', \DB::raw('SUM(nominal) as total_saldo'))->get();
            $data_tabungan= TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
            ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
            ->get();
            return response()->json([
                'status'  => true,
                'message' => response($data_tabungan)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function lihat_gambar ($id) 
    {
        try {
            $data_tabungan= TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
            ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
            ->where('pilgrims.pilgrims_id', '=', $id)
            ->get();
            return response()->json([
                'status'  => true,
                'message' => response($data_tabungan)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function ganti_verifikasi (Request $request, $id) 
    {
        try {
            $data_tabungan= TransactionalSavings::join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
            ->where('pilgrims.pilgrims_id', '=', $id)
            ->first();
            $data_tabungan->type = 'diverifikasi';
            $data_tabungan->save();
            return response()->json([
                'status'  => true,
                'message' => response($data_tabungan)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function data_pemberangkatan () 
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
