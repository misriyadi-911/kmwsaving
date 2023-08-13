<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
  use InteractsWithSockets, SerializesModels;

  public $message;
  private $user;
  public function __construct($message)
  {
    $this->message = $message;
  }

  public function broadcastOn()
  {
    return ['testing'];
  }
  public function broadcastAs() {
    return 'event';
  }

}

