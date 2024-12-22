<?php
namespace App\Http\Controllers\Api\V1;

use Validator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Models\Opinion as OpinionModel;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class OpinionController extends ApiController
{
    /**
     * @api {post} /api/v1/user/feedback 用户反馈
     * @apiDescription 用户注册，邮箱和用户名不能重复吗
     * @apiGroup Feedback
     * @apiPermission jwt
     * @apiParam {string} title 反馈标题
     * @apiParam {string} content 反馈内容
     * @apiParam {string} mobile 联系方式
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/feedback
     * @apiVersion 1.0.0
     */
    public function feedback(Request $request)
    {
      try
      {
        $rules = [
          'title' => ['required', 'max:100'],
          'content' => ['required'],
          'mobile' => ['regex:/^1[345789][0-9]{9}$/'],
        ];

        $data = [
          'title'   => $request->post('title'),
          'content' => $request->post('content'),
          'mobile'  => $request->post('mobile'),
        ];

        Log::info('参数', [$data, __METHOD__]);

        $payload = $request->only('title', 'content', 'mobile');
        $validator = Validator::make($payload, $rules);

        // 验证格式
        if ($validator->fails())
        {
          Log::error($validator->errors(), [__METHOD__]);

          return $this->responseJson(3000, $validator->errors());
        }

        $result = OpinionModel::create([
          'user_id' => auth('api')->user()->id,
          'title'   => $payload['title'],
          'content' => $payload['content'],
          'mobile'  => $payload['mobile'],
        ]);

        if($result)
        {
          return $this->responseJson(0, '提交成功');
        }
        else
        {
          return $this->responseJson(3001, '提交失败');
        }
      }
      catch (\Exception $e)
      {
        Log::error($e, [__METHOD__]);

        return $this->responseJson(3001, $e->getMessage());
      }
    }


  }
