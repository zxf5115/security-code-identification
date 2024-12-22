<?php
namespace App\Models\System;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 系统配置模型类
 */
class Config extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'system_config';


  public static function config($field='')
  {
    $key='system_config';

    if($field)
    {
      $key=$key.'.'.$field;
    }

    return config_cache($key);

  }


  public static function field($fields=[])
  {
    if (sizeof($fields)>0)
    {
      return self::whereIn('ename',$fields)->pluck('content','ename');
    }

    return self::pluck('content','ename');
  }


  public static function getValue($field='')
  {
    if ($field)
    {
      $response = self::where('ename',$field)->pluck('content');

      return $response[0] ?: '';
    }

    return '';
  }
}
