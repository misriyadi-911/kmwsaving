<?php

namespace App\Http\Controllers;

use App\Models\Pilgrims;
use Illuminate\Http\Request;

class PilgrimsController extends Controller
{
    protected $pilgrim;
    
    public function __construct(Pilgrims $pilgrim) {
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
        $data = Pilgrims::offset($offset)->limit($request['limit'])->get();
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
            $data = new Pilgrims();
            $data->user_account_id = $request->input('user_account_id');
            $data->saving_category_id = $request->input('saving_category_id');
            $data->bank_name = $request->input('bank_name');
            $data->no_rekening = $request->input('no_rekening');
            $data->nik = $request->input('nik');
            $data->no_kk = $request->input('no_kk');
            $data->gender = $request->input('gender');
            $data->phone = $request->input('phone');
            $data->address = $request->input('address');
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
            $data = Pilgrims::where('pilgrims_id',$id)->get();
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
            $data->phone = $request->input('phone');
            $data->address = $request->input('address');
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
            $data = Pilgrims::where('pilgrims_id',$id)->first();
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
