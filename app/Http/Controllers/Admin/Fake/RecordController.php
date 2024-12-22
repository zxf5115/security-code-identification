<?php
namespace App\Http\Controllers\Admin\Fake;

use App\Models\Fake;
use App\Models\Fake\Record;
use App\Models\Fake\Category;
use App\Http\Controllers\Admin\BaseDefaultController;

class RecordController extends BaseDefaultController
{
  public $pageName='防伪码查询';

  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    $item->good_id = !empty($item->fake->id) ? str_pad($item->fake->id, 10, 0, STR_PAD_LEFT) : '';
    $item->category       = $item->fake->categorys->title ?? '';
    $item->child_category = $item->fake->childCategorys->title ?? '';

    $item->nickname = $item->member->nickname ?? '';

    $item->valid_time     = $item->fake->valid_time ?? '';
    $item->security_code     = $item->fake->security_code ?? '';
// dd($item->member);
    return $item;
  }


  public function setModel()
  {
    return $this->model=new Record();
  }


}
