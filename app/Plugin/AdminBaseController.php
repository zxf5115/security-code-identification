<?php

namespace App\Plugin;

use App\Models\System\BehaviorsLog;
use App\TraitClass\BladeTrait;
use App\TraitClass\ModelCurlTrait;
use App\TraitClass\LogTrait;

use App\TraitClass\TreeTrait;

class AdminBaseController extends PluginController
{
    use ModelCurlTrait, LogTrait, BladeTrait,TreeTrait;
    public function __construct()
    {
       parent::__construct();
       //中间件限制，需要登录
        $this->middleware(['install', 'admin_auth', 'admin_check']);
        //共享路由信息到变量
        $this->shareView($this->routeInfo);
        $this->getBlade();
        $this->setModel();

    }

    /**
     * 模板输出
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display($data = [])
    {

        //取得表名
        $this->getTable();
        $this->pageName();
        $this->commonBlade();

        return view($this->bladePrefix.$this->bladeView, $data);
    }


}
