<?php
namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-24
 *
 * 接口基础控制器类
 */
class ApiController extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests,Helpers;


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-24
   * ------------------------------------------
   * 响应json
   * ------------------------------------------
   *
   * @param [type] $error [description]
   * @param [type] $msg [description]
   * @param [type] $data [description]
   * @return [type]
   */
  public function responseJson($error, $msg, $data = null)
  {
    $output = [
      'error' => $error,
      'msg'   => $msg,
    ];

    if (!is_null($data))
    {
      $output['data'] = $data;
    }

    return \response()->json($output);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-24
   * ------------------------------------------
   * 异常输出
   * ------------------------------------------
   *
   * @param \Exception $ex [description]
   * @param [type] $code [description]
   * @param [type] $msg [description]
   * @return [type]
   */
  public function ex_response( \Exception $ex, $code, $msg)
  {
    $code = $ex->getCode() ? $ex->getCode() : $code;
    $msg = $ex->getMessage() ? $ex->getMessage() : $msg;

    $output = [
      'error' => $code,
      'msg'   => $msg,
    ];

    return \response()->json($output);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-04-24
   * ------------------------------------------
   * 获取登陆信息
   * ------------------------------------------
   *
   * @param string $guards [description]
   * @return [type]
   */
  public function getUser($guards='api')
  {
    try
    {
      $user = auth($guards)->user();

      Log::info('获取登录用户',[$user,$guards,__METHOD__]);

      if ($user)
      {
        return $user;
      }

      Log::error('登陆过期',[$user,$guards,__METHOD__]);

      throw new \Exception('登录过期', 1000);
    }
    catch (\Exception $ex)
    {
      Log::error($ex);

      throw new \Exception('登录过期', 1000);
    }
  }
}
