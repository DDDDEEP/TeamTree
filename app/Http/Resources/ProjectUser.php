<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProjectUser extends Resource
{
    /**
     * 将资源转换成数组。
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if ($request->has('*node_id')) {
            $this->resource->node_role = $this->user->getNodeRole($request->input('*node_id'));
        }
        return parent::toArray($request);
    }
}