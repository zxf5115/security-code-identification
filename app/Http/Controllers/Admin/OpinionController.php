<?php
namespace App\Http\Controllers\Admin;

use App\Models\Opinion;

class OpinionController extends BaseDefaultController
{
  public $pageName='意见反馈';

  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    $item->nickname = $item->member->nickname;

    return $item;
  }


  public function setModel()
  {
    return $this->model=new Opinion();
  }


  /**
   * 表单验证规则
   * @param string $id
   * @return array
   */
  public function checkRule($id = '')
  {
    return [
      'title'   => 'required',
      'content' => 'required',
      'mobile'  => 'regex:/^1[345789][0-9]{9}$/',
    ];
  }

  /**
   * 设置检验对应字段的名字输出
   * @return array
   */
  public function checkRuleField(){
    $messages = [
      'title'   => '意见标题',
      'content' =>'意见内容',
      'mobile'  =>'联系电话'
    ];

    return $messages;
  }
}
