<?php
namespace App\Http\Controllers\Admin\Fake;

use App\Models\Fake\Category;
use App\Http\Controllers\Admin\BaseDefaultController;

class CategoryController extends BaseDefaultController
{
  public $pageName='防伪码分类';


  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    $item['pid']=$item['pid'];
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
        'title' => 'required',
      ];
    }

    /**
     * 设置检验对应字段的名字输出
     * @return array
     */
    public function checkRuleField(){
      $messages = [
        'title' => '标题',
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
    $categorys = $this->getCategory()->toArray();

    $categorys = $this->tree($categorys);

    return ['categorys' => $categorys];
  }


  public function getCategory()
  {
    return Category::get();
  }


  /**
   * 设置模型
   * @return Categorys|mixed
   */
  public function setModel()
  {
    return $this->model=new Category();
  }
}
