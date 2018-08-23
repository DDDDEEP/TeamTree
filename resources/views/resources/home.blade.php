@extends('layouts.template')

@section('content')
  <div class="layui-body">
    <!-- 内容主体区域 -->
	    @foreach ($projects as $project)
	  {{ $project->id}}
	    @endforeach
	
	   <div class="empty-block">暂无数据 ~_~ </div>

  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
@stop

@section('javascript')

@stop