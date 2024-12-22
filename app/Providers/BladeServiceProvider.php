<?php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use App\Models\System\Config;

/**
 * 模板服务
 */
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 语音
         */
        Blade::directive('language', function($name,$param=[]) {

            if(empty($param))
            {
                return  "<?php echo __('website.'.$name)?>";
            }else
            {
                return  "<?php echo __('website.'.$name,$param)?>";
            }

        });


        /**
         * 系统核心基础信息
         */
        Blade::directive('basic', function($name) {

            return Config::getValue($name);

        });


        /**
         * 插件资源引用
         */
        Blade::directive('plugin_res', function($name) {
            return  "<?php echo plugin_res($name)?>";
        });
    }
}
