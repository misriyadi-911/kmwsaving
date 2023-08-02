<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    protected $file;
    public function __construct(Files $file)
    {
        $this->file = $file;
    }

    public function index()
    {
        $data = Files::All();
        return response($data);
    }

    public function store(Request $request)
    {
        try {
            $exist = Files::where('user_id', $request->input('user_id'))->where('name', $request->input('name'))->first();
            if ($exist) {
                if (file_exists($exist->file)) {
                    unlink($exist->file);
                }
                $exist->delete();
            }

            $data = new Files();
            $data->user_id = $request->input('user_id');
            $data->name = $request->input('name');
            $file = $request->file('file');
            $filename = time()**2 . '.' . $file->getClientOriginalExtension();
            $request->file('file')->move('uploads/files/jamaah/', $filename);
            $data->file = 'uploads/files/jamaah/' . $filename;

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
}
