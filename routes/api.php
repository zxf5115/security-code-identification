<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app("Dingo\Api\Routing\Router");

$api->version('v1', function ($api) {
  $api->group(["namespace" => "App\Http\Controllers\Api\V1", "prefix" => "v1"], function ($api)
  {
    $api->post('/user/login', 'AuthController@login');
    $api->post('/user/register', 'AuthController@register');
    $api->post('/user/change', 'AuthController@change');

    $api->post('/oauth/login', 'OAuthController@login');
    $api->post('/oauth/redirect', 'OAuthController@redirect');
    $api->post('/oauth/callback', 'OAuthController@callback');


    $api->group(['middleware' => ['refresh']], function ($api) {
      $api->post('/user/center', 'AuthController@center');
      $api->post('/user/refresh', 'AuthController@refresh');
      $api->post('/user/logout', 'AuthController@logout');
      $api->post('/user/feedback', 'OpinionController@feedback');

      $api->post('/news/list', 'NewsController@list');
      $api->post('/news/detail', 'NewsController@detail');

      $api->post('/banner/list', 'BannerController@list');
      $api->post('/banner/detail', 'BannerController@detail');

      $api->post('/record/list', 'RecordController@list');
      $api->post('/record/detail', 'RecordController@detail');

      $api->post('/scan/identify', 'ScanController@identify');

      $api->post('/system/info', 'SystemController@info');
    });
  });
});
