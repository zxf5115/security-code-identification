<div class="layui-card panel">
    <div class="layui-card-header">搜索
        <div class="panel-action">
            <a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a></div>
    </div>
    <div class="layui-card-body">
        <div class="layui-form">
            <div class="layui-form-item">

                <div class="layui-inline">
                    <label class="layui-form-label layui-form-label-first">操作人</label>
                    <div class="layui-input-inline">
                        <input type="text" name="username_like_query" placeholder="请输入操作人" autocomplete="off"
                               class="layui-input">
                    </div>

                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">操作时间</label>
                    <div class="layui-input-inline">
                        <input id="search_date" type="text" name="date_like_query" placeholder="请输入操作时间" autocomplete="off"
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
        </div>
    </div>
</div>
