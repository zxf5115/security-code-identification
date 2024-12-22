<?php
namespace App\Models\Fake;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-04-27
 *
 * 防伪码导入模型类
 */
class Import extends BaseModel
{

  /**
   * 数据库表名
   */
  protected $table = 'module_fakes_import';

  /**
   * 下载导入模板时，不显示
   */
  public $excel = [
    'id',
    'status',
    'create_time',
    'update_time'
  ];


  /**
   * 下载导入模板时，模板标题
   */
  public $sheet = [
    'country'        => '源产地',
    'factory'        => '厂家名称',
    'category'       => '产品种类',
    'child_category' => '产品名称',
    'valid_time'     => '产品保质期',
    'number'         => '生成数量',
    'consignee'      => '收货人',
    'address'        => '收货地址',
  ];

}
