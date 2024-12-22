<?php
namespace App\Http\Controllers\Api\V1;

use Validator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Models\System\Config;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class SystemController extends ApiController
{

    /**
     * @api {post} /api/v1/system/info 系统信息
     * @apiDescription 系统信息
     * @apiGroup System
     * @apiPermission jwt
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/system/info
     * @apiVersion 1.0.0
     */
    public function info(Request $request)
    {
      try
      {
        $result['about_me'] = Config::getValue('about_me');
        $result['mobile'] = Config::getValue('mobile');

        return $this->responseJson(0, '获取成功', $result);
      }
      catch (\Exception $e)
      {
        Log::error($e, [__METHOD__]);

        return $this->responseJson(3001, $e->getMessage());
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
