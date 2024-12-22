@extends('admin.layout.base')
@section('add_css')

@endsection
@section('content')
    @include('admin.'.$controller_base_lower.'.form')
    @include('admin.layout.table')
@endsection
@section('foot_js')
    @include('admin.layout.ListConfig')
    <script>

        layui.use(['index', 'listTable', 'laydate'], function () {
            var $ = layui.$
                , listTable = layui.listTable;
            cols = [[
                {field: 'id', title: 'ID', width: 60}
                , {field: 'thumb', title: '会员头像', minWidth: 140, templet: '#tpl-picture'}
                , {field: 'username', title: '会员账户', minWidth: 180}
                , {field: 'nickname', title: '会员昵称', minWidth: 100}
                , {field: 'create_time', title: '记录时间', width: 180}
                , {title: '操作', width: 200, align: 'center', toolbar: '#tpl-del'}
            ]]
            //渲染
            listTable.render(listConfig.index_url, cols);
            //监听搜索
            listTable.search();

            var laydate = layui.laydate;

            //常规用法
            laydate.render({
                elem: '#search_date'
            });
        });
    </script>
@endsection
