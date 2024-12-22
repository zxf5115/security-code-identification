@extends('admin.layout.base')
@section('add_css')

@endsection
@section('content')

    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-header">网站设置</div>
            <div class="layui-card-body" pad15="">

                <div class="layui-form layui-form-kongqi" lay-filter="">
                  @include('admin.tpl.form.thumbPlace',[
                       'data'=>[
                           'name'=>'thumb',
                           'value'=>$thumb??'',
                           'show'=>$thumb??0,
                           'title'=>'网站LOGO',
                           'tips'=>'',
                           'rq'=>1,
                           'place'=>1,
                           'obj'=>'thumbUpload'
                       ]])
                  @include('admin.tpl.form.text',[
                   'data'=>[
                            'name'=>'site_name',
                            'title'=>'网站名称',
                            'tips'=>'',
                            'value'=>$site_name??'',
                            'rq'=>'rq'
                          ]
                    ])
                  @include('admin.tpl.form.text',[
                  'data'=>[
                            'name'=>'domain',
                            'title'=>'网站域名',
                            'tips'=>'',
                            'value'=>$domain ?? '',
                            'rq'=>'rq'
                    ]])
                  @include('admin.tpl.form.text',[
                  'data'=>[
                            'name'=>'record',
                            'title'=>'网站备案号',
                            'tips'=>'',
                            'value'=>$record ?? '',
                            'rq'=>'rq'
                    ]])
                  <!-- @include('admin.tpl.form.seo',[
                         'data'=>[
                             'seo_title'=>$seo_title??'',
                             'seo_key'=>$seo_key??'',
                             'seo_desc'=>$seo_desc??'',

                            ]
                        ]) -->
                  @include('admin.tpl.form.text',[
                     'data'=>[
                              'name'=>'system_name',
                              'title'=>'网站后台名称',
                              'tips'=>'',
                              'value'=>$system_name??'',
                              'rq'=>'rq'
                            ]
                      ])
                  @include('admin.tpl.form.text',[
                  'data'=>[
                            'name'=>'system_desc',
                            'title'=>'网站后台描述',
                            'tips'=>'',
                            'value'=>$system_desc ?? '',
                            'rq'=>''
                    ]])
                  @include('admin.tpl.form.thumbPlace',[
                       'data'=>[
                           'name'=>'background',
                           'value'=>$background??'',
                           'show'=>$background??0,
                           'title'=>'网站后台背景图片',
                           'tips'=>'',
                           'rq'=>1,
                           'place'=>1,
                           'obj'=>'thumbUpload'
                       ]])
                  @include('admin.tpl.form.textarea',[
                     'data'=>[
                              'name'=>'about_me',
                              'title'=>'关于我们',
                              'tips'=>'',
                              'value'=>$about_me??'',
                              'rq'=>''
                            ]
                      ])
                  @include('admin.tpl.form.text',[
                     'data'=>[
                              'name'=>'mobile',
                              'title'=>'客服电话',
                              'tips'=>'',
                              'value'=>$mobile??'',
                              'rq'=>''
                            ]
                      ])

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="config">确认保存</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('foot_js')
    <script>
        layui.use(['index','form'], function () {
            var $ = layui.$
                , jquery = $
                , form = layui.form

            form.on('submit(config)', function (obj) {
                //提交修改
                $.ajax({
                    url: '{{ action($controller.'@store') }}'
                    , method: 'post'
                    , data: obj.field
                    , success: function (res) {
                        layer.msg(res.msg);
                    }
                });

                return false;
            });


        });
    </script>

@endsection
