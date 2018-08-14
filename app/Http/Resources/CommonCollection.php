<?php

namespace App\Http\Resources;

class CommonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = $this->handleByMethods($request);
        return [
            'data' => $data->values()
        ];
    }
}
