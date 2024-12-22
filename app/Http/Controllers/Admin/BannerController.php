<?php
namespace App\Http\Controllers\Admin;

use App\Models\Banner;

class BannerController extends BaseDefaultController
{
  public $pageName='Banner';


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
      'picture' => 'required',
    ];
  }

  /**
   * 设置检验对应字段的名字输出
   * @return array
   */
  public function checkRuleField()
  {
    $messages = [
      'picture' => 'Banner图片',
      'url' => 'URL地址',
    ];

    return $messages;
  }


  /**
   * 设置模型
   * @return Banners|mixed
   */
  public function setModel()
  {
    return $this->model = new Banner();
  }
}
