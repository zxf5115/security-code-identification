<?php
namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;

use App\Models\System\Config;
use App\Http\Controllers\Admin\BaseDefaultController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 行为日志控制器类
 */
class ConfigController extends BaseDefaultController
{
  public $pageName = '系统配置';

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-18
   * ------------------------------------------
   * 显示
   * ------------------------------------------
   *
   * @return [type]
   */
  public function index()
  {
    $config_name = \request()->input('type','config');

    $config = config_cache($config_name,$config_name);
    $config = is_array($config) ? $config : [];

    return $this->display($config);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-18
   * ------------------------------------------
   * 更新
   * ------------------------------------------
   *
   * @return [type]
   */
  public function store(Request $request)
  {
    $config_name = $request->input('type','config');

    config_cache($config_name,  $config_name, $request->all());

    self::behavior('系统配置更新成功');

    return $this->returnOkApi('设置成功');
  }



  public function setModel()
  {
    return new Config();
  }

}
