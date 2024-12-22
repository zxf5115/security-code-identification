<?php
namespace App\TraitClass;

use App\Services\SearchServices;
use Illuminate\Support\Facades\Schema;

trait SearchScopeTrait
{
    public function scopeSortDesc($query){
        return $query->orderBy('sort','desc');
    }
    public function scopeSortAsc($query){
        return $query->orderBy('sort','asc');
    }
    public function scopeIdDesc($query){
        return $query->orderBy('id','desc');
    }
    public function scopeIdAsc($query){
        return $query->orderBy('id','asc');
    }
    public function scopeChecked($query){
        //return $query;
        return $query->where('is_checked',1);
    }
    /**
     * 范围搜索查询设置
     * @param $query 查询句柄query
     * @param array $data 需要的查询的参数数组
     * @return bool
     */
    public function scopeSearch($query, array $data)
    {

        if (empty($data)) {
            return $query;
        }

        foreach ($data as $k => $v) {

            if ($v['value'] == '' && $v['value'] != 0) {
                return false;
            }

            if ($v['type'] == '=') {
                $query->where($k, $v['value']);
            }
            if ($v['type'] == 'in') {
                $query->whereIn($k, $v['value']);
            }
            if ($v['type'] == '>') {
                $query->where($k, '>', $v['value']);
            }
            if ($v['type'] == '>=') {
                $query->where($k, '>=', $v['value']);
            }
            if ($v['type'] == '<>') {
                $query->where($k, '<>', $v['value']);
            }
            if ($v['type'] == '<') {
                $query->where($k, '<', $v['value']);
            }
            if ($v['type'] == '<=') {
                $query->where($k, '<=', $v['value']);
            }
            if ($v['type'] == 'between') {
                $query->whereBetween($k, $v['value']);
            }
            if ($v['type'] == 'raw') {
                $query->whereRaw($v['value'][0], [$v['value'][1]]);
            }
            if ($v['type'] == 'like') {
                $query->whereRaw($k . ' like ?', ["%" . $v['value'] . "%"]);
            }
            if ($v['type'] == 'right_like') {
                $query->whereRaw($k . ' like ?', [ $v['value'] . "%"]);
            }
            if ($v['type'] == 'left_like') {
                $query->whereRaw($k . ' like ?', [ "%" . $v['value'] ]);
            }
            if ($v['type'] == 'like_sql') {
                $query->whereRaw($v['value']);
            }
        }
        return $query;
    }

    /**
     * 搜索模型实列化
     * @param $model
     * @param $data
     * @param string $type
     * @return mixed
     */
    public static function getSearchModel( $model,$data, $type = '')
    {
        $search = new SearchServices($model, $data, $type);
        $search->unsetAllWhere();
        return $search->returnModel();
    }

    /**
     * 取得这个模型的字段
     * @return mixed
     */
    public function getModelField()
    {
        $table = $this->getTable();
        $data = Schema::getColumnListing($table);
        return $data;

    }
    /**
     * 搜索数组
     * @param $query
     * @param $where
     * @param $field
     * @return bool
     */
    public function scopeSearchArr($query,$where,$field){
        if($where=='')
        {
            return $query;
        }
        if(is_array($where))
        {
            return $query->whereIn($field,$where);
        }
        if(is_string($where))
        {
            return $query->where($field,$where);
        }
    }

    /**
     * 搜索like模糊搜索
     * @param $query
     * @param $where
     * @param string $prefix
     * @return bool
     */
    public function scopeSearchLike($query,$where,$prefix='or'){
        if(empty($where) || is_string($where))
        {
            return $query;
        }
        $where_arr=[];
        $sql='';
        foreach ($where as $k=>$v)
        {
            $sql=" $k like ? ".$prefix;
            $where_arr[]='%'.$v.'%';
        }
        $sql=substr($sql,0,-3);
        if(!empty($where_arr))
        {
            return $query->whereRaw($sql,$where_arr);
        }

    }


}
