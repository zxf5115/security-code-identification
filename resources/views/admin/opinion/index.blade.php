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
                , {field: 'nickname', title: '会员昵称', minWidth: 180}
                , {field: 'title', title: '意见标题', minWidth: 180}
                , {field: 'content', title: '意见内容', minWidth: 100}
                , {field: 'mobile', title: '联系电话', minWidth: 140}
                , {field: 'create_time', title: '记录时间', width: 180}
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
