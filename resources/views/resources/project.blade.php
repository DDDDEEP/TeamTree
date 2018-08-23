@extends('layouts.template')

@section('content')
  @include('layouts.side', ['side_index' => 0])

  <div class="layui-body">
    <button class="layui-btn add-button" >
      <i class="layui-icon">&#xe608;</i> 添加
    </button>
    <div id="project_body" style="margin-top:200px">
    @foreach ($projects as $project)
        <div class="layui-card " style="width: 200px;height: 100px;display: inline-block;"
        onclick="jumpToTree(<?php echo $project->id ?>)">
            <div class="layui-card-body">
                {{ $project->name }}
            </div>
            <span class="delete-icon"><i class="layui-icon">&#xe640;</i></span>
        </div>
    @endforeach

    </div>
  </div>
  

  <div id="add-project" style="display: none;">
    <form class="layui-form project-form">
        <div class="layui-form-item">
            <div class="layui-row">
                <label class="layui-form-label">项目名称</label>
                <div class="layui-col-md4">
                    <input type="text" name="new_name" class="layui-input" placeholder="项目名称">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-row">
              <label class="layui-form-label">项目描述</label>
              <div class="layui-col-md9">
                <textarea name="new_description" placeholder="项目描述" class="layui-textarea"></textarea>
              </div>
          </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-row">
                <div class="layui-col-md-offset10">
                    <a class="layui-btn" onclick="addProject()">确认</a>
                </div>
            </div>
        </div>
    </form>
  </div>
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>


@stop

@section('javascript')



$(".add-button").click(function(){
    layui.use('layer', function(){
        var layer = layui.layer
        layer.open({
          type: 1,
          title: '新增项目',
          content: $("#add-project"),
          area: '600px',
          cancel : function(index, layero){
              layer.close(index)
          }
        })
    })
})

$(".delete-icon").click(function(){
  console.log()
})

function addProject() {
  $.ajax({
      type: 'POST',
      url: route(routes.projects.store),
      data: {
          "name": $("input[name=new_name]").val(),
          "description": $("textarea[name=new_description]").val(),
      },
      dataType: "json",
      success: function (result) {
          if (result.errcode == 1) {
              layui.use('layer', function(){
                  var layer = layui.layer
                  layer.msg(result.errmsg)
              })
          } else if (result.errcode == 0) {
              layer.closeAll();
          }
      },
      error: function (result) {
          console.log(result);
      }
  })
}

function jumpToTree(arg) {
 $.ajax({
     type: 'GET',
     url: route(routes.show_tree, {project: arg}),
     dataType: "json",
     success: function (result) {
         if (result.errcode == 0) {

         }
     },
     error: function (result) {
         console.log(result);
     }
 })
 alert(arg);
}




@stop




    

