<?php
namespace App\Models\System;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 系统用户行为日志模型类
 */
class BehaviorsLog extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'system_behaviors_log';


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-18
   * ------------------------------------------
   * 记录用户操作行为信息
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param string $behavior 操作行为
   * @return 成功|失败
   */
  public static function behavior($behavior)
  {
    $model = new self();

    $model->user_id    = admin('id');
    $model->username   = admin('nickname');
    $model->behavior   = $behavior;
    $model->action     = request()->path();//操作路径
    $model->ip_address = request()->getClientIp();

    return $model->save();
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-18
   * ------------------------------------------
   * 操作行为与系统管理员关联方法
   * ------------------------------------------
   *
   * @return 关联关系
   */
  public function users()
  {
    return $this->belongsTo('App\Models\Admin','user_id','id');
  }
}

