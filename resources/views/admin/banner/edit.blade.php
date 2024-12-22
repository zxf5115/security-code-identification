@extends('admin.layout.baseDoing')
@section('add_css')

@endsection
@section('content')
  <div class="layui-form layui-form-kongqi" id="layuiadmin-form" id="layuiadmin-form">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    @include('admin.tpl.form.thumbPlace',[
    'data'=>[
      'name'=>'picture',
      'value'=>$show->picture,
      'show'=>$show->picture?1:'',
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
      'value'=>$show->url,
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
