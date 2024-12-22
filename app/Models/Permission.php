<?php
namespace App\Models;

use App\TraitClass\SearchScopeTrait;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 系统配置模型类
 */
class Permission extends \Spatie\Permission\Models\Permission
{
  use SearchScopeTrait;
}
