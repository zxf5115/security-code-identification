<?php
namespace App\Models\Fake;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 防伪码分类模型类
 */
class Category extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'module_fakes_category';

  protected $fillable = ['parent_id', 'title'];
}
