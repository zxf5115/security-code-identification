<?php
namespace App\Http\Controllers\Api\V1;

use Validator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Models\Banner as BannerModel;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class BannerController extends ApiController
{
    /**
     * @api {post} /api/v1/banner/list 广告列表
     * @apiDescription 广告列表
     * @apiGroup Banner
     * @apiPermission jwt
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/banner/list
     * @apiVersion 1.0.0
     */
    public function list(Request $request)
    {
      try
      {
        $result = BannerModel::where(['status' => 1, 'is_show' => 1])->limit(4)->get()->toArray();

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
     * @api {post} /api/v1/banner/detail 广告详情
     * @apiDescription 广告详情
     * @apiGroup Banner
     * @apiPermission jwt
     * @apiParam {int} id 广告编号
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/banner/detail
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

        $result = BannerModel::find($id);

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
