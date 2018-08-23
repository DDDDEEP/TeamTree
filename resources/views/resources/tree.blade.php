@extends('layouts.template')

@section('content')
  
  <div class="layui-body">
    <div id="body">
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>

  <div id="node-menu" style="display: none;">
    <form class="layui-form" lay-filter="menu">
      <div class="layui-row">
        <div class="layui-col-md4">
          <input type="text" name="name" class="layui-input"></input>
        </div>
        <div class="layui-col-md4 layui-col-md-offset2">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <select name="status">
                        <option value="1" checked>未完成</option>
                        <option value="2">待验收</option>
                        <option value="3">已完成</option>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="layui-row">
        <div class="layui-form-item">
            <div class="layui-col-md2">
                <label class="layui-form-label">任务描述</label>
            </div>
            <div class="layui-col-md8">
                <div class="layui-input-block">
                  <textarea name="description" placeholder="任务描述" class="layui-textarea">1654984465</textarea>
                </div>
            </div>
        </div>
      </div>
    </form>
  </div>
@stop

@section('javascript')
///
    @include('common.tree')

    var id = 1
    var project = @json($project);

    layui.use('form', function(){
        var form = layui.form;

        form.render()
    })

    $("input[name=name], textarea[name=description]").on("blur", function(){
        $.ajax({
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route(routes.nodes.update, {node: id}),
            data: {
                "name": $("input[name=name]").val(),
                "description": $("textarea[name=description]").val()
            },
            dataType: "json",
            success: function (result) {
                if (result.errcode == 0) {
                    //
                }
            },
            error: function (result) {
                alert(result.responseJSON.msg);
            }
        })
    })
    
    function showMenu(d) {
        id = d.id
        layui.use('form', function(){
            var form = layui.form;

            form.val('menu', {
                "status": d.status,
                "name": d.name
            })
            if (d.parent_id == null) {
                $("input[name=name]").attr("readonly", true)
                $("textarea[name=description]").attr("readonly", true)
                $("select[name=status]").attr("disabled", true)
            }
            form.render()
        })
        $("textarea[name=description]").text(d.description)
        layui.use('layer', function(){
          var layer = layui.layer;
          
          layer.open({
            type: 1,
            content: $("#node-menu"),
            area: '700px',
            skin: 'menu-skin',
            cancel : function(index, layero){
                $.ajax({
                    type: 'GET',
                    url: route(routes.projects.index.get_tree, {project: project.id}),
                    dataType: "json",
                    success: function (result) {
                        if (result.errcode == 0) {
                            root = result.data

                            root.x0 = 0;
                            root.y0 = height / 2;

                            update(root);

                        }
                    },
                    error: function (result) {
                        alert(result.responseJSON.msg);
                    }
                })
                layer.close(index)
            }
          })
        });  
    }
@stop
