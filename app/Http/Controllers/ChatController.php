<?php


namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;

class ChatController extends Controller {
  public function test_pusher(Request $request) {

    $chat = new ChatEvent($request->messagge);
    $chat->broadcastOn();
    event($chat);
  }
}