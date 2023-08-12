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
        $data = Notification::all();
        return response()->json([
            'status' => true,
            'message' => 'Notification Retrieved Successfully',
            'data' => [
                'totalPage' => ceil(Notification::count() / $request['limit']),
                'totalRows' => Notification::count(),
                'pageNumber' => intval($page),
                'unread_notif'=> $data->count(),
                'data' => $data,
            ]
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = new Notification();
            $data->user_account_id = $request->input('user_account_id');
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
            $data->message = isset(request()->message) ? request()->message : $data->message;
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

    public function showByUserAccount(Request $request, $id) {
        try {
            $limit = isset($request['limit']) ? $request['limit'] : 5;
            $offset = isset($request['page']) ? ($request['page'] - 1) * $limit : 0;
            $data = Notification::orderBy('created_at', 'DESC')->where('user_account_id', $id);
            $notifications = $data->limit($limit)->offset($offset)->get();
            return response()->json([
                'status' => true,
                'message' => 'Notification Retrieved Successfully',
                'data' => [
                    'totalRows' => $data->count(),
                    'pageNumber' => intval($request['page']),
                    'data' => $notifications,
                    'unread' => $data->where('status', 'unread')->count(),
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}


