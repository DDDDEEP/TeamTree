@if($side_index != 0)
<div class="layui-side layui-bg-black">
  <div class="layui-side-scroll">
    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
    <ul class="layui-nav layui-nav-tree"  lay-filter="test">
      <li class="layui-nav-item {{ $side_index == 1 ? 'layui-this' : '' }}">
        <a href="{{route('show_tree', $id)}}">项目树</a>
      </li>
      <li class="layui-nav-item {{ $side_index == 2 ? 'layui-this' : '' }}">
        <a href="{{route('show_info', $id)}}">项目详情</a>
      </li>
    </ul>
  </div>
</div>
@endif