<?php
namespace App\Listeners;

use App\Events\BehaviorLogEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\System\BehaviorsLog;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-17
 *
 * 用户操作系统触发监听事件
 */
class BehaviorLogListeners
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  BehaviorLogEvent  $event
   * @return void
   */
  public function handle(BehaviorLogEvent $event)
  {
    try
    {
      $behavior = $event->behavior;

      BehaviorsLog::behavior($behavior);
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }
}
