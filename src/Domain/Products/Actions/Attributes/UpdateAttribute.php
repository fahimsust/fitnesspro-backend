<?php

namespace Domain\Products\Actions\Attributes;

use App\Api\Admin\Attributes\Requests\AttributeUpdateRequest;
use Domain\Products\Models\Attribute\Attribute;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateAttribute
{
    use AsObject;

    public function handle(
        Attribute              $attribute,
        AttributeUpdateRequest $request
    ): Attribute
    {
        $attribute->update(
            [
                'name' => $request->name,
                'type_id' => $request->type_id,
                'show_in_details' => $request->show_in_details,
                'show_in_search' => $request->show_in_search,
            ]
        );

        return $attribute;
    }

}
