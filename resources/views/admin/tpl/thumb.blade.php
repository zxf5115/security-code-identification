<div class="layui-form-item">
    <label class="layui-form-label">{{ $data['title']??'' }}
        @if($data['place'])
            <button class="layui-btn layui-btn-xs layui-btn-info" kq-event="upload_place"
                    data-type="{{ $data['type']??'image' }}" data-more="0" data-obj="#{{ md5($data['name']) }}">文件库选择
            </button>
        @endif
    </label>
    <div class="layui-input-block ">
        <div class="layui-uploads-pic layui-row layui-col-space10" id="{{ md5($data['name']) }}">
            <div class="item layui-col-xs4 layui-col-sm3 layui-col-md2 	upload-item upload-item-one {{ $data['show']?'show':'' }}">
                <input type="hidden" name="{{ $data['name'] }}" value="{{ $data['src']??'' }}" class="upload-item-field"
                       placeholder="{{ $data['title']??'' }}" lay-verify="{{ $data['rq']?'thumb':'' }}">
                <img src="{{ $data['src']??'' }}" class="upload-item-pic" alt="">
                <div class="item-tools">
                    <button type="button" data-src="{{ $data['src']??'' }}"
                            kq-event="show_pic"
                            class="layui-btn layui-btn-radius layui-btn-sm layui-btn-primary"><i
                                class="ti-eye"></i> 查看
                    </button>
                    <button type="button" kq-event="del_upload_pic"
                            class="layui-btn layui-btn-radius layui-btn-sm layui-btn-danger"><i
                                class="mdi mdi-delete"></i> 删除
                    </button>
                </div>
            </div>

            <div class="item layui-col-xs6 layui-col-sm3 layui-col-md2">
                <a class="pic-add js-pic-upload" id="{{ $data['obj'] }}" href="javascript:void(0)"
                   data-type="{{ $data['type']??'image' }}" data-screen_type=""
                   title="点击上传"></a>
                <input class="layui-upload-file" type="file" accept="undefined"
                       name="">
            </div>

        </div>
    </div>
</div>

