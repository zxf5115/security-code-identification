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

        layui.use(['index', 'listTable'], function () {
            var $ = layui.$
                , listTable = layui.listTable;
            cols = [[
                {type: 'checkbox'}
                , {field: 'id', width: 80, title: 'ID', sort: true}
                , {field: 'country', title: '源产地'}
                , {field: 'factory', title: '厂家名称'}
                , {field: 'category', title: '产品种类'}
                , {field: 'child_category', title: '产品名称'}
                , {field: 'valid_time', title: '产品保质期'}
                , {field: 'number', title: '生成数量'}
                , {field: 'create_time', title: '生成时间'}
            ]]
            //渲染
            listTable.render(listConfig.index_url, cols);
            //监听搜索
            listTable.search();


        });
    </script>
@endsection
