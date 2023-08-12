<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
  use InteractsWithSockets, SerializesModels;

  public $message;
  public function __construct($message)
  {
    $this->message = $message;
  }

  public function broadcastOn()
  {
    return ['my-channel'];
  }
  public function broadcastAs() {
    return 'ChatEvent';
  }
}

