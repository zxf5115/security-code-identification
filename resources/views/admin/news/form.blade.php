<div class="layui-card panel">
  <div class="layui-card-header">搜索
    <div class="panel-action">
      <a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
    </div>
  </div>
  <div class="layui-card-body">
    <div class="layui-form-item">
      <div class="layui-inline">
        <label class="layui-form-label layui-form-label-first">标题</label>
        <div class="layui-input-inline">
          <input type="text" name="title_like_query" placeholder="请输入标题" autocomplete="off"
          class="layui-input">
        </div>
      </div>

      <div class="layui-inline">
        <label class="layui-form-label">添加时间</label>
        <div class="layui-input-inline">
          <input id="search_date" type="text" name="date_like_query" placeholder="请输入添加时间" autocomplete="off"
          class="layui-input">
        </div>
      </div>

      <div class="layui-inline">
        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-list-search"
        style="margin-left: 20px">
          <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
        </button>
      </div>
    </div>
    <div class="layui-list-btn">
      <button class="layui-btn kongqi-handel" data-type="add">添加</button>
    </div>
  </div>
</div>
