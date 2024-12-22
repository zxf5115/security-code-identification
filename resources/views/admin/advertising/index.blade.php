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
                , {field: 'title', title: '标题'}
                , {field: 'is_issue', title: '发布', templet: function (d) {
                        return layui_status('is_issue', d)
                    }}
                , {field: 'fouder', title: '发布人'}
                , {field: 'created_at', title: '添加时间'}
                , {title: '操作', width: 200, align: 'center', toolbar: '#tpl-create-edit'}
            ]]
            //渲染
            listTable.render(listConfig.index_url, cols);
            //监听搜索
            listTable.search();


        });
    </script>
@endsection
