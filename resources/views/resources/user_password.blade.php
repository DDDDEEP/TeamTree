@extends('layouts.template')

@section('content')
  @include('layouts.side', ['side_index' => 0])
  <div class="layui-body">
    <div class="layui-body">
      <div class="layui-row">
        <div class="layui-col-md6 layui-col-md-offset1">
          <form class="layui-form edit-user-form">
            <div class="layui-form-item">
              <label class="layui-form-label">原密码</label>
              <div class="layui-input-block">
                <input class="layui-input" type="password" name="old_password" lay-verify="password" placeholder="请输入原密码">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">新密码</label>
              <div class="layui-input-block">
                <input class="layui-input" type="password" name="new_password" lay-verify="password" placeholder="请输入新密码">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">确认新密码</label>
              <div class="layui-input-block">
                <input class="layui-input" type="password" name="repeat_new_password" lay-verify="password" placeholder="请再次输入新密码">
              </div>
            </div>
            <div class="layui-form-item" style="margin-left: 0;">
              <div class="layui-row">
                <div class="layui-col-md-offset5">
                  <button class="layui-btn" lay-submit lay-filter="editPasswordForm">保存</button>
                  <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
@stop

@section('javascript')
  var user = @json($user);
  layui.use(['form', 'layer'], function(){
    var form = layui.form;
    var layer = layui.layer
    form.verify({
      password: [
        /^[\S]{6,18}$/
        ,'密码必须6到18位，且不能出现空格'
      ]
    });
    form.on('submit(editPasswordForm)', function(data){
      if (data.field.new_password != data.field.repeat_new_password) {
        layer.msg('新密码不相同', { icon: 5, time: 1000});
        return false
      }
      $.ajax({
          type: 'PUT',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: route(routes.users.update_password, {user: user.id}),
          data: {
              "old_password": data.field.old_password,
              "new_password": data.field.new_password,
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