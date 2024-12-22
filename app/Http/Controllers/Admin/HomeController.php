<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Fake\Import;
use App\Models\Fake\Record;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-27
 *
 * 控制台控制类
 */
class HomeController extends BaseController
{
    //
    public function index()
    {
        return $this->display();
    }

    public function console()
    {
        $total = Import::where(['status' => 1])->sum('number');
        $scan = Record::where(['status' => 1])->count('id');


        $month = strtotime(date('Y-m-01'));

        $total_month = Import::where(['status' => 1, ['create_time', '>=', $month]])->sum('number');
        $scan_month = Record::where(['status' => 1, ['create_time', '>=', $month]])->count('id');

        $main = ['scan' => $scan, 'scan_month' => $scan_month, 'total' => intval($total), 'total_month' => intval($total_month)];




        $monday  = strtotime('this week Monday', time());


        $week = [];
        for($i = 7; $i >= 0; $i--)
        {
            $week[] = ($monday - $i * 24 * 60 * 60);
        }

        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[0]], ['create_time', '<=', $week[1]]])->sum('number');
        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[1]], ['create_time', '<=', $week[2]]])->sum('number');
        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[2]], ['create_time', '<=', $week[3]]])->sum('number');
        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[3]], ['create_time', '<=', $week[4]]])->sum('number');
        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[4]], ['create_time', '<=', $week[5]]])->sum('number');
        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[5]], ['create_time', '<=', $week[6]]])->sum('number');
        $this_week_prod_data[] = (int)Import::where(['status' => 1, ['create_time', '>=', $week[6]], ['create_time', '<=', $week[7]]])->sum('number');

        $this_week_prod_data = json_encode($this_week_prod_data);



        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[0]], ['create_time', '<=', $week[1]]])->count('id');
        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[1]], ['create_time', '<=', $week[2]]])->count('id');
        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[2]], ['create_time', '<=', $week[3]]])->count('id');
        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[3]], ['create_time', '<=', $week[4]]])->count('id');
        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[4]], ['create_time', '<=', $week[5]]])->count('id');
        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[5]], ['create_time', '<=', $week[6]]])->count('id');
        $this_week_scan_data[] = Record::where(['status' => 1, ['create_time', '>=', $week[6]], ['create_time', '<=', $week[7]]])->count('id');

        $this_week_scan_data = json_encode($this_week_scan_data);




        $category = Import::where(['status' => 1])
                            ->select(DB::raw('sum(number) value'), 'category as name')
                            ->groupBy('category')
                            ->get()
                            ->toArray();

        $category_name = array_column($category, 'name');

        $category_name = json_encode($category_name, true);
        $category = json_encode($category, true);



        return $this->display([
            'main'                => $main,
            'this_week_prod_data' => $this_week_prod_data,
            'this_week_scan_data' => $this_week_scan_data,
            'category'            => $category,
            'category_name'       => $category_name,
        ]);
    }

    public function plugin($ename)
    {
        return $this->display(['side_menu_type' => 'plugin.' . strtolower($ename)]);
    }

    //清除缓存
    public function clearCache()
    {
        Cache::flush();;
        return $this->display();
    }

}
