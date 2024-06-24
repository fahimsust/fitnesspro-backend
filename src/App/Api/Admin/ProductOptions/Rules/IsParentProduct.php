<?php

namespace App\Api\Admin\ProductOptions\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Domain\Products\Models\Product\Product;

class IsParentProduct implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($value, 'parent_product');

        if (!$product)
            $fail(__('Invalid Product Id'));

        if ($product && $product->parent_product != null)
            $fail(__("Can't create options on a child product"));
    }
}
