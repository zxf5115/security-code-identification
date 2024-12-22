<?php
namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 会员模型类
 */
class Auth extends Authenticatable implements JWTSubject
{
  /**
   * 数据库表名
   */
  protected $table = 'module_member';

  protected $dateFormat = 'U';


  /**
   * 创建时间戳字段名称
   */
  const CREATED_AT = 'create_time';

  /**
   * 更新时间戳字段名称
   */
  const UPDATED_AT = 'update_time';

  use Notifiable;

  protected $guarded = [];

  protected $hidden = [
      'password', 'status', 'create_time', 'update_time'
  ];

  public function getJWTIdentifier()
  {
      return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
      return [];
  }
}
