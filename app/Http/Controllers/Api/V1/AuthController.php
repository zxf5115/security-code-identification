<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Dingo\Api\Http\Request;

// use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Auth as UserModel;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;



/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-24
 *
 * 接口用户认证控制器类
 */
class AuthController extends ApiController
{
  protected $guard = 'api';



  /**
   * @api {post} /api/v1/user/register 用户注册
   * @apiDescription 用户注册，邮箱和用户名不能重复吗
   * @apiGroup Auth
   * @apiParam {string} username 用户名
   * @apiParam {string} nickname 昵称
   * @apiParam {string} password 密码
   * @apiUse Success
   * @apiSampleRequest /api/v1/user/register
   * @apiVersion 1.0.0
   */
  public function register(Request $request)
  {
    try
    {
      $rules = [
        'username' => ['required', 'unique:module_member', 'regex:/^1[345789][0-9]{9}$/'],
        'nickname' => ['required'],
        'password' => ['required', 'min:6', 'max:16'],
      ];

      Log::info('参数', [$request->all(), __METHOD__]);

      $data = [
        'username' => $request->post('username'),
        'nickname' => $request->post('nickname'),
        'password' => $request->post('password'),
      ];

      Log::info('参数', [$data, __METHOD__]);

      $payload = $request->only('username', 'nickname', 'password');
      $validator = Validator::make($payload, $rules);

      // 验证格式
      if ($validator->fails())
      {
        Log::error($validator->errors(), [__METHOD__]);

        return $this->responseJson(3000, $validator->errors());
      }

      // 创建用户
      $result = UserModel::create([
          'username' => $payload['username'],
          'nickname' => $payload['nickname'],
          'password' => bcrypt($payload['password']),
      ]);

      if ($result)
      {
        return $this->responseJson(0, '创建用户成功');
      }
      else
      {
        return $this->responseJson(3001, '创建用户失败');
      }
    }
    catch (ValidatorException $e)
    {
      Log::error($e,[__METHOD__]);

      return $this->responseJson(3001, $e->getMessageBag());
    }
  }


  /**
   * @api {post} /api/v1/user/login 用户登录
   * @apiDescription 用户登录，登录成功后会放回对应的jwt token
   * @apiGroup Auth
   * @apiParam {string} username 用户名
   * @apiParam {string} password 密码
   * @apiDefine Success
   * @apiUse Success
   * @apiSampleRequest /api/v1/user/login
   * @apiVersion 1.0.0
   */
  public function login(Request $request)
  {
    try
    {
      $username = $request->post('username');
      $password = $request->post('password');

      $user = UserModel::where(['username' => $username])->first();

      if (!$user)
      {
        return $this->responseJson(3002, '该用户没有注册');
      }

      $data = [
        'username' => $user->username,
        'password' => $password,
      ];

      if (!$token = auth('api')->attempt($data))
      {
        return $this->responseJson(3004, '账号或密码不正确');
      }

      return $this->respondWithToken($token);
    }
    catch (\Exception $e)
    {
      Log::error($e,[__METHOD__]);
      return $this->ex_response($e, 3003, '登录失败');
    }
  }


  /**
   * @api {post} /api/v1/user/logout 用户登出
   * @apiDescription  用户登出 使令牌token失效。
   * @apiGroup Auth
   * @apiPermission jwt
   * @apiUse jwt
   * @apiUse Success
   * @apiSampleRequest /api/v1/user/logout
   * @apiVersion 1.0.0
   */
  public function logout()
  {
    try
    {
      auth('api')->invalidate(); //令牌失效

      return $this->responseJson(0,'登录成功');
    }
    catch (\Exception $e)
    {
      Log::error($e,[__METHOD__]);
      return $this->ex_response($e, 9999, '获取失败');
    }
  }



  /**
   * @api {get} /api/v1/user/change 修改密码
   * @apiDescription 忘记密码，修改密码
   * @apiGroup Center
   * @apiParam {string} username 用户名
   * @apiParam {string} password 密码
   * @apiUse Success
   * @apiSampleRequest /api/v1/user/change
   * @apiVersion 1.0.0
   */
  public function change(Request $request)
  {
    try
    {
      $rules = [
        'username' => ['required', 'regex:/^1[345789][0-9]{9}$/'],
        'password' => ['required', 'min:6', 'max:16'],
      ];

      Log::info('参数', [$request->all(), __METHOD__]);

      $data = [
        'username' => $request->post('username'),
        'password' => $request->post('password'),
      ];

      Log::info('参数', [$data, __METHOD__]);

      $payload = $request->only('username', 'password');
      $validator = Validator::make($payload, $rules);

      // 验证格式
      if ($validator->fails())
      {
        Log::error($validator->errors(), [__METHOD__]);

        return $this->responseJson(3000, $validator->errors());
      }

      $user = UserModel::where(['username' => $data['username']])->first();

      if (!$user)
      {
        return $this->responseJson(3002, '该用户没有注册');
      }

      $user->password = bcrypt($data['password']);
      $result = $user->save();

      if($result)
      {
        return $this->responseJson(0, '密码修改成功');
      }
      else
      {
        return $this->responseJson(3001, '密码修改失败');
      }
    }
    catch (\Exception $e)
    {
      Log::error($e, [__METHOD__]);

      return $this->responseJson(3001, $e->getMessage());
    }
  }



  /**
   * @api {post} /api/v1/user/center 账号信息
   * @apiDescription 账号信息，验证jwt 是否有效
   * @apiGroup Center
   * @apiPermission jwt
   * @apiUse jwt
   * @apiUse Success
   * @apiSampleRequest /api/v1/user/center
   * @apiVersion 1.0.0
   */
  public function center()
  {
    try
    {
      $id = auth('api')->user()->id;

      $user = UserModel::find($id);

      return $this->responseJson(0, '获取成功', $user);
    }
    catch (\Exception $e)
    {
      Log::error($e,[__METHOD__]);
      return $this->ex_response($e, 9999, '获取失败');
    }
  }


  /**
   * @api {get} /api/v1/user/refresh 刷新jwt token
   * @apiDescription  刷新jwt token
   * @apiGroup Auth
   * @apiPermission jwt
   * @apiUse jwt
   * @apiUse Success
   * @apiSampleRequest /api/v1/user/refresh
   * @apiVersion 1.0.0
   */
  public function refresh()
  {
    try
    {
      return $this->respondWithToken(auth('api')->refresh());
    }
    catch (\Exception $e)
    {
      Log::error($e,[__METHOD__]);
      return $this->ex_response($e, 9999, '获取失败');
    }
  }



  protected function respondWithToken($token)
  {
    $data = [
      'token_type' => 'Bearer',
      'access_token' => $token,
      'expires_in' => auth('api')->factory()->getTTL() * 60
    ];

    return $this->responseJson(0, '登录成功', $data);
  }
}
