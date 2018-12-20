@extends('layouts.template')

@section('content')
  @include('layouts.side', ['side_index' => 0])
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">内容主体区域</div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
@stop

@section('javascript')

@stop