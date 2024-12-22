<?php
namespace App\Http\Controllers\Api\V1;

use Validator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Models\News as NewsModel;
use App\Models\News\Category as CategoryModel;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class NewsController extends ApiController
{
    /**
     * @api {post} /api/v1/news/list 新闻列表
     * @apiDescription 世界太大了
     * @apiGroup News
     * @apiPermission jwt
     * @apiParam {int} page 当前页码
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/news/list
     * @apiVersion 1.0.0
     */
    public function list(Request $request)
    {
      try
      {
        $page = $request->get('page') ?? 1;

        $offset = ($page - 1) * 5;

        $result = CategoryModel::where(['status' => 1])
        ->with(['news' => function($query){
          $query->where(['status' => 1, 'is_issue' => 1]);
        }])
        ->offset($offset)->limit(5)->get()->toArray();

        if($result)
        {
          return $this->responseJson(0, '获取成功', $result);
        }
        else
        {
          return $this->responseJson(3000, '没有数据');
        }
      }
      catch (\Exception $e)
      {
        Log::error($e, [__METHOD__]);

        return $this->responseJson(3001, $e->getMessage());
      }
    }


    /**
     * @api {post} /api/v1/news/detail 新闻详情
     * @apiDescription 世界太大了，我们该去看看
     * @apiGroup News
     * @apiPermission jwt
     * @apiParam {int} id 新闻编号
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/news/detail
     * @apiVersion 1.0.0
     */
    public function detail(Request $request)
    {
      try
      {
        $id = $request->post('id');

        if(empty($id))
        {
          return $this->responseJson(3001, 'id不能为空');
        }

        $result = NewsModel::find($id);

        $result->category_name = $result->category->title;

        if($result)
        {
          return $this->responseJson(0, '获取成功', $result);
        }
        else
        {
          return $this->responseJson(3000, '没有数据');
        }
      }
      catch (\Exception $e)
      {
        Log::error($e, [__METHOD__]);

        return $this->responseJson(3001, $e->getMessage());
      }

    }
  }
