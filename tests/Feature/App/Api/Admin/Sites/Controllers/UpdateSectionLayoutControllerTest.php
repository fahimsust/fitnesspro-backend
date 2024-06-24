<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class UpdateSectionLayoutControllerTest extends ControllerTestCase
{
    public Site $site;
    public SiteSettings $settings;
    public Layout $layout;
    public $fields = [
        'search_layout_id',
        'default_layout_id',
        'default_category_layout_id',
        'home_layout_id',
        'default_product_layout_id',
        'page_layout_id',
        'affiliate_layout_id'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->settings = SiteSettings::factory()->create();
        $this->layout = Layout::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_layout_for_section()
    {
        foreach ($this->fields as $field_name) {
            $this->postJson(
                route('admin.site.default-layout.store', $this->site),
                [
                    'field_name' => $field_name,
                    'layout_id' => $this->layout->id
                ]
            )
                ->assertCreated()
                ->assertJsonStructure([
                    $field_name
                ]);
            $this->assertEquals($this->layout->id, SiteSettings::first()->$field_name);
        }
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.default-layout.store', $this->site), [
            'field_name' => 'wornd_field_name',
            'layout_id' => $this->layout->id
        ])
            ->assertJsonValidationErrorFor('field_name')
            ->assertStatus(422);
    }
    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.default-layout.store', $this->site),
            [
                'field_name' => 'search_layout_id',
                'layout_id' => $this->layout->id
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
