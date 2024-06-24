<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Exceptions\CategoryNotFoundException;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCategoryById extends AbstractAction
{
    public function __construct(
        public int $categoryId,
    )
    {
    }

    public function execute(): Category
    {
        return Cache::tags([
            "category-cache.{$this->categoryId}"
        ])
            ->remember(
                'load-category-by-id.' . $this->categoryId,
                60 * 10,
                fn() => Category::find($this->categoryId)
                    ?? throw new CategoryNotFoundException(
                        __("No cateogry found matching id :id.", [
                            'id' => $this->categoryId,
                        ])
                    )
            );
    }
}
