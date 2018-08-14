<?php

namespace App\Http\Resources;

class CommonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $this->handleByMethods($request);
        $data = $this->collection;
        return [
            'data' => $data->values()
        ];
    }
}
