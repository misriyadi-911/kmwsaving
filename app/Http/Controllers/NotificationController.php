<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notification;
    public function __construct(Notification $notification) {
        $this->notification = $notification;
    }

    public function index()
    {
        $request = request()->all();
        $page = isset($request['page']) ? $request['page'] : 1;
        $request['limit'] = isset($request['limit']) ? $request['limit'] : 5;
        $offset = ($page - 1) * $request['limit'];
        $data = Notification::where('status', 'unread')->offset($offset)->limit($request['limit'])->get();
        return response()->json([
            'status' => true,
            'message' => 'Notification Retrieved Successfully',
            'data' => [
                'totalPage' => ceil(Notification::count() / $request['limit']),
                'totalRows' => Notification::count(),
                'pageNumber' => $page,
                'unread_notif'=> $data->count(),
                'data' => $data,
            ]
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = new Notification();
            $data->pilgrims_id = $request->input('pilgrims_id');
            $data->transactional_savings_id = $request->input('transactional_savings_id');
            $data->message = $request->input('message');
            $data->save();
            return response()->json([
                'status'  => true,
                'message' => 'Notification Created Successfully',
                'data'=> $data,
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
            $data = Notification::where('notification_id', $id)->first();
            $data->status = 'read';
            $data->message = 'Pembayaran selesai';
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Notification Has Been Read',
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
        // try {
        //     $data = SavingCategories::where('saving_category_id', $id)->first();
        //     $data->name = $request->input('name');
        //     $data->limit = $request->input('limit');
        //     $data->save();
        //     return response()->json([
        //         'status'  => true,
        //         'message' => 'Data berhasil diupdate',
        //         'data' => $data
        //     ]);
            
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $th->getMessage()
        //     ], 500);
        // }
    }
}


