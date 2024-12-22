<div class="layui-form-item">
    @include('plugin.tpl.form.label',['data'=>$data])
    <div class="layui-input-block">
        <textarea rows="{{ $data['rows']??'5' }}" name="{{ $data['name'] }}" placeholder="{{ isset($data['tips'])?$data['tips']:$data['title'] }}"
                  lay-verify="{{ $data['rq']?$data['rq']:'' }}" autocomplete="off"
                  id="{{ $data['id']??$data['name'] }}"
                  class="layui-textarea">{{ $data['value']??'' }}</textarea>
    </div>
</div>