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
                {type: 'checkbox'}
                , {field: 'id', width: 100, title: 'ID', sort: true}
                , {field: 'nickname', title: '扫码会员'}
                , {field: 'message', title: '扫码结果'}
                , {field: 'create_time', title: '扫码时间'}
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
