<?php

namespace Domain\Products\Actions\Brand;

use Domain\Products\Actions\Categories\Brands\RemoveBrandFromCategories;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Lorisleiva\Actions\Concerns\AsObject;
use Symfony\Component\HttpFoundation\Response;

class DeleteBrand
{
    use AsObject;

    private Brand $brand;

    public function handle(
        Brand $brand
    ) {
        $this->brand = $brand;

        $this->checkIfAssignedToProducts()
            ->removeFromCategories();

        $brand->delete();
    }

    private function checkIfAssignedToProducts(): static
    {
        if ($this->brand->productDetail()->doesntExist()) {
            return $this;
        }

        throw new \Exception(
            __(
                "Can't delete: there are :total products using this brand. " .
                'Before deleting, update these products including: :products',
                [
                    'products' => $this->brand->products()
                        ->select('title')
                        ->limit(5)
                        ->pluck('title')
                        ->implode(', '),
                    'total' => $this->brand->products()->count(),
                ]
            ),
            Response::HTTP_PRECONDITION_FAILED
        );
    }

    private function removeFromCategories(): static
    {
        $categoriesWithBrand = $this->brand->categories()
            ->select([Category::Table() . '.id', Category::Table() . '.title'])
            ->withCount('categoryBrands')
            ->get();

        if ($categoriesWithBrand->isEmpty()) {
            return $this;
        }

        //brand is assigned to categories
        if ($categoriesWithBrand->contains(
            fn (Category $category) => $category->category_brands_count === 1
        )) {
            throw new \Exception(
                __(
                    "Can't delete: there are categories using this brand exclusively. "
                    . 'Update these categories before deleting: :categories',
                    [
                        'categories' => $categoriesWithBrand
                            ->filter(
                                fn (Category $category) => $category->category_brands_count === 1
                            )
                            ->pluck('title')
                            ->implode(', '),
                    ]
                ),
                Response::HTTP_CONFLICT
            );
        }

        RemoveBrandFromCategories::run($this->brand, $categoriesWithBrand->pluck('id'));

        return $this;
    }
}
