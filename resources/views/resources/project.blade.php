@extends('layouts.template')

@section('content')
  
  <div class="layui-body">
    <button class="layui-btn add-button" data-method="setTop">
      <i class="layui-icon">&#xe608;</i> 添加
    </button>
    <div id="body" style="margin-top:200px">
    @foreach ($projects as $project)
        <div class="layui-card" style="width: 200px;height: 100px;display: inline-block;">
            <div class="layui-card-body">
                {{ $project->name }}
            </div>
        </div>
    @endforeach
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>


@stop

@section('javascript')

layui.use('layer', function(){ 
    var layer = layui.layer;
    //触发事件
    var projectActive = {
      setTop: function(){
        layer.open({
          type: 2 //此处以iframe举例
          ,title: '创建项目'
          ,area: ['390px', '260px']
          ,shade: 0
          ,maxmin: true
          ,offset: [ //为了演示，随机坐标
            Math.random()*($(window).height()-300)
            ,Math.random()*($(window).width()-390)
          ] 
          ,content: $('.create_project')
          ,btn1: ['创建']
          ,btn2: ['关闭']
          ,yes: function(){
            // 创建
            alert('chuangjian');
          }
          ,btn2: function(){
            layer.closeAll();
          }
          
          ,zIndex: layer.zIndex //重点1
          ,success: function(layero){
            layer.setTop(layero); //重点2
          }
        });
      }
    };
    
    $('.add-button').on('click', function(){
    console.log('e');
      var othis = $(this), method = othis.data('method');
      projectActive[method] ? projectActive[method].call(this, othis) : '';
    });
  
});

    
@stop




    

