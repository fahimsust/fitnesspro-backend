<?php

namespace Tests\Feature\App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageRequest;
use Domain\Content\Actions\DeletePage;
use Domain\Content\Models\Menus\MenusPages;
use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PagesCategories;
use Domain\Content\Models\Pages\PageSetting;
use Domain\Content\Models\Pages\SitePageSettings;
use Domain\Content\Models\Pages\SitePageSettingsModuleValue;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PageControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_page()
    {
        PageRequest::fake();

        $this->postJson(route('admin.page.store'))
            ->assertCreated()
            ->assertJsonStructure(['id','title']);

        $this->assertDatabaseCount(Page::Table(), 1);
    }

    /** @test */
    public function can_update_page()
    {
        $page = Page::factory()->create();
        PageRequest::fake(['page_content' => 'test content','title'=>'test']);

        $this->putJson(route('admin.page.update', [$page]))
            ->assertCreated();

        $this->assertDatabaseHas(Page::Table(),['content'=>'test content','title'=>'test']);
    }

    /** @test */
    public function can_delete_page()
    {
        $page = Page::factory(5)->create();

        PageSetting::factory()->create();
        PagesCategories::factory()->create();
        SitePageSettings::factory()->create();
        SitePageSettingsModuleValue::factory()->create();
        MenusPages::factory()->create();

        $this->deleteJson(route('admin.page.destroy', [$page->first()]))
            ->assertOk();

        $this->assertDatabaseCount(Page::Table(), 4);

        $this->assertDatabaseCount(PageSetting::Table(), 0);
        $this->assertDatabaseCount(PagesCategories::Table(), 0);
        $this->assertDatabaseCount(SitePageSettings::Table(), 0);
        $this->assertDatabaseCount(SitePageSettingsModuleValue::Table(), 0);
        $this->assertDatabaseCount(MenusPages::Table(), 0);
    }

    /** @test */
    public function can_get_pages_list()
    {
        Page::factory(30)->create();

        $response = $this->getJson(route('admin.page.index', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'url_name'
                ]
            ]]);

        $this->assertEquals(5, count($response['data']));
        $this->assertEquals(2, $response['current_page']);
    }
    /** @test */
    public function can_search_pages()
    {
        Page::factory()->create(['title' => 'test1']);
        Page::factory()->create(['url_name' => 'test1']);
        Page::factory()->create(['title' => 'not_match', 'url_name' => 'not_match']);

        $this->getJson(
            route('admin.page.index',["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'url_name'
                ]
            ]])->assertJsonCount(2,'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        PageRequest::fake(['title' => '']);

        $this->postJson(route('admin.page.store'))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(Page::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(DeletePage::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $page = Page::factory(5)->create();

        $this->deleteJson(route('admin.page.destroy', [$page->first()]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Page::Table(), 5);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        PageRequest::fake();

        $this->postJson(route('admin.page.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Page::Table(), 0);
    }
}
