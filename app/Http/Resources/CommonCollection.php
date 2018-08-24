<?php

namespace App\Http\Resources;

class CommonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = $this->handleByRequest($request);
        return [
            'data' => $data->values()
        ];
    }
}
