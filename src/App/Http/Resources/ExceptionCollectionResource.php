<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ExceptionCollectionResource extends JsonResource
{
    public static function run(Collection $exceptions, $request)
    {
        return (new static($exceptions))->toArray($request);
    }

    public function toArray($request)
    {
        /** @var Collection $action */
        $action = $this->resource;

        if ($action->isEmpty()) {
            return [];
        }

        return $action->map(
            fn (\Exception $exception) => [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'type' => $exception::class,
            ]
        )->toArray();
    }
}
