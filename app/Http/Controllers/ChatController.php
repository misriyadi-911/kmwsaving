<?php


namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;

class ChatController extends Controller {
  public function test_pusher(Request $request) {
    try {
      $chat = new ChatEvent($request->messagge);
      $chat->broadcastOn();
      event($chat);
      return response()->json([
        'status' => 'success',
        'message' => 'success send message'
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => $th->getMessage()
      ], 500);
    }
  }
}