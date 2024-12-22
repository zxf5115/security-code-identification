<?php
namespace App\Models;

use App\TraitClass\SearchScopeTrait;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 新闻模型类
 */
class News extends BaseModel
{
  /**
   * 数据库表名
   */
  protected $table = 'module_news';

    use SearchScopeTrait;


  public function category()
  {
    return $this->hasOne('App\Models\News\Category', 'id', 'category_id');
  }
}
