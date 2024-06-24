<?php

namespace Tests\Feature\App\Api\Admin\Pages\Controllers;

use Domain\Content\Models\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PageStatusControllerTest extends ControllerTestCase
{
    public Page $page;
    protected function setUp(): void
    {
        parent::setUp();
        $this->page = page::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_publish_page()
    {
        $this->page->update(['status'=>false]);
        $this->postJson(route('admin.page.status', [$this->page]),['status'=>true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(true,$this->page->refresh()->status);
    }
    /** @test */
    public function can_hide_page()
    {
        $this->postJson(route('admin.page.status', [$this->page]),['status'=>false])
            ->assertCreated()
            ->assertJsonStructure(['id']);
        $this->assertEquals(false,$this->page->refresh()->status);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        $this->postJson(route('admin.page.status', [$this->page]),['status'=>''])
             ->assertJsonValidationErrorFor('status')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.page.status', [$this->page]),['status'=>false])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
