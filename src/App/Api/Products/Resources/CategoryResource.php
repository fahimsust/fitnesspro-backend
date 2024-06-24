<?php

namespace App\Api\Products\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Support\Resources\ImageResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->url_name,
            'parent_id' => $this->parent_id,
            'rank' => $this->rank,
            'image' => new ImageResource($this->imageCached()),
            'show_in_list' => $this->show_in_list,
        ];
    }
}
