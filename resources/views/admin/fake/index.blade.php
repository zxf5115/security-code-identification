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


        layui.use(['index', 'listTable', 'util', 'laydate'], function () {
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
                , {field: 'security_code', title: '防伪码', templet: '#tpl-security_code'}
                , {field: 'create_time', title: '生产时间'}
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

            var util = layui.util;

            //处理属性 为 lay-active 的所有元素事件
            util.event('lay-active',
            {
                export_data: function()
                {
                    var title      = $('input[name="fake_title_like_query"]').val();
                    var factory    = $('input[name="fake_factory_like_query"]').val();
                    var category   = $('input[name="fake_category_like_query"]').val();
                    var valid_date = $('input[name="valid_date_like_query"]').val();

                    url =   '/admin/fake/export' +
                            '?title=' + title
                            + '&factory=' + factory
                            + '&category=' + category
                            + '&valid_date=' + valid_date
                            + '&is_picture=0';


                    window.open(url);
                },

                export_picture: function()
                {
                    var title      = $('input[name="fake_title_like_query"]').val();
                    var factory    = $('input[name="fake_factory_like_query"]').val();
                    var category   = $('input[name="fake_category_like_query"]').val();
                    var valid_date = $('input[name="valid_date_like_query"]').val();

                    url =   '/admin/fake/export' +
                            '?title=' + title
                            + '&factory=' + factory
                            + '&category=' + category
                            + '&valid_date=' + valid_date
                            + '&is_picture=1';


                    window.open(url);
                }
            });
        });
    </script>
@endsection
