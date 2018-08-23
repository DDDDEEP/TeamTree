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
    <form class="layui-form node-form" lay-filter="menu">
      <div class="layui-row">
        <div class="layui-col-md4 layui-col-md-offset4">
          <input type="text" name="name" id="node-name" class="layui-input">
        </div>
        <div class="layui-col-md2 layui-col-md-offset2">
            <div class="layui-form-item">
                <select name="status" id="node-status" lay-filter="status-select">
                    <option value="1" checked>未完成</option>
                    <option value="2">待验收</option>
                    <option value="3">已完成</option>
                </select>
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
                  <textarea name="description" id="node-description" placeholder="任务描述" class="layui-textarea"></textarea>
                </div>
            </div>
        </div>
      </div>
      <div class="layui-row">
        <div class="layui-col-md2 layui-col-md-offset4">
            <a class="layui-btn" id="add-node-btn">新增任务</a>
        </div>
        <div class="layui-col-md2">
            <a class="layui-btn layui-bg-red" id="delete-node-btn">删除任务</a>
        </div>
      </div>
    </form>
  </div>

  <div id="add-node" style="display: none;">
    <form class="layui-form node-form">
        <div class="layui-form-item">
            <div class="layui-row">
                <label class="layui-form-label">任务名称</label>
                <div class="layui-col-md4">
                    <input type="text" name="new_name" class="layui-input" placeholder="任务名称">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-row">
              <label class="layui-form-label">任务描述</label>
              <div class="layui-col-md9">
                <textarea name="new_description" placeholder="任务描述" class="layui-textarea"></textarea>
              </div>
          </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-row">
                <div class="layui-col-md-offset10">
                    <a class="layui-btn" onclick="addNode()">确认</a>
                </div>
            </div>
        </div>
    </form>
  </div>
@stop

@section('javascript')
///
    @include('common.tree')

    var node = null
    var project = @json($project);

    layui.use('form', function(){
        var form = layui.form;

        // 改变任务状态
        form.on('select(status-select)', function(data){
            layui.use('layer', function(){
                var layer = layui.layer
                layer.load(1)
                $.ajax({
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: route(routes.nodes.update_status, {node: node.id}),
                    data: {
                        "status": data.value
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.errcode == 1) {
                            layui.use('layer', function(){
                                var layer = layui.layer
                                layer.msg(result.errmsg)
                            })
                        } else if (result.errcode == 0) {
                            layer.closeAll('loading')
                        }
                    },
                    error: function (result) {
                        console.log(result)
                    }
                })
            })
        });  

        form.render()
    })

    // 修改任务名字和描述
    $("#node-name, #node-description").on("blur", function(){
        layui.use('layer', function(){
            var layer = layui.layer

            layer.load(1)
            $.ajax({
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route(routes.nodes.update, {node: node.id}),
                data: {
                    "name": $("#node-name").val(),
                    "description": $("#node-description").val()
                },
                dataType: "json",
                success: function (result) {
                    if (result.errcode == 1) {
                        layui.use('layer', function(){
                            var layer = layui.layer
                            layer.msg(result.errmsg)
                        })
                    } else if (result.errcode == 0) {
                        layer.closeAll('loading')
                    }
                },
                error: function (result) {
                    console.log(result)
                }
            })
        })
    })

    // 新增任务按钮
    $("#add-node-btn").click(function(){
        $("input[name=height]").val(node.height + 1)
        $("input[name=parent_id]").val(node.id)
        $("input[name=project_id]").val(project.id)
        layui.use('layer', function(){
            var layer = layui.layer

            layer.open({
              type: 1,
              title: '新增任务',
              content: $("#add-node"),
              area: '700px',
              cancel : function(index, layero){
                  // $.ajax({
                  //     type: 'GET',
                  //     url: route(routes.projects.index.get_tree, {project: project.id}),
                  //     dataType: "json",
                  //     success: function (result) {
                  //         if (result.errcode == 0) {
                  //             root = result.data

                  //             root.x0 = 0;
                  //             root.y0 = height / 2;

                  //             update(root);

                  //         }
                  //     },
                  //     error: function (result) {
                  //         alert(result.responseJSON.errmsg);
                  //     }
                  // })
                  layer.close(index)
              }
            })
        })
    })

    // 删除任务按钮
    $("#delete-node-btn").click(function(){
        layui.use('layer', function(){
            layer.confirm('是否确认删除？', {icon: 3, title:'提示'}, function(index){
              $.ajax({
                  type: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: route(routes.nodes.destroy, {node: node.id}),
                  dataType: "json",
                  success: function (result) {
                    layer.closeAll();
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
                            alert(result.responseJSON.errmsg);
                        }
                    })
                  },
                  error: function (result) {
                      alert(result.responseJSON.errmsg);
                  }
              })
            });
        })
    })
    
    // 弹出结点菜单
    function showMenu(d) {
        node = d
        layui.use('form', function(){
            var form = layui.form;

            form.val('menu', {
                "status": d.status,
                "name": d.name
            })
            if (d.parent_id == null) {
                $("#node-name").attr("readonly", true)
                $("#node-description").attr("readonly", true)
                $("#node-status").attr("disabled", true)
            } else {
                $("#node-name").removeAttr("readonly")
                $("#node-description").removeAttr("readonly")
                $("#node-status").removeAttr("disabled")
            }
            form.render()
        })
        $("#node-description").text(d.description)
        layui.use('layer', function(){
          var layer = layui.layer;
          
          layer.open({
            type: 1,
            content: $("#node-menu"),
            title: '任务菜单',
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
                        alert(result.responseJSON.errmsg);
                    }
                })
                layer.close(index)
            }
          })
        });  
    }

    // 新增任务函数
    function addNode() {
        layui.use('layer', function(){
            var layer = layui.layer
            layer.load(1)
        })
        $.ajax({
            type: 'POST',
            url: route(routes.nodes.store),
            data: {
                "name": $("input[name=new_name]").val(),
                "description": $("textarea[name=new_description]").val(),
                "parent_id": node.id,
                "project_id": project.id,
                "height": node.height + 1,
                "status": 1
            },
            dataType: "json",
            success: function (result) {
                if (result.errcode == 1) {
                    layui.use('layer', function(){
                        var layer = layui.layer
                        layer.msg(result.errmsg)
                    })
                } else if (result.errcode == 0) {
                    layer.closeAll()
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
                            alert(result.responseJSON.errmsg);
                        }
                    })
                }
            },
            error: function (result) {
                console.log(result)
            }
        })
    }
@stop
