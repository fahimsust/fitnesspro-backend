<?php

namespace App\Api\Slugs\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParsedSlugDataResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
