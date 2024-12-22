<?php
namespace App\Models\System;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-21
 *
 * 系统防火墙模型类
 */
class Iptable extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'system_iptable';



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-21
   * ------------------------------------------
   * 获取当前被禁IP列表
   * ------------------------------------------
   *
   * 获取当前被禁IP列表
   *
   * @return 被禁IP列表
   */
  public static function getIptableList()
  {
    $iptable = self::where(['status' => 1])->get('ip_address')->toArray();
    $iptable = array_column($iptable, 'ip_address');

    return $iptable;
  }
}
