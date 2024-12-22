<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Dingo\Api\Http\Request;

use Validator;
use Socialite;
use App\Models\Auth as UserModel;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;



/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-05-04
 *
 * 第三方用户认证控制器类
 */
class OAuthController extends ApiController
{
  protected $guard = 'api';


  /**
   * 将用户重定向到微信认证页面
   */
  public function redirect()
  {
    return Socialite::driver('wechat')->redirect();
  }


  /**
   * 从微信获取认证用户信息
   */
  public function callback()
  {
    $user = Socialite::driver('wechat')->user();

    if(!User::where('openid', $user->getId())->first())
    {
      $userModel = new UserModel();
      $userModel->openid = $user->getId();
      $userModel->nickname = $user->getName();
      $userModel->thumb = $user->getAvatar();
      $userModel->save();
    }

    $userInstance = User::where('github_id', $user->id)->firstOrFail();
    Auth::login($userInstance);
    return redirect('/home');
  }

















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
   * @api {post} /api/v1/oauth/login 第三方用户登录
   * @apiDescription 第三方用户登录，登录成功后会放回对应的jwt token
   * @apiGroup Auth
   * @apiParam {string} openid OpenID
   * @apiUse Success
   * @apiSampleRequest /api/v1/oauth/login
   * @apiVersion 1.0.0
   */
  public function login(Request $request)
  {
    try
    {
      $openid = $request->post('openid');

      $user = UserModel::where(['openid' => $openid])->first();

      if (!$user)
      {
        return $this->responseJson(3002, '该用户没有注册');
      }

      if (!$token = auth('api')->fromUser($user))
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
