<?php
namespace App\Models;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 意见反馈模型类
 */
class Opinion extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'module_opinion';

  protected $fillable = [
    'user_id',
    'title',
    'content',
    'mobile',
  ];



  public function member()
  {
    return $this->hasOne('App\Models\Member', 'id', 'user_id');
  }
}
