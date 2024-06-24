<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class UpdateSectionModuleTemplateControllerTest extends ControllerTestCase
{
    public Site $site;
    public SiteSettings $settings;
    public ModuleTemplate $moduleTemplate;
    public $fields = [
        'search_module_template_id',
        'default_module_template_id',
        'default_category_module_template_id',
        'home_module_template_id',
        'default_product_module_template_id',
        'page_module_template_id',
        'affiliate_module_template_id'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->settings = SiteSettings::factory()->create();
        $this->moduleTemplate = ModuleTemplate::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_layout_for_section()
    {
        foreach ($this->fields as $field_name) {
            $this->postJson(
                route('admin.site.module-template.store', $this->site),
                [
                    'field_name' => $field_name,
                    'module_template_id' => $this->moduleTemplate->id
                ]
            )
                ->assertCreated()
                ->assertJsonStructure([
                    $field_name
                ]);
            $this->assertEquals($this->moduleTemplate->id, SiteSettings::first()->$field_name);
        }
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.module-template.store', $this->site), [
            'field_name' => 'wornd_field_name',
            'module_template_id' => $this->moduleTemplate->id
        ])
            ->assertJsonValidationErrorFor('field_name')
            ->assertStatus(422);
    }
    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.module-template.store', $this->site),
            [
                'field_name' => 'search_layout_id',
                'module_template_id' => $this->moduleTemplate->id
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
