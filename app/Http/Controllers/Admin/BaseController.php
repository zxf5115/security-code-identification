<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TraitClass\LogTrait;
use App\TraitClass\TreeTrait;
use App\TraitClass\RouteTrait;
use App\TraitClass\BladeTrait;
use App\TraitClass\ModelCurlTrait;

class BaseController extends Controller
{
    use RouteTrait, ModelCurlTrait, LogTrait, BladeTrait,TreeTrait;

    public $routeInfo;//路由信息
    public $module = 'Admin';//模块名字
    public $route;
    public $guardName='admin';//认证类型admin

    //
    public function __construct()
    {
        $this->routeInfo = $this->routeInfo($this->module);

        //共享路由信息到变量
        $this->shareView($this->routeInfo);

        $this->getBlade();
        $this->setModel();


    }

    /**
     * 404页面
     */
    public function blade404($message = '')
    {
        return abort(404, $message);
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
