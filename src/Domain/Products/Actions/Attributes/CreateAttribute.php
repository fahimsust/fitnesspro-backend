<?php

namespace Domain\Products\Actions\Attributes;

use App\Api\Admin\Attributes\Requests\AttributeRequest;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeSet;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAttribute
{
    use AsObject;

    public function handle(
        AttributeRequest $request
    ): Attribute
    {
        return AttributeSet::findOrFail($request->set_id)
            ->attributes()
            ->create(
                [
                    'name' => $request->name,
                    'type_id' => $request->type_id,
                    'show_in_details' => $request->show_in_details,
                    'show_in_search' => $request->show_in_search,
                ]
            );
    }
}
