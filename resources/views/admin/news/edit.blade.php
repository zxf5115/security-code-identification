@extends('admin.layout.baseDoing')
@section('add_css')

@endsection
@section('content')
    <div class="layui-form layui-form-kongqi" id="layuiadmin-form" id="layuiadmin-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="layui-form-item">
            <label for="" class="layui-form-label"><strong class="item-required">*</strong>新闻分类</label>
            <div class="layui-input-block">
                <select name="category_id" lay-search>
                    @if(!empty($categorys))
                        @foreach($categorys as $perm)
                            <option value="{{$perm['id']}}" {{ isset($show->category_id) && $perm['id'] == $show->category_id ? 'selected' : '' }} >{{$perm['title']}}</option>
                            @if(isset($perm['_child']))
                                @foreach($perm['_child'] as $childs)
                                    <option value="{{$childs['id']}}" {{ isset($show->id) && $childs['id'] == $show->category_id ? 'selected' : '' }} >┗━━{{$childs['title']}}</option>
                                    @if(isset($childs['_child']))
                                        @foreach($childs['_child'] as $lastChilds)
                                            <option value="{{$lastChilds['id']}}" {{ isset($show->id) && $lastChilds['id'] == $show->category_id ? 'selected' : '' }} >┗━━━━{{$lastChilds['title']}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </div>



        @include('admin.tpl.form.text',[
            'data'=>[
            'name'=>'title',
            'title'=>'标题',
            'tips'=>'',
            'value'=>$show->title,
            'rq'=>'rq'
        ]])

        <div class="layui-form-item">
            <label for="" class="layui-form-label"><strong class="item-required">*</strong>内容</label>
            <div class="layui-input-block">
                <textarea id="content" name="content">{{ $show->content }}</textarea>
            </div>
        </div>


        @include('admin.tpl.form.text',[
            'data'=>[
            'name'=>'fouder',
            'title'=>'发布人',
            'tips'=>'',
            'rq'=>'',
            'value'=>$show->fouder
        ]])

        @include('admin.tpl.form.radio',[
           'data'=>[
               'name'=>'is_issue',
               'title'=>'立即发布',
               'tips'=>'',
               'rq'=>'',
               'on_id'=>$show->is_issue,
               'list'=>[
                   'type'=>'',
                   'data'=>[
                        ['id'=>1,'name'=>'是'],
                        ['id'=>2,'name'=>'否']
                   ]
               ]
       ]])

        @include('admin.tpl.form.submit')


    </div>
@endsection
@section('foot_js')

    @include('admin.layout.editor.editor')

    <script>
        layui.use(['index', 'uploader','form'], function () {
            var uploader = layui.uploader;
            var form=layui.form;
            uploader.one("#thumbUpload");
        })

        editor("#content");
    </script>

@endsection
