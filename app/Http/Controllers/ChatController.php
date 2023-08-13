<?php


namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller {
  public function test_pusher() {
    Broadcast::channel('chat', function ($user) {
      return true;
    });
    event(new ChatEvent('Hi'));
  }
}