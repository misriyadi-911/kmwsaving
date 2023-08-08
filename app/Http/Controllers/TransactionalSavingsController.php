<?php

namespace App\Http\Controllers;

use App\Models\TransactionalSavings;
use Illuminate\Http\Request;

class TransactionalSavingsController extends Controller
{
    private $transactional;
    public function __construct(TransactionalSavings $transactional) {
        $this->transactional = $transactional;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TransactionalSavings::All();
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $data = new TransactionalSavings();
            $data->pilgrims_id = $request->input('pilgrims_id');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = TransactionalSavings::where('transactional_savings_id', $id)->get();
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
            $data = TransactionalSavings::where('transactional_savings_id', $id)->first();
            $data->pilgrims_id = $request->input('pilgrims_id');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = TransactionalSavings::where('transactional_savings_id', $id)->first();
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
