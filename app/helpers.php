<?php
if (! function_exists('route_uri')) {
    /**
     * 根据路由名称返回原始的路由地址
     *
     * @param  string  $name
     * @return string
     *
     * @throws \RuntimeException
     */
    function route_uri($name)
    {
        return app('router')->getRoutes()->getByName($name)->uri();
    }
}