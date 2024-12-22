<?php
namespace App\Models\News;

use App\Models\BaseModel;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 新闻分类模型类
 */
class Category extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'module_news_category';


  public function news()
  {
    return $this->hasMany('App\Models\News', 'category_id', 'id');
  }
}
