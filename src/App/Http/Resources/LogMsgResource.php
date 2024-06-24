<?php

namespace App\Http\Resources;

use Domain\Support\Contracts\ActionWithLogMsg;
use Illuminate\Http\Resources\Json\JsonResource;

class LogMsgResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'message' => $this->resource()->logMsg(),
        ];
    }

    private function resource(): ActionWithLogMsg
    {
        return $this->resource;
    }
}
