<?php

namespace Domain\Products\Actions\Attributes;

use Domain\Products\Models\Attribute\Attribute;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteAttribute
{
    use AsObject;

    public function handle(
        Attribute $attribute,
    ) {
        if ($this->isUsedByProducts($attribute)) {
            throw new \Exception(
                __(
                    "Can't delete: there are products using this attribute.  Update these products before deleting: :products",
                    [
                        'products' => $attribute->products()->select('title')
                        ->limit(5)->pluck('title')->implode(', ')
                    ]
                )
            );
        }

        $attribute->options()->delete();
        $attribute->attributeSetAttributes()->delete();
        $attribute->filterAttribute()->delete();
        $attribute->delete();
    }

    /**
     * @param Attribute $attribute
     * @return mixed
     */
    protected function isUsedByProducts(Attribute $attribute)
    {
        return Attribute::whereId($attribute->id)->whereHas('products')->exists();
    }
}
