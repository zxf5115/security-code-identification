@extends('admin.layout.baseDoing')
@section('add_css')

@endsection
@section('content')
    <div class="layui-form layui-form-kongqi" id="layuiadmin-form" id="layuiadmin-form">
        {{ csrf_field() }}

        @include('admin.tpl.form.text',[
            'data'=>[
            'name'=>'ip_address',
            'title'=>'IP地址',
            'tips'=>'',
            'value'=>'',
            'rq'=>'rq'
        ]])

        @include('admin.tpl.form.textarea',[
            'data'=>[
            'name'=>'content',
            'title'=>'封禁原因',
            'tips'=>'',
            'value'=>'',
            'rq'=>''
        ]])

        @include('admin.tpl.form.submit')


    </div>
@endsection
@section('foot_js')
    <script>
        layui.use(['index', 'form'], function () {

        })
    </script>

@endsection
