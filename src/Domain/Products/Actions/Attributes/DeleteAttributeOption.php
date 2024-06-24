<?php

namespace Domain\Products\Actions\Attributes;

use Domain\Products\Models\Attribute\AttributeOption;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteAttributeOption
{
    use AsObject;

    public function handle(
        AttributeOption $attributeOption,
    ) {
        if (AttributeOption::whereId($attributeOption->id)->whereHas('products')->exists()) {
            throw new \Exception(
                __(
                    "Can't delete: there are products using this option.  Update these products before deleting: :products",
                    [
                        'products' => $attributeOption->products()
                            ->select('title')
                            ->limit(5)
                            ->pluck('title')
                            ->implode(', ')
                    ]
                )
            );
        }

        $attributeOption->categoryAttributes()->delete();
        $attributeOption->delete();
    }
}
