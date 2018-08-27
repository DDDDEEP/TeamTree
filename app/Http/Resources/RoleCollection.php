<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public function toArray($request)
    {
        // dd(debug_backtrace());
        // $data = $this->handleByRequest($request);
        $data = $this->handleByRequest($request);
        // dd($this->resource);
        // dd($this->resource instanceof AbstractPaginator);
        return [
            'data' => $data->values()
        ];
    }
}
