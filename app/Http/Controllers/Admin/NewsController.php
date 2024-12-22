<?php
namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\News\Category;

class NewsController extends BaseDefaultController
{
  public $pageName='新闻';

  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    $item['edit_url'] = action($this->route['controller_name'] . '@edit', ['id' => $item->id]);
    $item['edit_post_url'] = action($this->route['controller_name'] . '@update', ['id' => $item->id]);

    $item->category = $item->category->pluck('title')->toArray();

    return $item;
  }


  public function setModel()
  {
    return $this->model=new News();
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
      ];
    }

    return [
      'title' => 'required',
      'content' => 'required',
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


  /**
   * 创建/更新共享数据
   * @param string $id
   * @return array
   */
  public function createEditData($id='')
  {
    $categorys = Category::get()->toArray();

    $categorys = $this->tree($categorys);

    return ['categorys' => $categorys];
  }
}
