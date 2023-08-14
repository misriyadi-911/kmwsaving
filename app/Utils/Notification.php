<?php

namespace App\Utils;

class Notification
{
  protected $pushNotification;
  private $instanceId;
  private $secretKey;

  public function __construct()
  {
    $this->instanceId = env('PUSHER_APP_INSTANCE_ID');
    $this->secretKey = env('PUSHER_APP_SECRET_KEY');
  }

  public function init()
  {
    $this->pushNotification = new \Pusher\PushNotifications\PushNotifications([
      'instanceId' => $this->instanceId,
      'secretKey' => $this->secretKey,
    ]);
  }

  public function sendNotification($userId, $title, $body)
  {
    $this->init();
    $this->pushNotification->publishToInterests(
      [$userId],
      [
        'web' => [
          'notification' => [
            'title' => $title,
            'body' => $body,
          ]
        ]
      ]
    );
  }


}
