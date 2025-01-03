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
                , {field: 'behavior', title: '描述', minWidth: 180}
                , {field: 'username', title: '操作人', minWidth: 100}
                , {field: 'ip_address', title: '操作IP', minWidth: 140}
                , {field: 'action', title: '功能', minWidth: 200}
                , {field: 'create_time', title: '操作时间', width: 180}
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
