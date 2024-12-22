<?php
namespace App\Http\Controllers\Api\V1;

use Validator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Models\Fake;
use App\Models\Country;
use App\Models\Factory;
use App\Models\Fake\Import;
use App\Models\Fake\Record;
use App\Models\Fake\Category;

use App\Services\GenerateServices;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class ScanController extends ApiController
{

    /**
     * @api {post} /api/v1/scan/identify 扫码识别信息
     * @apiDescription 扫码识别信息
     * @apiGroup Scan
     * @apiPermission jwt
     * @apiParam {int} user_id 当前扫描用户编号
     * @apiParam {string} picture base64加密后的图片信息
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/scan/identify
     * @apiVersion 1.0.0
     */
    public function identify(Request $request)
    {
      //开启事务
      DB::beginTransaction();

      try
      {
        $is_password = false;

        $user_id = $request->post('user_id');
        $picture = $request->post('picture');

        if(empty($user_id))
        {
          return $this->responseJson(3001, '扫码用户不能为空');
        }

        if(empty($picture))
        {
          return $this->responseJson(3001, '识别图片不能为空');
        }

        $response = GenerateServices::parsePicture($picture);

        $id             = intval($response['id']);
        $country        = intval($response['country']);
        $factory        = intval($response['factory']);
        $category       = $response['category'];
        $check_code     = intval($response['check_code']);
        $child_category = intval($response['child_category']);
        $time_code      = $response['time_code'];

        $password       = $response['password'];

        if(strlen($password) == 12)
        {
          $is_password = true;
        }

        $model = new Fake();

        $result = $model->where(['id' => $id])
                        ->where(['country' => $country])
                        ->where(['factory' => $factory])
                        ->where(['category' => $category])
                        ->where(['check_code' => $check_code])
                        ->where(['child_category' => $child_category])
                        ->where(['time_code' => $time_code])
                        ->first();

        if(empty($result))
        {
          $message = '查无此防伪码商品';

          $data = ['user_id' => $user_id, 'message' => $message];

          Record::create($data);

          DB::commit();

          return $this->responseJson(3001, $message);
        }

        $result = $result->getAttributes();

        $valid_time = strtotime($result['valid_time']);

        if(time() > $valid_time)
        {
          $message = '此防伪码商品已过期';

          $data = ['user_id' => $user_id, 'message' => $message];

          Record::create($data);

          DB::commit();

          return $this->responseJson(3002, $message);
        }

        if(1 == $result['status'])
        {
          $message = '重复防伪码请勿购买';

          $data = ['user_id' => $user_id, 'message' => $message];

          Record::create($data);

          DB::commit();

          return $this->responseJson(3003, $message);
        }

        if($is_password)
        {
          $local_password = Fake::getPassword($result['password']);

          if($password != $local_password)
          {
            $message = '仿造防伪码请勿购买';

            $data = ['user_id' => $user_id, 'message' => $message];

            Record::create($data);

            DB::commit();

            return $this->responseJson(3004, $message);
          }
          else
          {
            $model = Fake::find($result['id']);
            $model->status = 1;
            $model->save();
          }
        }

        $import_id = $result['import_id'];
        $response = Import::find($import_id);
        $consignee = $response->consignee ?? '';
        $address = $response->address ?? '';

        $message = '此防伪码是正牌商品,销往'. $consignee .'商家，放心购买';

        $data = ['user_id' => $user_id, 'message' => $message];

        Record::create($data);

        DB::commit();

        return $this->responseJson(0, $message);
      }
      catch (\Exception $e)
      {
        DB::rollBack();

        Log::error($e, [__METHOD__]);

        return $this->responseJson(3001, '系统错误');
      }

    }
  }




//     $security_code = substr($item->security_code, 22);
//     $data = file_get_contents($security_code);
//     $data = base64_encode($data);


// echo Fake::getPassword('MTc0MjgyMDEzNHwyOTdiYWU0MDU1MTFhNjBkNGI5YzdmYzdmM2FlM2E5MA%3D%3D%7C47ae9b6e2a72d187d0442c989d2913ae');

// exit;


//     $resp = GenerateServices::parsePicture($data, 1);
// file_put_contents('1.txt', $resp);
