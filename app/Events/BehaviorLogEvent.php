<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-17
 *
 * 用户操作系统触发事件
 */
class BehaviorLogEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $behavior = '';

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($behavior)
  {
    $this->behavior = $behavior;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new PrivateChannel('channel-name');
  }
}
