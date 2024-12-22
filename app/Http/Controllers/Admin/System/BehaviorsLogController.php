<?php
namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseDefaultController;

use App\Models\System\BehaviorsLog;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 行为日志控制器类
 */
class BehaviorsLogController extends BaseDefaultController
{
    public $pageName='操作日志';

    /**
     * JSON 列表输出项目设置
     * @param $item
     * @return mixed
     */
    public function apiJsonItem($item)
    {

        return $item;
    }


    public function setModel()
    {
        return $this->model = new BehaviorsLog();
    }
}
