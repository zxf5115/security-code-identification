@extends('admin.layout.baseDoing')
@section('add_css')

@endsection
@section('content')
    <div class="layui-form layui-form-kongqi" id="layuiadmin-form" id="layuiadmin-form">
        {{ csrf_field() }}

        @include('admin.tpl.form.thumbPlace',[
        'data'=>[
            'name'=>'picture',
            'value'=>'',
            'show'=>0,
            'title'=>'Bannner图片',
            'tips'=>'图片尺寸：750*450像素',
            'rq'=>'rq',
            'place'=>1,
            'obj'=>'thumbUpload'
        ]])

        @include('admin.tpl.form.text',[
            'data'=>[
            'name'=>'url',
            'title'=>'URL链接',
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
