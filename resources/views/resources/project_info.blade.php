@extends('layouts.template')

@section('content')
	 @include('layouts.side', ['side_index' => 2, 'id' => $project->id])

	<div class="layui-body">

	  <div class="layui-row">
	    <div class="layui-col-md7 layui-col-md-offset1">
	      <form class="layui-form edit-project-form">
	        <div class="layui-form-item">
	          <label class="layui-form-label">项目名称</label>
	          <div class="layui-input-block">
	            <input type="text" name="project_name" placeholder="请输入项目名称" class="layui-input" value="{{$project->name}}">
	          </div>
	        </div>
	        <div class="layui-form-item">
	          <label class="layui-form-label">项目描述</label>
	          <div class="layui-input-block">
	            <textarea type="text" name="project_description" placeholder="请输入项目描述" class="layui-textarea">{{$project->description}}</textarea>
	          </div>
	        </div>
	        <div class="layui-form-item">
	          <div class="layui-row">
	            <div class="layui-input-block">
	              <div class="layui-col-md1 layui-col-md-offset2">
	                <a class="layui-btn" onclick="saveChange()">保存修改</a>
	              </div>
	              <div class="layui-col-md1 layui-col-md-offset1">
	                <button type="reset" class="layui-btn layui-btn-primary layui-bg-gray">重置</button>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="layui-form-item">
	        	<div class="layui-row">
	        		<label class="layui-form-label">用户列表</label>
	        		<a class="layui-btn layui-btn-warm layui-col-md-offset8" onclick="addUser()">新增用户</a>
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
								<td>{{$user->user->name}}</td>
								<td>
									<select name="project_role" lay-filter="project_role">
										@foreach($roles as $role)
											@if($role->level == 6)
												@continue
											@endif
											@if($user->role->id == $role->id)
											<option value="{{$role->id}}" selected>{{$role->display_name}}</option>
											@else
											<option value="{{$role->id}}">{{$role->display_name}}</option>
											@endif
										@endforeach
									</select>
								</td>
								<td><a class="layui-btn layui-bg-red delete-user-btn">删除</a></td>
								<td style="display: none;">
								<input type="text" class="user-id" value="{{$user->id}}">
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
	        	</div>
	        </div>
	      </form>
	    </div>
	  </div>

	</div>

	<div id="add-user" style="display: none;">

	  <div class="layui-row">
	      <div class="layui-col-md6">
	          <input type="text" name="user_key" placeholder="请输入用户名" class="layui-input">
	      </div>
	      <div class="layui-col-md2 layui-col-md-offset2">
	          <a class="layui-btn" onclick="searchUser()">添加</a>
	      </div>
	  </div>
	  <div>
	      <table class="layui-table" id="user-list">
	          <thead>
	            <tr>
	              <th>用户</th>
	              <th>操作</th>
	            </tr>
	          </thead>
	      </table>
	  </div>
	</div>
@stop

@section('javascript')
///
	var project = @json($project);
	var project_users = @json($project_users);
	// 添加用户数组
	var user_list = []
	layui.use('form', function(){
		var form = layui.form

		form.on("select(project_role)", function(data){
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
		form.render()
	})

	// 删除按钮
	$("body").on("click", ".delete-user-btn", function(){
		var id = $(this).parents("tr").find(".user-id").val()
		var _this = this
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
		                var layer = layui.layer
		                layer.msg(result.errmsg)
		            })
		        } else if (result.errcode == 0) {
		            $(_this).parents("tr").remove()
		            project_users.forEach(function(value, index){
		            	if (value.id == id) {
		            		project_users.splice(index, 1)
		            	}
		            })
		        }
		    },
		    error: function (result) {
		        console.log(result)
		    }
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
			    area: "400px",
			    title: "添加用户",
			    btn: ['确定', '取消'],
			    yes: function(index, layero) {
			    	user_list.forEach(function(value, index){
	                    $.ajax({
	                        type: "POST",
	                        url: route(routes.project_user.store),
	                        data: {
	                        	'project_id': project.id,
	                        	'user_id': value.id,
	                        	'role_id': 1,
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
		    url: route(routes.users.index, {name: key}),
		    dataType: "json",
		    success: function (result) {
	            layui.use('layer', function(){
	                var layer = layui.layer
			        if (result.data.length == 0) {
		                layer.msg("没有找到该用户")
			        } else {
			        	var user = result.data[0]
			            for (var i = 0; i < project_users.length; i++) {
			            	if (project_users[i].user.id == user.id) {
			            		layer.msg("已添加该用户")
			            		return
			            	}
			            }
			            if (user_list.length > 0) {
			            	for (var i = 0; i < user_list.length; i++) {
			            		if (user_list[i].id == user.id) {
			            			layer.msg("已添加该用户")
			            			return
			            		}
			            	}
			            }
			            user_list.push(user)
			            $("#user-list").append(`
							<tr><td>${user.name}</td>>
							<td><a class="layui-btn layui-bg-red delete-user-list-btn">删除</a></td>
							<td style="display: none;"><input type="text" class="user-list-index" value="${user_list.length - 1}">
							</td></tr>
		            	`)
			        }
	            })
		    },
		    error: function (result) {
		        console.log(result)
		    }
		})
	}

@stop