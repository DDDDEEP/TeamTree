<?php

namespace App\Http\Resources;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = $this->handleByRequest($request);
        return [
            'data' => $data->values(),
        ];
    }
}
