<?php
namespace App\Http\Controllers\Api\V1;

use Validator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Models\Country;
use App\Models\Factory;
use App\Models\Fake\Category;
use App\Models\Fake\Record as RecordModel;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class RecordController extends ApiController
{
    /**
     * @api {post} /api/v1/record/list 扫码记录列表
     * @apiDescription 扫码记录列表
     * @apiGroup Record
     * @apiPermission jwt
     * @apiParam {int} page 当前页码
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/record/list
     * @apiVersion 1.0.0
     */
    public function list(Request $request)
    {
      try
      {
        $user_id = auth('api')->user()->id;

        $page = $request->get('page') ?? 1;

        $offset = ($page - 1) * 5;

        $result = RecordModel::where(['status' => 1])->where(['user_id' => $user_id])->with('member')->offset($offset)->limit(5)->orderBy('create_time', 'desc')->get()->toArray();

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
     * @api {post} /api/v1/record/detail 扫码记录详情
     * @apiDescription 扫码记录详情
     * @apiGroup Record
     * @apiPermission jwt
     * @apiParam {int} id 记录编号
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/record/detail
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

        $result = RecordModel::find($id);

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
