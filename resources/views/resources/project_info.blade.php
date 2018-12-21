@extends('layouts.template')

@section('content')
	 @include('layouts.side', ['side_index' => 2, 'id' => $project->id])

	<div class="layui-body">

	  <div class="layui-row">
	    <div class="layui-col-md7 layui-col-md-offset1">
	      <form class="layui-form edit-project-form" style="margin-top:50px">
	        <div class="layui-form-item" style="margin-left:-50px">
	          <label class="layui-form-label"><strong>项目名称：</strong></label>
	          <div class="layui-input-block">
	            <input type="text" name="project_name" placeholder="请输入项目名称" class="layui-input" value="{{$project->name}}" disabled>
	          </div>
	        </div>
	        <div class="layui-form-item" style="margin-left:-50px">
	          <label class="layui-form-label"><strong>项目描述：</strong></label>
	          <div class="layui-input-block">
	            <textarea type="text" name="project_description" placeholder="请输入项目描述" class="layui-textarea" disabled>{{$project->description}}</textarea>
	          </div>
	        </div>
	        <div class="layui-form-item">
	          <div class="layui-row">
	            <div class="layui-input-block" style="left: 65%">
	              <div class="layui-col-md1">
	                <button class="layui-btn layui-btn-disabled" disabled id="save-btn">保存修改</button>
	              </div>
	              <div class="layui-col-md1" style="margin-left: 40px;">
	                <button type="reset" class="layui-btn layui-btn-primary layui-bg-gray">重置</button>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="layui-form-item" style="margin-top:20px">
	        	<div class="layui-row">
	        		<label class="layui-form-label" style="padding-left:0;text-align: left;"><strong>用户列表：</strong></label>
	        		<button class="layui-btn layui-btn-disabled" disabled id="add-user-btn"
	        		style="margin-left:74%">新增用户</button>
	        	</div>
	        	<div class="layui-row">
					<table class="layui-table">
						<thead>
							<tr>
						      <th>用户</th>
						      <th>角色</th>
						      <th>操作</th>
						    </tr>
						</thead>
						<tbody>
							@foreach($project_users as $user)
							<tr>
								<td><a href="{{ route('users.show', $user->user_id) }}">{{$user->user->name}}</a></td>
								<td>
									<select name="project-role" lay-filter="project-role" disabled>
										@foreach($roles as $role)
											@if($role->level == 6)
												@if($user->role->level == 6)
												<option value="{{$role->id}}" selected>{{$role->display_name}}</option>
												@continue
												@else
													@continue
												@endif
											@endif
											@if($user->role->id == $role->id)
											<option value="{{$role->id}}" selected>{{$role->display_name}}</option>
											@else
											<option value="{{$role->id}}">{{$role->display_name}}</option>
											@endif
										@endforeach
									</select>
								</td>
								<td><button class="layui-btn layui-btn-disabled delete-user-btn" disabled>删除</button></td>
								<td style="display: none;">
								<input type="text" class="user-id" value="{{$user->id}}">
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
	        	</div>
	        </div><br>
	        <div class="layui-form-item" style="text-align: right;margin-right:50px">
	        	<div class="layui-row">
					<div class="layui-col-md-offset5">
						<button class="layui-btn layui-btn-disabled" disabled id="delete-project-btn">删除项目</button>
					</div>
	        	</div>
	        </div>
	      </form>
	    </div>
	  </div>

	</div>

	<div id="add-user" style="display: none;">

	<form class="layui-form" style="margin: 20px;">
	  <div class="layui-row">
	      <div class="layui-col-md6">
	          <input type="text" name="user_key" placeholder="请输入用户名" class="layui-input">
	      </div>
	      <div>
	          <a class="layui-btn" onclick="searchUser()">添加</a>
	      </div>
	  </div>
	  <div  style="margin: 20px auto;">
	      <table class="layui-table" id="user-list">
	          <thead>
	            <tr>
	              <th>用户</th>
	              <th>角色</th>
	              <th>操作</th>
	            </tr>
	          </thead>
	      </table>
	  </div>
	  </form>
	</div>
@stop

