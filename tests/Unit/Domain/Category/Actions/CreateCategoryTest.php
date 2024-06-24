<?php

namespace Tests\Unit\Domain\Category\Actions;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Actions\Categories\CreateCategory;
use Domain\Products\Models\Category\Category;
use Tests\TestCase;


class CreateCategoryTest extends TestCase
{
    /** @test */
    public function can_create_category()
    {
        $categoryRequest = $this->postRequestFactory(
            CreateCategoryRequest::class
        );

        $category = CreateCategory::run($categoryRequest);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertModelExists($category);
        $this->assertEquals(2, Category::count());
    }
}
