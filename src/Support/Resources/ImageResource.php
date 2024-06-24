<?php

namespace Support\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'name' => $this->name,
            'caption' => $this->default_caption,
        ];
    }
}
