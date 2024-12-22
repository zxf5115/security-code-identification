<div class="layui-card panel">
    <div class="layui-card-header">搜索
        <div class="panel-action">
            <a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a></div>
    </div>
    <div class="layui-card-body">
        <div class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label layui-form-label-first">产品名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="fake_title_like_query" placeholder="请输入产品名称" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label layui-form-label-first">厂家名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="fake_factory_like_query" placeholder="请输入厂家名称" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label layui-form-label-first">产品种类</label>
                    <div class="layui-input-inline">
                        <input type="text" name="fake_category_like_query" placeholder="请输入产品种类" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">产品保质期</label>
                    <div class="layui-input-inline">
                        <input id="search_date" type="text" name="valid_date_like_query" placeholder="请输入产品保质期" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-list-search"
                            style="margin-left: 20px">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>

                    <button id="sss" class="layui-btn layui-btn-warm" lay-active="export_data">导出数据</button>

                    <button class="layui-btn layui-btn-normal" lay-active="export_picture">导出防伪码</button>
                </div>
            </div>
        </div>
    </div>
</div>
