<?php
namespace App\Http\Controllers\Admin\System;

use App\Models\System\Iptable;
use App\Http\Controllers\Admin\BaseDefaultController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-21
 *
 * 系统防火墙控制器类
 */
class IptableController extends BaseDefaultController
{
  public $pageName = '系统防火墙';


  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    $item['edit_url'] = action($this->route['controller_name'] . '@edit', ['id' => $item->id]);
    $item['edit_post_url'] = action($this->route['controller_name'] . '@update', ['id' => $item->id]);

    return $item;
  }


  /**
     * 表单验证规则
     * @param string $id
     * @return array
     */
    public function checkRule($id = '')
    {
      return [
        'ip_address' => 'required',
      ];
    }

    /**
     * 设置检验对应字段的名字输出
     * @return array
     */
    public function checkRuleField(){
      $messages = [
        'ip_address' => 'IP地址',
      ];

      return $messages;
    }


  /**
   * 创建/更新共享数据
   * @param string $id
   * @return array
   */
  public function createEditData($id='')
  {
    return [];
  }





  public function setModel()
  {
    return $this->model = new Iptable();
  }

}
