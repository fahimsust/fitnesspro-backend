<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Exceptions\CategoryNotFoundException;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCategoryBySlug extends AbstractAction
{
    public function __construct(
        public string $slug,
    )
    {
    }

    public function execute(): Category
    {
        return Cache::tags([
            "category-slug-cache.{$this->slug}"
        ])
            ->remember(
                'load-category-by-slug.' . $this->slug,
                60 * 10,
                fn() => Category::where('url_name', $this->slug)->first()
                    ?? throw new CategoryNotFoundException(
                        __("No category found matching slug :slug.", [
                            'slug' => $this->slug,
                        ])
                    )
            );
    }
}
