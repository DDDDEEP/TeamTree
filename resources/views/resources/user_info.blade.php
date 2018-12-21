@extends('layouts.template')

@section('content')
  @include('layouts.side', ['side_index' => 0])
  <div class="layui-body">
    <div class="layui-body">
      <div class="layui-row">
        <div class="layui-col-md6 layui-col-md-offset1">
          <form class="layui-form edit-user-form">
            <div class="layui-form-item">
              <label class="layui-form-label">用户名</label>
              <div class="layui-input-block">
                <input type="text" lay-verify="required" name="name" placeholder="请输入用户名" class="layui-input" value="{{$user->name}}" {{Auth::user()->id == $user->id ? '':'disabled'}}>
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">性别</label>
              <div class="layui-input-block">
                <input type="radio" name="sex" value="1" title="男" {{$user->sex == 1?'checked':(Auth::user()->id != $user->id ?'disabled':'')}}>
                <input type="radio" name="sex" value="2" title="女" {{$user->sex == 2?'checked':(Auth::user()->id != $user->id ?'disabled':'')}}>
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">个人介绍</label>
              <div class="layui-input-block">
                <textarea type="text" name="description" placeholder="请输入个人介绍" class="layui-textarea" {{Auth::user()->id == $user->id ? '':'disabled'}}>{{$user->description}}</textarea>
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">邮箱</label>
              <div class="layui-input-block">
                <input type="text" lay-verify="required|email" name="email" placeholder="请输入邮箱" class="layui-input" value="{{$user->email}}" {{Auth::user()->id == $user->id ? '':'disabled'}}>
              </div>
            </div>
            @if(Auth::user()->id == $user->id)
              <div class="layui-form-item" style="margin-left: 0;">
                <div class="layui-row">
                  <div class="layui-col-md-offset5">
                    <button class="layui-btn" lay-submit lay-filter="editUserForm">保存</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                  </div>
                </div>
              </div>
            @endif
          </form>
        </div>
    </div>
  </div>
@stop

@section('javascript')
  var user = @json($user);
  layui.use(['form', 'layer'], function(){
    var form = layui.form;
    var layer = layui.layer;
    form.on('submit(editUserForm)', function(data){
      console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
      $.ajax({
          type: 'PUT',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: route(routes.users.update, {user: user.id}),
          data: {
              "name": data.field.name,
              "sex": data.field.sex,
              "description": data.field.description,
              "email": data.field.email,
          },
          dataType: "json",
          success: function (result) {
              if (result.errcode == 1) {
                  layer.msg(result.errmsg, { icon: 5, time: 1000});
              } else if (result.errcode == 0) {
                  layer.msg('修改成功', { icon: 6, time: 1000});
              }
          },
          error: function (result) {
              console.log(result)
          }
      })
      return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
  });
@stop