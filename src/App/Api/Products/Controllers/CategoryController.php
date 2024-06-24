<?php

namespace App\Api\Products\Controllers;

use App\Api\Products\Requests\CategoryPageRequest;
use Domain\Products\Actions\Categories\LoadCategoryByRequest;
use Support\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    public function __invoke(CategoryPageRequest $request)
    {
        return LoadCategoryByRequest::now(
            $request,
            site: site(),
            customer: auth()->user()
        );
    }
}
