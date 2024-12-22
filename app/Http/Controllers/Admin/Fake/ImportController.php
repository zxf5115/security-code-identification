<?php
namespace App\Http\Controllers\Admin\Fake;

use App\Models\Fake\Import;
use App\Events\GenerateEvent;
use App\Http\Controllers\Admin\BaseDefaultController;

class ImportController extends BaseDefaultController
{
  public $pageName='导入商品';

  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    if(!empty($item->status) && $item->status == '禁用')
    {
      event(new GenerateEvent($item));
    }

    return $item;
  }


  public function setModel()
  {
    return $this->model=new Import();
  }


  /**
   * 表单验证规则
   * @param string $id
   * @return array
   */
  public function checkRule($id = '')
  {
    if (!$id) {
      return [
        'title' => 'required',
        'content' => 'required',
        'fouder' => 'required',
      ];
    }

    return [
      'title' => 'required',
      'content' => 'required',
      'fouder' => 'required',
    ];
  }

  /**
   * 设置检验对应字段的名字输出
   * @return array
   */
  public function checkRuleField(){
    $messages = [
      'title' => '标题',
      'content'    =>'内容',
      'fouder'    =>'发布人'
    ];

    return $messages;
  }


}
