<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\TraitClass\SearchScopeTrait;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 基础模型类
 */
class BaseModel extends Model
{
  use SearchScopeTrait;


  // 是否由模型去维护时间戳字段，如果我们想手动去维护，可以设置为 false
  public $timestamps = true;


  /**
   * mass assignment 的时候可以批量设置的属性，目的是防止用户提交我们不想更新的字段
   * 注意：
   *      和 $guarded 同时使用的时候， $guard 设置的会无效
   */
  protected $fillable = [];


  /**
   * 其中一个用法，根据现有某几个属性，计算出新属性，并在 模型 toArray 的时候显示
   * usage：
   *      模型里面定义： protected $appends = ['full_name'];
   *      public function getFullNameAttribute() { return $this->firstName . ' ' . $this->lastName; }
   */
  protected $appends = [];


  /**
   * 隐藏的属性，我们调用模型的 toArray 方法的时候不会得到该数组中的属性，
   * 如果需要也得到隐藏属性，可以通过 withHidden 方法
   */
  protected $hidden = [];


  /**
   * 需要进行时间格式转换的字段
   * 应用场景：
   *      一般情况我们只定义了 created_at、updated_at，我们还可能会保存用户注册时间这些，register_time，
   *      这样我们就可以定义，protected $dates = ['register_time'];
   * 好比如：
   *      我们定义的 $dateFormat 为 mysql 的 datetime 格式，我们即使把 register_time 设置为 time(),
   *      实际保存的其实是 datetime 格式的
   */
  protected $dates = [];

  /**
   * created_at、updated_at、$dates数组 进行时间格式转换的时候使用的格式
   * 默认使用 mysql 的 datetime 类型，如果需要更改为 10 位整型，可以设置 protected $dateFormat = 'U';
   */
  protected $dateFormat = 'U';


  /**
   * 创建时间戳字段名称
   */
  const CREATED_AT = 'create_time';

  /**
   * 更新时间戳字段名称
   */
  const UPDATED_AT = 'update_time';

  /**
   * 状态常量： 正常
   */
  const STATUS_ACTIVE   = 1;

  /**
   * 状态常量： 禁用
   */
  const STATUS_INACTIVE = 2;

  /**
   * 状态常量： 删除
   */
  const STATUS_DELETE   = -1;


  /**
   * 转换属性类型
   */
  protected $casts = [
    'status' => 'array',
    'create_time' => 'datetime:Y-m-d H:i:s',
    'update_time' => 'datetime:Y-m-d H:i:s',
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 状态属性类型转换函数
   * ------------------------------------------
   *
   * 状态属性类型转换函数
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  protected function getStatusAttribute($value)
  {
    $status = [
      self::STATUS_ACTIVE   => '正常',
      self::STATUS_INACTIVE => '禁用',
      self::STATUS_DELETE   => '删除',
    ];

    return $status[$value];
  }


}
