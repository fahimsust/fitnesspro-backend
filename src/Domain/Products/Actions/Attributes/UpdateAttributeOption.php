<?php

namespace Domain\Products\Actions\Attributes;

use App\Api\Admin\Attributes\Requests\AttributeOptionUpdateRequest;
use Domain\Products\Models\Attribute\AttributeOption;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateAttributeOption
{
    use AsObject;

    public function handle(
        AttributeOption              $attributeOption,
        AttributeOptionUpdateRequest $request
    ): AttributeOption {
        $attributeOption->update(
            [
                'display' => $request->display,
                'status' => $request->status,
                'rank' => $request->rank ? $request->rank : 0,
            ]
        );

        return $attributeOption;
    }
}
