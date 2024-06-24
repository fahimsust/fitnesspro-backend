<?php

namespace Tests\Feature\App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageMetaDataRequest;
use Domain\Content\Models\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PageMetaDataControllerTest extends ControllerTestCase
{
    public Page $page;
    protected function setUp(): void
    {
        parent::setUp();
        $this->page = Page::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_page_meta()
    {
        PageMetaDataRequest::fake(['meta_title' => 'test']);

        $this->postJson(route('admin.page.meta-data', [$this->page]))
            ->assertCreated();

        $this->assertEquals('test', $this->page->refresh()->meta_title);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        PageMetaDataRequest::fake(['meta_title' => 100]);

        $this->postJson(route('admin.page.meta-data', [$this->page]))
            ->assertJsonValidationErrorFor('meta_title')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        PageMetaDataRequest::fake();

        $this->postJson(route('admin.page.meta-data', [$this->page]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
