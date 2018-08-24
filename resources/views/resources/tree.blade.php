@extends('layouts.template')

@section('content')
     @include('layouts.side',  ['side_index' => 1, 'id' => $project->id])
  
  <div class="layui-body">
    <div id="body">
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>

  <div id="node-menu" style="display: none; overflow-x: auto; overflow-y: auto;">
    <form class="layui-form node-form" lay-filter="menu">
      <div class="layui-row">
        <div class="layui-col-md4 layui-col-md-offset4">
          <input type="text" name="name" id="node-name" class="layui-input" disabled>
        </div>
        <div class="layui-col-md2 layui-col-md-offset2">
            <div class="layui-form-item">
                <select name="status" id="node-status" lay-filter="status-select" disabled>
                    <option value="1" checked>未完成</option>
                    <option value="2">待验收</option>
                    <option value="3">已完成</option>
                </select>
            </div>
        </div>
      </div>
      <div class="layui-row">
        <div class="layui-form-item">
                <label class="layui-form-label">任务描述</label>
                <div class="layui-input-block">
                  <textarea name="description" disabled id="node-description" placeholder="任务描述" class="layui-textarea"></textarea>
                </div>
        </div>
      </div>
      <div class=layui-form-item>
        <div class="layui-row">
            <label class="layui-form-label">用户列表</label>
        </div>
        <div class="layui-row">
        <div style="height: 305px; overflow-x: auto; overflow-y: auto;">
            <table class="menu-user-list layui-table" id="node-user-list">
                <thead>
                    <tr>
                        <th>用户</th>
                        <th>项目角色</th>
                        <th>结点角色</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
      </div>
      <div class=layui-form-item>
          <div class="layui-row">
            <div class="layui-col-md2 layui-col-md-offset4">
                <button class="layui-btn layui-btn-disabled add-node-btn" disabled>新增任务</button>
            </div>
            <div class="layui-col-md2">
                <button class="layui-btn layui-btn-disabled delete-node-btn" disabled>删除任务</button>
            </div>
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
    var user = @json($user);
    var roles = @json($roles);
    var node_users = []

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

        form.on("select(node-user-role)", function(data){
            var index = $(data.elem).parents("tr").find(".node-user-index").val()
            layui.use('layer', function(){
                var layer = layui.layer

                layer.load(1)
                if (node_users[index].node_role.id == node_users[index].role.id) {
                        $.ajax({
                            type: 'POST',
                            url: route(routes.node_user.store,
                             {user_id: node_users[index].user.id, node_id: node.id, role_id: data.value}),
                            dataType: "json",
                            success: function (result) {
                                if (result.errcode == 1) {
                                    layui.use('layer', function(){
                                        var layer = layui.layer
                                        layer.msg(result.errmsg)
                                        layer.closeAll('loading')
                                    })
                                } else if (result.errcode == 0) {
                                    layer.closeAll('loading')
                                }
                            },
                            error: function (result) {
                                console.log(result)
                            }
                        })
                } else {
                    alert(2)
                }
            })
        })

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
    $("body").on("click", ".add-node-btn", function(){
        $("input[name=height]").val(node.height + 1)
        $("input[name=parent_id]").val(node.id)
        $("input[name=project_id]").val(project.id)
        layui.use('layer', function(){
            var layer = layui.layer

            layer.open({
              type: 1,
              title: '新增任务',
              content: $("#add-node"),
              area: '700px'
            })
        })
    })

    // 删除任务按钮
    $("body").on("click", ".delete-node-btn", function(){
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
                        url: route(routes.projects.index.get_tree, {project: project.id, user_id: user.id}),
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

    function checkPermission(d) {
        node = d
        if (d.parent_id != null) {
            $.ajax({
                type: 'GET',
                url: route(routes.permission_role.index),
                data: {
                    "relate": "role,permission",
                    "role_id": d.role.id
                },
                dataType: "json",
                success: function (result) {
                    if (result.errcode == 1) {
                        layui.use('layer', function(){
                            var layer = layui.layer
                            layer.msg(result.errmsg)
                        })
                    } else {
                        var data = result.data
                        data.forEach(function(value, index){
                          switch(value.permission.name) {
                          case 'nodes.update.update_status':
                              $("#node-status").removeAttr("disabled")
                              break
                          case 'nodes.store':
                              var temp = $(".add-node-btn")
                              temp.after("<a class='layui-btn add-node-btn'>新增任务</a>")
                              temp.remove()
                              break
                          case 'nodes.update':
                              $("#node-name").removeAttr("disabled")
                              $("#node-description").removeAttr("disabled")
                              break
                          case 'nodes.destroy':
                              var temp = $(".delete-node-btn")
                              temp.after("<a class='layui-btn layui-bg-red delete-node-btn'>删除任务</a>")
                              temp.remove()
                              break
                          default: break
                          }
                        })
                        showMenu()
                    }
                },
                error: function (result) {
                    console.log(result)
                }
            })
        } else {
            showMenu()
        }
    }
    
    // 弹出结点菜单
    function showMenu() {
        layui.use('form', function(){
            var form = layui.form;

            form.val('menu', {
                "status": node.status,
                "name": node.name
            })
            // if (node.parent_id == null) {
            //     $("#node-name").attr("disabled", true)
            //     $("#node-description").attr("disabled", true)
            //     $("#node-status").attr("disabled", true)
            // } else {
            //     $("#node-name").removeAttr("disabled")
            //     $("#node-description").removeAttr("disabled")
            //     $("#node-status").removeAttr("disabled")
            // }
            showUserList()
            form.render()
        })
        $("#node-description").text(node.description)
        layui.use('layer', function(){
          var layer = layui.layer;

          layer.open({
            type: 1,
            content: $("#node-menu"),
            title: '任务菜单',
            area: '700px',
            skin: 'menu-skin',
            maxHeight: $(".layui-body").height(),
            fixed: false,
            cancel : function(index, layero){
                $.ajax({
                    type: 'GET',
                    url: route(routes.projects.index.get_tree, {project: project.id, user_id: user.id}),
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

    // 获取用户列表
    function showUserList() {
        $("#node-user-list").find("tbody").empty()
        layui.use("form", function(){
            var form = layui.form

            $.ajax({
                type: 'GET',
                url: route(routes.project_user.index),
                data: {
                    'project_id': project.id,
                    'relate': 'role,user',
                    '*node_id': node.id
                },
                dataType: "json",
                success: function (result) {
                    node_users = result.data
                    node_users.forEach(function(node_user, index){
                        $("#node-user-list").find('tbody').append(`
                            <tr><td>${node_user.user.name}</td><td>${node_user.role.display_name}</td>
                            <td><select lay-filter="node-user-role"></select></td>
                            <td style="display: none;"><input type="text" class="node-user-index" value=${index}>
                            </tr>
                        `)
                        var select = $("#node-user-list").find('tbody').children(":last-child").find("select")
                        roles.forEach(function(value, index){
                            if (node_user.node_role.level > value.level) {
                                return
                            }
                            if (value.id == node_user.node_role.id) {
                                select.append(`<option value=${value.id} selected disabled>${value.display_name}</option>`)
                            } else {
                                select.append(`<option value=${value.id}>${value.display_name}</option>`)
                            }
                        })
                        form.render()
                    })
                },
                error: function (result) {
                    alert(result.responseJSON.errmsg);
                }
            })
        })
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
                        url: route(routes.projects.index.get_tree, {project: project.id, user_id: user.id}),
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
