<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
        $data = Admin::where('employe_id', $id)->first();
        return response($data);
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
