<?php

namespace App\Plugin;

use Illuminate\Http\Request;

class AdminCurlController extends AdminBaseController
{

    /**
     * 首页共享数据
     * @return array
     */
    public function indexData()
    {
        return [];
    }

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        return $this->display($this->indexData() ?: []);
    }


    /**
     * 创建视图
     * @return mixed
     */
    public function create()
    {
        return $this->display($this->createEditData() ?: []);
    }

    /**
     * POST添加
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $model = $this->getModel();
        return $this->saveData($request, $model);
    }

    /**
     * 编辑页面
     * @param $id
     */
    public function edit($id)
    {
        $show = $this->getModel()->find($id);
        if (!$show) {
            return $this->blade404('数据不存在');
        }

        view()->share('show', $show);
        return $this->display($this->createEditData($show) ?: []);
    }

    /**
     * 404页面
     */
    public function blade404($message = '')
    {
        return abort(404, $message);
    }

    /**
     * POST更新
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->getModel()->findOrFail($id);
        return $this->saveData($request, $model, $id);
    }

    /**
     * 显示输出
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $show = $this->getModel()->find($id);
        if (!$show) {
            return $this->blade404('数据不存在');
        }

        view()->share('show', $show);
        return $this->display($this->showData($show) ?: []);
    }

    /**
     * Show 显示输出变量数据
     * @return array
     */
    public function showData($show)
    {
        return [];
    }


    /**
     * 搜索模型实例化
     * @param $data
     * @return mixed
     */
    public function getSearchModel($data)
    {
        $model = $this->getModel()->getSearchModel($this->model, $data, $this->timeType);
        $model = $this->addSearchModel($model, $data, $this->timeType);
        return $model;
    }

    /**
     * 插件搜索附加
     * @param $model
     * @param $data
     * @param $type
     * @return mixed
     * 例如插件目录下新建一个目录/Vote/Services/SearchService ，然后继承插件根下的Service/SearchBaseService
     * 比如我的后台需要附加搜索添加，则实例话如下
     *  //新增搜索
     * public function addSearchModel($model, $data,$type)
     * {
     * $model=new SearchService($model,$data,$type);
     * $model=$model->returnModel();
     * return $model;
     * }
     */
    public function addSearchModel($model, $data, $type)
    {
        return $model;
    }

    /**
     * 设置搜索模型的POST数据
     * 比如需要手动追加这里附加
     * @param $data
     * @return mixed
     */
    public function setSearchParam($data)
    {

        return $data;
    }

    /**
     * 设置相关增加搜索条件或者其他的操作
     * @param $model
     * @return mixed
     */
    public function setModelAddRelaction($model)
    {
        return $model;
    }

    public function orderByName()
    {
        return $this->rq->input('sort', 'id');
    }

    public function orderByType()
    {
        return $this->rq->input('order', 'desc');
    }

    /**
     * 设置列表排序
     * @param $model
     * @param $order_id
     * @param $order_type
     * @return mixed
     */
    public function orderBy($model, $order_by_name, $order_by_type)
    {
        return $model->orderBy($order_by_name, $order_by_type)->orderBy('id', 'desc');
    }

    /**
     * JSON 列表输出项目设置
     * @param $item
     * @return mixed
     */
    public function apiJsonItem($item)
    {
        $item['edit_url'] = action($this->route['controller_name'] . '@edit', ['id' => $item->id]);
        $item['edit_post_url'] = action($this->route['controller_name'] . '@update', ['id' => $item->id]);
        $item = $this->apiJsonItemExtend($item);
        return $item;
    }

    /**
     * 继续附加
     * @param $item
     * @return mixed
     */
    public function apiJsonItemExtend($item)
    {
        return $item;
    }

    /**
     * 输出List JSON的DATA
     * @param $result
     * @return array
     */
    public function apiJsonData($result)
    {
        $narr = [];
        foreach ($result as $k => $v) {
            $v = $this->apiJsonItem($v);
            $narr[] = $v;
        }
        //dump($result->toArray());
        return $narr;
    }

    /**
     * 列表增加搜索地方
     * @param $model
     */
    public function addListSearch($model){
        return $model;
    }

    /**
     * 取得列表数据
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function getList(Request $request)
    {
        $this->rq = $request;
        $offset = $request->input('page', 1);
        $pagesize = $request->input('limit', 30);
        $offset = ($offset - 1) * $pagesize;
        $order_by_name = $this->orderByName();
        $order_by_type = $this->orderByType();
        $debug = $request->input('debug', 0);
        //如果开始没有数据，直接返回空的

        if (!$this->getModel()) {
            return $this->returnApi(200, '没有初始化模型', []);
        }
        $model = $this->getSearchModel($this->setSearchParam($request->all()));
        $model=$this->addListSearch($model);
        $total = $model->count();
        //是否是否关联数据等操作
        $model = $this->setModelAddRelaction($model);
        $model = $model->skip($offset);
        $model = $this->orderBy($model, $order_by_name, $order_by_type);
        $result = $model->take($pagesize)->get();

        //显示内容设置
        $arr_data = $this->apiJsonData($result);
        return $this->listJsonFormat($total, $arr_data, $debug);
    }

    /**
     * 列表输出JSON格式
     * @param $total
     * @param $data
     * @param $debug
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function listJsonFormat($total, $data, $debug)
    {

        $json = [
            'code' => 200,
            'msg' => $total > 0 ? '请求数据成功' : '暂无数据',
            'count' => $total,
            'data' => $data,
        ];
        if ($debug) {
            return $this->jsonDebug($json);
        }
        return response()->json($json);
    }

    /**
     * 接口数据JSON调试输出
     * @param $json
     * @return string
     */
    public function jsonDebug($json)
    {
        print_r($json);
        return '';
    }




}
