<?php

namespace App\Api\Products\Contracts;

use Domain\Products\Actions\Categories\LoadCategoryBySlug;
use Domain\Products\Enums\Category\CategoryStatus;
use Domain\Products\Models\Category\Category;

abstract class AbstractCategoryRequest extends AbstractProductsQueryRequest
{
    protected Category $category;

    public function authorize()
    {
        if($this->loadCategory()->status !== CategoryStatus::ACTIVE){
            throw new \Exception(
                __("Category is not active")
            );
        }

        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'category_slug' => $this->route('category_slug'),
        ]);
    }

    public function rules()
    {
        return [
                'category_slug' => ['required', 'string'],
                'featured_only' => ['boolean'],
            ] + parent::rules();
    }

    public function loadCategory(): Category
    {
        return $this->category ??= LoadCategoryBySlug::now(
            $this->input('category_slug')
        );
    }
}
