@extends('admin.layout.base')
@section('content')
<div class="layui-row layui-col-space15">

  <div class="layui-col-sm12">
    <div class="layui-col-sm8">
      <div class="layui-card">
        <div class="layui-card-header">
          扫码总数
        </div>
        <div class="layui-card-body">
          <div class="layui-row">
            <div class="layui-col-sm12">
              <div id="main" style="width: 100%;height:400px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="layui-col-sm4">
      <div class="layui-col-sm12">
        <div class="layui-card" style="height: 230px;">
          <div class="layui-card-header">
            月扫码量
            <span class="layui-badge layui-bg-blue layuiadmin-badge">次</span>
          </div>
          <div class="layui-card-body">
            <div class="layui-row">
              <div class="layui-col-sm12" style="font-size: 30px;">
                {{ $main['scan_month'] }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-col-sm12">
        <div class="layui-card" style="height: 233px;">
          <div class="layui-card-header">
            月生产量
            <span class="layui-badge layui-bg-cyan layuiadmin-badge">个</span>
          </div>
          <div class="layui-card-body">
            <div class="layui-row">
              <div class="layui-col-sm12" style="font-size: 30px;">
                {{ $main['total_month'] }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="layui-col-sm12">
    <div class="layui-col-sm6">
      <div class="layui-card" style="margin-bottom: 0;">
        <div class="layui-card-header">
          防伪码生成分析
        </div>
        <div class="layui-card-body">
          <div class="layui-row">
            <div class="layui-col-sm12">
              <div id="this_week_prod" style="width: 100%;height:300px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6">
      <div class="layui-card">
        <div class="layui-card-header">
          扫描数据分析
        </div>
        <div class="layui-card-body">
          <div class="layui-row">
            <div class="layui-col-sm12">
              <div id="this_week_scan" style="width: 100%;height:300px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="layui-col-sm12">
    <div class="layui-card">
      <div class="layui-card-header">
        扫码商品种类分析
      </div>
      <div class="layui-card-body">
        <div class="layui-row">
          <div class="layui-col-sm4">
            <div id="good_pic" style="width: 100%;height:400px;"></div>
          </div>
          <div class="layui-col-sm8">
            <div id="good" style="width: 100%;height:400px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/static/js/echarts/echarts.js"></script>
<script>
  // 基于准备好的dom，初始化echarts实例
  var myChart = echarts.init(document.getElementById('main'));

  var scan = "{{ $main['scan'] }}";
  var scan_month = "{{ $main['scan_month'] }}";
  var total = "{{ $main['total'] }}";
  var total_month = "{{ $main['total_month'] }}";


  var this_week_prod_data = "{{ $this_week_prod_data }}";
  var this_week_scan_data = "{{ $this_week_scan_data }}";
  var category = "{{ $category }}";
  var category_name = "{{ $category_name }}";


  // 指定图表的配置项和数据
  var option = {
    tooltip: {
      trigger: 'item',
      formatter: '{b}: {c} '
    },
    angleAxis: {},
    radiusAxis: {
      data: ['月扫码数', '月生产数', '扫码总数', '生产总数']
    },
    polar: {},
    series: [{
        type: 'bar',
        data: [scan_month, 0, 0, 0],
        coordinateSystem: 'polar',
        name: '月扫码数',
        stack: 'a'
    }, {
        type: 'bar',
        data: [0, total_month, 0, 0],
        coordinateSystem: 'polar',
        name: '月生产数',
        stack: 'a'
    }, {
        type: 'bar',
        data: [0, 0, scan, 0],
        coordinateSystem: 'polar',
        name: '扫码总数',
        stack: 'a'
    }, {
        type: 'bar',
        data: [0, 0, 0, total],
        coordinateSystem: 'polar',
        name: '生产总数',
        stack: 'a'
    }],
    legend: {
        show: true,
        data: ['月扫码数', '月生产数', '扫码总数', '生产总数']
    }
  };




  // 使用刚指定的配置项和数据显示图表。
  myChart.setOption(option);



console.log(category);
 this_week_prod_data = eval('(' + this_week_prod_data + ')');
 this_week_scan_data = eval('(' + this_week_scan_data + ')');


  var option = {
    title: {
        text: '堆叠区域图'
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross',
            label: {
                backgroundColor: '#6a7985'
            }
        }
    },
    legend: {
        data: ['周生产量', '周扫码量']
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: [
        {
            type: 'category',
            boundaryGap: false,
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
        }
    ],
    yAxis: [{type: 'value'}],
    series: [
        {
            name: '周生产量',
            type: 'line',
            areaStyle: {},
            data: this_week_prod_data
        },
        {
            name: '周扫码量',
            type: 'line',
            areaStyle: {},
            data: this_week_scan_data
        }
    ]
};


  // 基于准备好的dom，初始化echarts实例
  var this_week_prod = echarts.init(document.getElementById('this_week_prod'));
  this_week_prod.setOption(option);



  var option = {
    tooltip: {
      trigger: 'item',
      formatter: '{b}: {c} (次)'
    },
    legend: {
        data: ['周扫码量']
    },
    xAxis: {
      type: 'category',
      data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
    },
    yAxis: {
      type: 'value'
    },
    series: [{
      name: '周扫码量',
      data: this_week_scan_data,
      type: 'bar',
      showBackground: true,
      backgroundStyle: {
        color: 'rgba(220, 220, 220, 0.8)'
      }
    }]
  };

  // 基于准备好的dom，初始化echarts实例
  var this_week_scan = echarts.init(document.getElementById('this_week_scan'));
  this_week_scan.setOption(option);











  category=category.replace(new RegExp('&quot;',"gm"),'"')
  category = eval('(' + category + ')');
  category_name=category_name.replace(new RegExp('&quot;',"gm"),'"')
  category_name = eval('(' + category_name + ')');









  var option = {
    dataset: {source: category},
    grid: {containLabel: true},
    xAxis: {name: '产品数量'},
    yAxis: {type: 'category'},
    visualMap: {
        orient: 'horizontal',
        left: 'center',
        min: 10,
        max: 100000,
        text: ['最大产品数量'],
        dimension: 0,
        inRange: {color: ['#E15457']}
    },
    series: [
        {
            type: 'bar',
            encode: {
                x: 'amount',
                y: 'product'
            }
        }
    ]
};
  // 基于准备好的dom，初始化echarts实例
  var good = echarts.init(document.getElementById('good'));
  good.setOption(option);




















  var option = {
    tooltip: {
        trigger: 'item',
        formatter: '{a} <br/>{b}: {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        left: 10,
        data: category_name
    },
    series: [{
            name: '商品分类',
            type: 'pie',
            radius: ['40%', '55%'],
            label: {
                formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                backgroundColor: '#eee',
                borderColor: '#aaa',
                borderWidth: 1,
                rich: {
                    a: {
                        color: '#999',
                        lineHeight: 22,
                        align: 'center'
                    },
                    hr: {
                        borderColor: '#aaa',
                        width: '100%',
                        borderWidth: 0.5,
                        height: 0
                    }
                }
            },
            data: category
        }
    ]
};

  var goodpic = echarts.init(document.getElementById('good_pic'));
  goodpic.setOption(option);










</script>


@endsection


