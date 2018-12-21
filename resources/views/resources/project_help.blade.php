@extends('layouts.template')

@section('content')
	 @include('layouts.side', ['side_index' => 3, 'id' => $project->id])

	<div class="layui-body">
        <br />
        <div class="layui-row">
            <div class="layui-col-md7 layui-col-md-offset1 text-row">
                <strong>用户权限表：</strong>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md7 layui-col-md-offset1">
                <table class="layui-table">
                    <thead>
                        <tr>
                          <th>角色</th>
                          <th>等级</th>
                          <th>权限</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$role->display_name}}</td>
                            <td>{{$role->level}}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    @if($permission->group_id == $role->level)
                                        {{$permission->display_name.'；'}}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br />
        <div class="layui-row">
            <div class="layui-col-md7 layui-col-md-offset1 text-row">
                <strong>有下面规则：</strong>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md7 layui-col-md-offset1">
                <div class="text-row">1、高等级的角色拥有低等级的权限。</div>
                <div class="text-row">2、即使拥有对应操作权限，用户也不可以操作比自己等级高的其它用户。</div>
                <div class="text-row">3、<strong>项目角色</strong>指用户在节点上的默认角色，<strong>节点角色</strong>指在某些子树上的更高级的角色。</div>
                <div class="text-row">4、同一个用户的<strong>节点角色</strong>一定比<strong>项目角色</strong>要高级。</div>
                <div class="text-row">5、<strong>节点角色</strong>会传递到子孙节点上。</div>
            </div>
        </div>
	</div>

@stop

@section('javascript')

@stop