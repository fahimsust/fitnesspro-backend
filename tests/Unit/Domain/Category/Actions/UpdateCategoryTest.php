<?php

namespace Tests\Unit\Domain\Category\Actions;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Actions\Categories\CreateCategory;
use Domain\Products\Actions\Categories\UpdateCategory;
use Domain\Products\Models\Category\Category;
use Tests\TestCase;


class UpdateCategoryTest extends TestCase
{
    /** @test */
    public function can_create_category()
    {
        $category = Category::factory()->create();
        $title = $category->title;
        $categoryRequest = $this->postRequestFactory(
            CreateCategoryRequest::class
        );

        $updatedCategory = UpdateCategory::run($category,$categoryRequest);

        $this->assertInstanceOf(Category::class, $updatedCategory);
        $this->assertModelExists($updatedCategory);
        $this->assertNotEquals($title, $updatedCategory->title);
    }
}
