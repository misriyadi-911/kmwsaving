<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    protected $user;
    public function __construct(UserAccount $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $data = UserAccount::All();
        return response($data);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $data = new UserAccount();
            $data->username = $request->input('username');

            $exist = UserAccount::where('username', $data->username)->first();
            if($exist){
                return response()->json([
                    'status' => false,
                    'message' => 'Username sudah digunakan'
                ], 500);
            }

            $data->email = $request->input('email');
            $data->password = app('hash')->make($request->input('password'));
            $data->type = $request->input('type') ? $request->input('type') : 'jamaah';
            if ($request->file('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/users/', $filename);
                $data->thumbnail = '/uploads/users/' . $filename;
            }
            $data->save();
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $data
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
            $data = UserAccount::where('user_account_id', $id)->get();
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil ditampilkan',
                'data' => $data
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
            $data = UserAccount::where('user_account_id', $id)->first();
            $data->username = $request->input('username') ? $request->input('username') : $data->username;
            $data->email = $request->input('email') ? $request->input('email') : $data->email;
            if($request->input('password')){
                $data->password = $data->password == $request->input('password') ? $data->password : app('hash')->make($request->input('password'));
            }
            $data->type = $request->input('type') ? $request->input('type') : $data->type;
            if ($request->file('thumbnail')) {
                $exist = $data->thumbnail;
                if ($exist) {
                    if(file_exists($exist)){
                        unlink($exist);
                    }
                }
                $file = $request->file('thumbnail');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $request->file('thumbnail')->move('uploads/users/', $filename);
                $data->thumbnail = 'uploads/users/' . $filename;
            }
            $data->save();
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diupdate',
                'data' => $data
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
            $data = UserAccount::where('user_account_id', $id)->first();
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
