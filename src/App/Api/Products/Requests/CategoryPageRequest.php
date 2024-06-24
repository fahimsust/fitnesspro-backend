<?php

namespace App\Api\Products\Requests;

use App\Api\Products\Contracts\AbstractCategoryRequest;
use App\Api\Products\Enums\CategoryPageIncludes;
use Illuminate\Validation\Rules\Enum;

class CategoryPageRequest extends AbstractCategoryRequest
{
    public function rules()
    {
        return parent::rules()
            + [
                'include' => ['array', 'required'],
                'include.*' => [new Enum(CategoryPageIncludes::class)],
            ];
    }
}
