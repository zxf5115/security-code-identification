<?php
namespace App\Models\Fake;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-27
 *
 * 防伪码记录模型类
 */
class Record extends BaseModel
{

  /**
   * 数据库表名
   */
  protected $table = 'module_fakes_record';

  protected $fillable = [
    'user_id',
    'message'
  ];

  public function member()
  {
    return $this->hasOne('App\Models\Member', 'id', 'user_id');
  }
}
