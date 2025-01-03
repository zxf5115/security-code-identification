@extends('admin.layout.baseDoing')
@section('add_css')

@endsection
@section('content')
    <div class="layui-form layui-form-kongqi" id="layuiadmin-form" id="layuiadmin-form">
        {{ csrf_field() }}

        <div class="layui-form-item">
            <label for="" class="layui-form-label"><strong class="item-required">*</strong>父级</label>
            <div class="layui-input-block">
                <select name="parent_id" lay-search>
                    <option value="0">顶级权限</option>
                    @if(!empty($categorys))
                        @foreach($categorys as $perm)
                            <option value="{{$perm['id']}}" {{ isset($permission->id) && $perm['id'] == $permission->parent_id ? 'selected' : '' }} >{{$perm['title']}}</option>
                            @if(isset($perm['_child']))
                                @foreach($perm['_child'] as $childs)
                                    <option value="{{$childs['id']}}" {{ isset($permission->id) && $childs['id'] == $permission->parent_id ? 'selected' : '' }} >┗━━{{$childs['title']}}</option>
                                    @if(isset($childs['_child']))
                                        @foreach($childs['_child'] as $lastChilds)
                                            <option value="{{$lastChilds['id']}}" {{ isset($permission->id) && $lastChilds['id'] == $permission->parent_id ? 'selected' : '' }} >┗━━━━{{$lastChilds['title']}}</option>
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
            'title'=>'分类标题',
            'tips'=>'',
            'value'=>'',
            'rq'=>'rq'
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
