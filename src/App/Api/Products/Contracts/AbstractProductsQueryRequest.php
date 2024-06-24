<?php

namespace App\Api\Products\Contracts;

use Domain\Products\Actions\Categories\LoadCategoryBySlug;
use Domain\Products\Models\Category\Category;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractProductsQueryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'keyword' => ['string'],
            'search_array' => ['array'],
            'search_attributes' => ['array'],
            'search_type' => ['array'],
            'search_date' => ['datetime'],
            'option_filter' => ['array'],
            'brand_filter' => ['array'],
            'att_filter' => ['array'],
            'type_filter' => ['array'],
            'price_filter' => ['array'],
            'avail_filter' => ['array'],
            'sort' => ['string'],
            'page' => ['required', 'integer', 'min:1'],
            'per_page' => ['required', 'integer', 'min:1'],
        ];
    }

    public function hasFilters(): bool
    {
        return $this->hasAny([
            'option_filter',
            'brand_filter',
            'att_filter',
            'type_filter',
            'price_filter',
            'avail_filter',
        ]);
    }
}
