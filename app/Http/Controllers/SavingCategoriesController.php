<?php

namespace App\Http\Controllers;

use App\Models\SavingCategories;
use Illuminate\Http\Request;

class SavingCategoriesController extends Controller
{
    protected $saving;
    public function __construct(SavingCategories $saving) {
        $this->saving = $saving;
    }

    public function index()
    {
        $data = SavingCategories::All();
        return response($data);
    }

    public function store(Request $request)
    {
        try {
            $data = new SavingCategories();
            $data->name = $request->input('name');
            $data->limit = $request->input('limit');
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
            $data = SavingCategories::where('saving_category_id', $id)->get();
            return response()->json([
                'status' => true,
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
            $data = SavingCategories::where('saving_category_id', $id)->first();
            $data->name = $request->input('name');
            $data->limit = $request->input('limit');
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
            $data = SavingCategories::where('saving_category_id', $id)->first();
            $data->delete();
            return response()->json([
                'status' => true,
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
