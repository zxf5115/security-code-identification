<?php


Route::get('/', 'Admin\LoginController@showLoginForm')->name('login');
//验证码
Route::get('/captcha/{type?}', 'CaptchaController@index')->name('captcha');



/*****************************************END杂项路由***********************************************/
