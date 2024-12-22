<?php
namespace App\Models\System;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 上传文件模型类
 */
class File extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'system_files';


  public static function add($data)
  {
    $m=new self();

    foreach ($data as $k=>$v)
    {
      $m->$k=$v;
    }

    $r=$m->save();

    if($r)
    {
      return true;
    }

    return false;
  }
}
