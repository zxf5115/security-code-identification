<?php
namespace App\Models;


class Fake extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'module_fakes';


  protected $hidden = [
    'password',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-16
   * ------------------------------------------
   * 对随机密码进行加密
   * ------------------------------------------
   *
   * @param [type] $password [description]
   */
  public static function setPassword()
  {
    // 超出最大int类型，拆分成两个随机数
    $password_left  = mt_rand(1, 999999999);
    $password_right = mt_rand(1, 999);

    $password = $password_left . $password_right;

    $password = str_pad($password, 12, 0, STR_PAD_LEFT);

    $slat = '297bae405511a60d4b9c7fc7f3ae3a90';

    $password = $password . '|' . $slat;

    $password = base64_encode($password);

    $slat = '47ae9b6e2a72d187d0442c989d2913ae';

    $password = $password . '|' . $slat;

    $result = urlencode($password);

    $response = self::where(['password' => $result])->first();

    if(!empty($response))
    {
      return self::setPassword();
    }


    return $result;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-16
   * ------------------------------------------
   * 对数据库密码进行解密
   * ------------------------------------------
   *
   * @param [type] $password [description]
   * @return [type]
   */
  public static function getPassword($password)
  {
    $slat = '297bae405511a60d4b9c7fc7f3ae3a90';

    $password = $password . '|' . $slat;

    $password = base64_decode($password);

    $slat = '47ae9b6e2a72d187d0442c989d2913ae';

    $password = $password . '|' . $slat;

    $response = urldecode($password);

    return substr($response, 0, strpos($response, '|'));
  }




  public function categorys()
  {
    return $this->hasOne('App\Models\Fake\Category', 'id', 'category');
  }


  public function childCategorys()
  {
    return $this->hasOne('App\Models\Fake\Category', 'id', 'child_category');
  }


  public function factorys()
  {
    return $this->hasOne('App\Models\Factory', 'id', 'factory');
  }

  public function countrys()
  {
    return $this->hasOne('App\Models\Country', 'id', 'country');
  }

  public function import()
  {
    return $this->hasOne('App\Models\Fake\Import', 'id', 'import_id');
  }
}
