<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TeamTree</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/layui/css/layui.css">
</head>

<body class="layui-layout-body">
    @yield('content')

    @include('common.routes')
    <script src="/layui/layui.js"></script>
    <script src="/js/app.js"></script>
    <script>
    layui.use(['element'], function() {
        var element = layui.element
        var $ = jQuery = layui.$;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    });
    @yield('javascript')
    </script>
</body>
</html>