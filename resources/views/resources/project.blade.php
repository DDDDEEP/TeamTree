@extends('layouts.template')

@section('content')
  @include('layouts.side', ['side_index' => 0])

  <div class="layui-body">
    <div id="project_body">
    @foreach ($projects as $project)
        <div class="layui-card " 
        onclick="jumpToTree(<?php echo $project->id ?>)">
            <div class="layui-card-body">
                {{ $project->name }}
            </div>
        </div>
    @endforeach
    <div class="layui-card "  onclick="addProject()">
        <div class="layui-card-body">
            <span>
              <i class="layui-icon layui-icon-add-1 add-button"></i>
             </span>
        </div>
    </div>
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
                    <a class="layui-btn" onclick="confirmAddProject()">确认</a>
                </div>
            </div>
        </div>
    </form>
  </div>



@stop

@section('javascript')





$(".delete-icon").click(function(event){
  event.stopPropagation();
})

function addProject(){
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
}
function confirmAddProject() {
  $.ajax({
      type: 'POST',
      url: route(routes.projects.store),
      data: {
          "name": $("input[name=new_name]").val(),
          "description": $("textarea[name=new_description]").val(),
      },
      dataType: "json",
      success: function (result) {
          window.location.reload(true);
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
    window.location.href = route(routes.show_tree, {project: arg})
}

$('.layui-card').hover(function(){
    $(this).css({"transform":"translateY(-20px)",
                     "box-shadow": "1px 12px 20px #ccc"});
}, function () {
     $(this).css({"transform":"translateY(0px)",
                      "box-shadow":"1px 1px 2px 2px #f2f2f2"});
 
});


@stop




    

