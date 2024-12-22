<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;
use Validator;

class AdminPermissionController extends BaseDefaultController
{
   public $pageName='权限规则';

   public function indexData()
   {
       return [];
   }

    /**
     * 表单验证
     * @param string $id
     * @return array
     */
    public function checkRule( $id='')
    {
        if (!$id) {
            return [
                'name' => 'required|unique:permissions,name',
                'cn_name' => 'required'
            ];
        }
        return [
            'name' => 'required|unique:permissions,name,' . $id,
            'cn_name' => 'required',

        ];
    }

    /**
     * 设置检验对应字段的名字输出
     * @return array
     */
    public function checkRuleField(){
        $messages = [
            'cn_name' => '权限名称',
            'name'=>'权限路由名'

        ];
        return $messages;
    }

    /**
     * 设置模型
     * @return Permission|mixed
     */
    public function setModel()
    {
        return $this->model=new Permission();
    }

    /**
     * 添加提交附加数据
     * @param $model
     * @return mixed
     */
    public function addPostData($model){
        $model->guard_name=$this->guardName;
        return $model;
    }

    /**
     * 创建/更新共享数据
     * @param string $id
     * @return array
     */
    public function createEditData($id='')
    {
        $roles = $this->getRole();// 获取所有角色
        $cate=$this->getPermission()->toArray();

        $cate = $this->tree($cate);


        return ['roles' => $roles, 'permissions' => $cate];
    }
    public function getRole()
    {
        return Role::where('guard_name', $this->guardName)->pluck('name','id');
    }


    public function getPermission()
    {
        return Permission::where('guard_name', $this->guardName)->get();
    }
    /**
     * JSON 列表输出项目设置
     * @param $item
     * @return mixed
     */
    public function apiJsonItem($item)
    {
        $item['pid']=$item['parent_id'];
        $item['edit_url'] = action($this->route['controller_name'] . '@edit', ['id' => $item->id]);
        $item['edit_post_url'] = action($this->route['controller_name'] . '@update', ['id' => $item->id]);

        return $item;
    }
}