@section('javascript')
///
	var project = @json($project);
	var project_users = @json($project_users);
	var roles = @json($roles);
	var user_role = @json($user_role);
	// 添加用户数组
	var user_list = []

	checkPermission()
	layui.use('form', function(){
		var form = layui.form

		form.on("select(project-role)", function(data){
			var id = $(data.elem).parents("tr").find(".user-id").val()
			$.ajax({
			    type: 'PUT',
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			    url: route(routes.project_user.update, {project_user: id}),
			    data: {
			    	"role_id": data.value
			    },
			    dataType: "json",
			    success: function (result) {
		            layui.use('layer', function(){
		                var layer = layui.layer
				        if (result.errcode == 1) {
			                layer.msg(result.errmsg)
				        } else if (result.errcode == 0) {
				            layer.msg("修改成功")
				        }
		            })
			    },
			    error: function (result) {
			        console.log(result)
			    }
			})
		})

		form.on("select(add-project-role)", function(data){
			var index = $(data.elem).parents("tr").find(".user-list-index").val()
			user_list[index].role = data.value
		})

		form.render()
	})

	// 删除按钮
	$("body").on("click", ".delete-user-btn", function(){
		var id = $(this).parents("tr").find(".user-id").val()
		var _this = this
		layui.use('layer', function(){
			var layer = layui.layer
			var loadLayer = layer.load(1)

			$.ajax({
			    type: 'DELETE',
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			    url: route(routes.project_user.destroy, {project_user: id}),
			    dataType: "json",
			    success: function (result) {
			        if (result.errcode == 1) {
			            layui.use('layer', function(){
			                var msgLayer = layer.msg(result.errmsg, { time:1000 })
			            })
			        } else if (result.errcode == 0) {
			            $(_this).parents("tr").remove()
			            project_users.forEach(function(value, index){
			            	if (value.id == id) {
			            		project_users.splice(index, 1)
			            	}
			            })
			        }
		            layer.close(loadLayer);
			    },
			    error: function (result) {
			        console.log(result)
			    }
			})
		})
	})

	// 删除用户列表内的数据
	$("body").on("click", ".delete-user-list-btn", function(){
		$(this).parents("tr").remove()
		var index = $(this).parents("tr").find(".user-list-index").val()
		user_list.splice(index, 1)
	})
	
	// 保存修改函数
	function saveChange() {
		$.ajax({
		    type: 'PUT',
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    url: route(routes.projects.update, {project: project.id}),
		    data: {
		        "name": $("input[name=project_name]").val(),
		        "description": $("textarea[name=project_description]").val()
		    },
		    dataType: "json",
		    success: function (result) {
		        if (result.errcode == 1) {
		            layui.use('layer', function(){
		                var layer = layui.layer
		                layer.msg(result.errmsg)
		            })
		        } else if (result.errcode == 0) {
		            location.reload(true)
		        }
		    },
		    error: function (result) {
		        console.log(result)
		    }
		})
	}

	// 添加用户
	function addUser() {
		layui.use('layer', function(){
			var layer = layui.layer

			layer.open({
			    type: 1,
			    content: $("#add-user"),
			    area: "600px",
			    title: "添加用户",
			    skin: 'menu-skin',
			    btn: ["确定","取消"],
			    yes: function(index, layero) {
			    	user_list.forEach(function(value, index){
	                    $.ajax({
	                        type: "POST",
	                        url: route(routes.project_user.store),
	                        data: {
	                        	'project_id': project.id,
	                        	'user_id': value.id,
	                        	'role_id': value.role,
	                        	'status': 1
	                        },
	                        dataType: "json",
	                        success: function(result) {
	                        	if (result.errcode == 0) {
		                            if (index == user_list.length - 1) {
		                            	location.reload(true)
		                            }
	                        	} else {
	                        		layui.use('layer', function(){
                        		    var layer = layui.layer
                        		    layer.msg(result.errmsg)
	                        		})
	                        	}
	                        },
	                        error: function (result) {
	                            alert(result.responseJSON.msg)
	                        }
	                    })
			    	})
                }
			})
		})
	}

	// 查找用户
	function searchUser() {
		var key = $("input[name=user_key]").val()
		var domain = document.domain

		$.ajax({
		    type: 'GET',
		    url: route(routes.users.index, {'name@like': key}),
		    dataType: "json",
		    success: function (result) {
	            layui.use(['layer', 'form'], function(){
	                var layer = layui.layer
	                var form = layui.form
			        if (result.data.length == 0) {
		                layer.msg("没有找到该用户")
			        } else {
			    		var users = result.data
			            users.forEach(function(user, index){
			            for (var i = 0; i < project_users.length; i++) {
			            	if (project_users[i].user.id == user.id) {
			            		layer.msg(`${user.name}已经在项目中`)
			            		return
			            	}
			            }
			            if (user_list.length > 0) {
			            	for (var i = 0; i < user_list.length; i++) {
			            		if (user_list[i].id == user.id) {
			            			layer.msg(`已添加${user.name}`)
			            			return
			            		}
			            	}
			            }
				            $("#user-list").append(`
								<tr><td>${user.name}</td>
								<td><select lay-filter="add-project-role"></select></td>
								<td><a class="layui-btn layui-bg-red delete-user-list-btn">删除</a></td>
								<td style="display: none;"><input type="text" class="user-list-index" value=${user_list.length}>
								</td></tr>
			            	`)
			            	var select = $("#user-list").children(":last-child").find("select")
			            	roles.forEach(function(value, index){
			            		if (value.level == 6) {
			            			return
			            		}
			            		select.append(`<option value=${value.id}>${value.display_name}</option>`)
			            	})
			            	form.render()
			            	user.role = select.val()
				            user_list.push(user)
			            })
			        }
	            })
		    },
		    error: function (result) {
		        console.log(result)
		    }
		})
	}

	// 删除项目
	function deleteProject() {
		layui.use('layer', function(){
			var layer = layui.layer
			layer.confirm('是否确认删除？', {icon: 3, title:'提示'}, function(index){
				$.ajax({
				    type: "DELETE",
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    },
				    url: route(routes.projects.destroy, {'project': project.id}),
				    dataType: "json",
				    success: function(result) {
				    	if (result.errcode == 0) {
				    		window.location.href = @json(route('show_project'))
				    	} else {
				    		layui.use('layer', function(){
						    var layer = layui.layer
						    layer.msg(result.errmsg)
				    		})
				    	}
				    },
				    error: function (result) {
				        alert(result.responseJSON.msg)
				    }
				})
			})
		})
	}

    // 检查权限
	function checkPermission() {
		layui.use("form", function(){
			var form = layui.form

			$.ajax({
			    type: 'GET',
			    url: route(routes.permission_role.index),
			    data: {
			        "relate": "role,permission",
			        "role_id": user_role.id
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
			              case 'projects.update':
			                  $("input[name=project_name]").removeAttr("disabled")
			                  $("textarea[name=project_description]").removeAttr("disabled")
			                  var temp = $("#save-btn")
			                  temp.after(`<a class="layui-btn" id="save-btn" onclick="saveChange()">保存修改</a>`)
			                  temp.remove()
			                  break
			              case 'project_user.store':
			                  var temp = $("#add-user-btn")
			                  temp.after(`<a class="layui-btn layui-btn-warm"  style="margin-left:74%" id="add-user-btn" onclick="addUser()">新增用户</a>`)
			                  temp.remove()
			                  break
			              case 'project_user.update':
			                  $("select[lay-filter=project-role]").removeAttr("disabled")
			                  form.render()
			                  break
			              case 'project_user.destroy':
			                  var temp = $(".delete-user-btn")
			                  temp.after("<a class='layui-btn layui-bg-red delete-user-btn'>删除</a>")
			                  temp.remove()
			                  break
			              case 'projects.destroy':
			              	  var temp = $("#delete-project-btn")
			              	  temp.after("<a class='layui-btn layui-bg-red' id='elete-project-btn' onclick='deleteProject()'>删除项目</a>")
			              	  temp.remove()
			              	  break
			              default: break
			              }
			            })
			        }
			    },
			    error: function (result) {
			        console.log(result)
			    }
			})
		})
	}

@stop