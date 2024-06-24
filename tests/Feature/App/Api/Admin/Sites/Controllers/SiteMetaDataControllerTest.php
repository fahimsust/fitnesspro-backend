<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\UpdateSiteMetaDataRequest;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteMetaDataControllerTest extends ControllerTestCase
{

    public Site $site;
    protected function setUp(): void
    {
        parent::setUp();
        $this->site = Site::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_meta_data()
    {
        UpdateSiteMetaDataRequest::fake(['meta_title'=>'test']);

        $this->postJson(route('admin.site.update-meta',[$this->site]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test',Site::first()->meta_title);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        UpdateSiteMetaDataRequest::factory()->create(['meta_title' => '']);

         $this->postJson(route('admin.site.update-meta',[$this->site]))
             ->assertJsonValidationErrorFor('meta_title')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        UpdateSiteMetaDataRequest::fake(['meta_title'=>'test']);
        $this->postJson(route('admin.site.update-meta',[$this->site]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals('test',Site::first()->meta_title);
    }
}
