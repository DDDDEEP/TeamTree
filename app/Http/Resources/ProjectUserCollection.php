<?php

namespace App\Http\Resources;

class ProjectUserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = $this->handleByRequest($request);
        return [
            'data' => $data->values(),
        ];
    }
}
