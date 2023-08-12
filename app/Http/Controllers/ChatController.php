<?php


namespace App\Http\Controllers;

use App\Events\ChatEvent;

class ChatController extends Controller {
  public function test_pusher() {
    event(new ChatEvent('Hi'));
  }
}