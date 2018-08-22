<?php
if (! function_exists('RouteUri')) {
    /**
     * 根据路由名称返回原始的路由地址
     *
     * @param  string  $name
     * @return string
     *
     * @throws \RuntimeException
     */
    function RouteUri($name)
    {
        return app('router')->getRoutes()->getByName($name)->uri();
    }
}

if (! function_exists('ResponseJson')) {
    /**
     * 根据路由名称返回原始的路由地址
     *
     * @param  array  $data  返回数据
     * @param  string  $errmsg  返回的错误信息
     * @param  string  $hintmsg  返回的提示信息
     * @return json  errcode：0失败，1成功
     */
    function ResponseJson($data = [], $errmsg = '', $hintmsg = '')
    {
        return response()->json([
            'data'  => $data,
            'errcode'  => $errmsg == '' ? 0 : 1,
            'errmsg' => $errmsg,
            'hintmsg' => $hintmsg
        ]);
    }
}