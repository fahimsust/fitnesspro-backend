<?php

namespace App\Api\Orders\Resources\Order;

use App\Http\Resources\ExceptionCollectionResource;
use Domain\Orders\Actions\Order\Package\Item\AddItemToOrderPackageFromDto;
use Illuminate\Http\Resources\Json\JsonResource;

class AddItemToOrderPackageResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var AddItemToOrderPackageFromDto $action */
        $action = $this->resource;

        return [
            'item' => $action->itemDto->toArray(),
            'exceptions' => ExceptionCollectionResource::run(
                $action->exceptions(),
                $request
            ),
        ];
    }
}
