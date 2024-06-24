<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoriesControllerTest extends ControllerTestCase
{
    private $keyword = "test";

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_categories_list()
    {
        Category::factory(30)->create();

        $this->getJson(
            route('admin.categories.list')
        )
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'subtitle'
                        ]
                    ]
                ]
            )
            ->assertJsonCount(15,'data');
    }

    /** @test */
    public function can_search_categories()
    {
        Category::factory()->create(['title' => $this->keyword]);
        Category::factory()->create(['url_name' => $this->keyword]);
        Category::factory()->create(['title' => 'not_match', 'url_name' => 'not_match']);

        $response = $this->getJson(
            route('admin.categories.list',["per_page" => 5, "page" => 1, 'keyword' => $this->keyword]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]]);

        $this->assertEquals(2, count($response['data']));
        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function can_get_all_the_category_without_keyword()
    {
        Category::factory()->create(['title' => $this->keyword]);
        Category::factory()->create(['url_name' => $this->keyword]);
        Category::factory()->create(['title' => 'not_match', 'url_name' => 'not_match']);

        $response = $this->getJson(
            route('admin.categories.list',["per_page" => 5, "page" => 1]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'subtitle'
                ]
            ]]);

        $this->assertEquals(3, count($response['data']));
        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        Category::factory()->create(['title' => $this->keyword]);

        $this->getJson(
            route('admin.categories.list',["per_page" => 5, "page" => 1, 'keyword' => $this->keyword]),
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
