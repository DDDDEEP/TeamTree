<?php

namespace App\Http\Resources;

class NodeUserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = $this->handleByRequest($request);
        return [
            'data' => $data->values(),
        ];
    }
}
