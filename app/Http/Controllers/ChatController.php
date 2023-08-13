<?php


namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller {
  public function test_pusher(Request $request) {

    $chat = new ChatEvent($request->message);
    event($chat);
  }
}