<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NodeUser extends Resource
{
    /**
     * 将资源转换成数组。
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request = null)
    {
        return parent::toArray($request);
    }
}