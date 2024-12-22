<?php
//后台绑定域名
$admin_domain = env('ADMIN_URL','');
$admin_path='admin';
/*****************无需验证中间件**********************/
//无需验证权限，或者里面验证

if ($admin_domain) {

    $route = Route::domain($admin_domain);
} else {
    $route = Route::prefix($admin_path ?: '/admin/');
}
$route->name('admin.')->group(function ($route) {
    $route->get('/login', 'LoginController@showLoginForm')->name('login');
    $route->post('login', 'LoginController@login')->name('post.login');
    $route->get('logout', 'LoginController@logout')->name('logout');
});

/*****************验证中间件**********************/
$route->middleware(['admin_auth', 'admin_check'])->name('admin.')->group(function ($route) {
    $route->get('home', 'HomeController@console')->name('home.console');
    $route->get('clear/cache', 'HomeController@clearCache')->name('home.clear.cache');
    $route->get('/', 'HomeController@index')->name('home');
    $route->get('/admin_plugin/{ename}', 'HomeController@plugin')->name('home.plugin');

    $route->any('upload/{type}', ['uses' => 'FileUploadController@handle'])->name('upload');
    $route->any('icon', ['uses' => 'IconController@index'])->name('icon');
    $route->any('error/{code}', ['uses' => 'ErrorController@index'])->name('error');
    $route->any('excel/import', ['uses' => 'ExcelController@import'])->name('excel.import');

    //增删改查存放的控制器数组
    $resource = [
        'AdminController',
        'AdminRoleController',
        'AdminPermissionController',
        'BannerController',
        'NewsController',
        'FakeController',
        'News\CategoryController',
        'Fake\CategoryController',
        'Fake\ImportController',
        'System\IptableController',
    ];
    if(env('OPEN_PLUGIN',1))
    {
        $resource[]='PluginController';
    }
    //需要批量操作，会注册导入导出
    $more_add_controller = [
        'Fake\ImportController',
    ];
    //只需要首页的控制器
    $only_index_controller = [
        'OpinionController',
        'MemberController',
        'Fake\RecordController',
        'System\BehaviorsLogController',
    ];
    //只有添加页码的控制器
    $only_add_controller = [
        'System\ConfigController'
    ];


    //管理员修改密码
    $route->get('admin/password', 'AdminController@password')->name("admin.password");
    $route->post('admin/password', 'AdminController@passwordPost')->name("admin.password_post");


    $route->get('fake/export', 'FakeController@export')->name("fake.export");


    foreach ($resource as $c) {
        $prefix = '';
        if(strpos($c, '\\'))
        {
            $co = $c;
            list($prefix, $c) = explode('\\', $c);
        }

        //自动获取
        $controller = str_replace('Controller', '', $c);
        $controller_path = strtolower($controller);
        $prefix_path=$controller_path;
        //插件如果绑定域名，会冲突，需要改下路径
        if(in_array($c,['PluginController'])){
            $prefix_path='adminplugin';
        }

        if(!empty($prefix))
        {
            $prefix_lower = strtolower($prefix);
            $controller_path = $prefix_lower . '.' . $controller_path;

            $prefix_path = $prefix_lower . '/' . $prefix_path;

            $c = $co;
        }

        $route->group(['prefix' => $prefix_path . '/'], function ($route) use ($c, $controller_path) {
            $route->get('/', $c . '@index')->name($controller_path . ".index");

            $route->get('create', $c . '@create')->name($controller_path . ".create");
            $route->get('show/{id}', $c . '@show')->name($controller_path . ".show");
            $route->post('store', $c . '@store')->name($controller_path . ".store");
            $route->get('edit/{id}', $c . '@edit')->name($controller_path . ".edit");
            $route->put('update/{id}', $c . '@update')->name($controller_path . ".update");
            $route->put('delete/', $c . '@destroy')->name($controller_path . ".destroy");
            $route->post('edit_list/', $c . '@editTable')->name($controller_path . ".edit_list");
        });

        $route->any($controller_path . '/list', ['uses' => $c . '@getList'])->name($controller_path . ".list");

        //增加批量操作
        if (in_array($c, $more_add_controller)) {
            $route->get($controller_path . '/all/create', ['uses' => $c . '@allCreate'])->name($controller_path . '.all_create');
            $route->post($controller_path . '/all/create/post', ['uses' => $c . '@allCreatePost'])->name($controller_path . '.all_create_post');
        }
        //导入操作
        if (in_array($c, $more_add_controller)) {
            $route->post($controller_path . '/import/post', ['uses' => $c . '@importPost'])->name($controller_path . '.import_post');
            $route->get($controller_path . '/import/tpl', ['uses' => $c . '@importTpl'])->name($controller_path . '.import_tpl');
        }

    }


    foreach ($only_index_controller as $c) {
        $prefix = '';
        if(strpos($c, '\\'))
        {
            $co = $c;
            list($prefix, $c) = explode('\\', $c);
        }

        $controller = str_replace('Controller', '', $c);
        $controller_path = strtolower($controller);

        if(!empty($prefix))
        {
            $prefix_lower = strtolower($prefix);
            $controller_path = $prefix_lower . '.' . $controller_path;

            $prefix_path = $prefix_lower . '/' . $prefix_path;

            $c = $co;
        }




        $route->group(['prefix' => $controller_path . '/'], function ($route) use ($c, $controller_path) {
            $route->get('/', $c . '@index')->name($controller_path . ".index");
            $route->any('/list', ['uses' => $c . '@getList'])->name($controller_path . ".list");
            $route->put('/delete', $c . '@destroy')->name($controller_path . ".destroy");
        });

    }
    foreach ($only_add_controller as $c) {
        if(strpos($c, '\\'))
        {
            $co = $c;
            list($prefix, $c) = explode('\\', $c);
        }

        $controller = str_replace('Controller', '', $c);
        $controller_path = strtolower($controller);

        if(!empty($prefix))
        {
            $prefix_lower = strtolower($prefix);
            $controller_path = $prefix_lower . '.' . $controller_path;

            $prefix_path = $prefix_lower . '/' . $prefix_path;

            $c = $co;
        }

        $route->group(['prefix' => $controller_path . '/'], function ($route) use ($c, $controller_path) {
            $route->any('/', $c . '@index')->name($controller_path . ".index");
            $route->post('store', $c . '@store')->name($controller_path . ".store");
            $route->any('/list', ['uses' => $c . '@getList'])->name($controller_path . ".list");
        });

    }

});
