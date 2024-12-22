<?php
namespace App\TraitClass;

use App\Events\BehaviorLogEvent;

trait LogTrait
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-03-07
   * ------------------------------------------
   * 记录用户行为
   * ------------------------------------------
   *
   * 记录用户行为
   *
   * @return [type]
   */
  public static function behavior($message)
  {
    event(new BehaviorLogEvent($message));
  }
}
