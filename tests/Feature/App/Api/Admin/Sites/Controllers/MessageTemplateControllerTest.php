<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\MessageTemplateRequest;
use App\Api\Admin\Sites\Requests\SiteMessageTemplateRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteMessageTemplate;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class MessageTemplateControllerTest extends ControllerTestCase
{

    public Site $site;
    public SiteMessageTemplate $siteMessageTemplate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->siteMessageTemplate = SiteMessageTemplate::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_template()
    {
        SiteMessageTemplateRequest::fake(['html' => 'test', 'alt' => 'test']);

        $this->postJson(route('admin.site.message-template.store', [$this->site]))
            ->assertCreated()
            ->assertJsonStructure(
                [
                    'html',
                    'alt'
                ]
            );

        $this->assertEquals('test', SiteMessageTemplate::first()->html);
        $this->assertEquals('test', SiteMessageTemplate::first()->alt);
    }

    /** @test */
    public function can_get_setting()
    {
        $this->getJson(route('admin.site.message-template.index', [$this->site]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'html',
                    'alt'
                ]
            );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        SiteMessageTemplateRequest::factory()->create(['html' => '']);

        $this->postJson(route('admin.site.message-template.store', [$this->site]))
            ->assertJsonValidationErrorFor('html')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        SiteMessageTemplateRequest::fake();

        $this->postJson(route('admin.site.message-template.store', [$this->site]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
