<?php

namespace Domain\Products\Actions\Attributes;

use App\Api\Admin\Attributes\Requests\AttributeOptionRequest;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAttributeOption
{
    use AsObject;

    public function handle(
        AttributeOptionRequest $request
    ): AttributeOption {
        return Attribute::findOrFail($request->attribute_id)
            ->options()
            ->create([
                'display' => $request->display,
                'attribute_id' => $request->attribute_id,
                'status' => $request->status,
                'rank' => $request->rank ? $request->rank : 0,
            ]);
    }
}
