<?php

namespace Tests\Feature\App\Api\Admin\DisplayTemplates\Controllers;

use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ThumbnailDisplayTemplateControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $displayTemplateType = DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_thumbnail')]);
        DisplayTemplate::factory(15)->create(['type_id'=>$displayTemplateType->id]);
        $displayTemplateType2 = DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_zoom')]);
        DisplayTemplate::factory(13)->create(['type_id'=>$displayTemplateType2->id]);
    }

    /** @test */
    public function can_get_display_template()
    {
        $this->getJson(route('admin.display-template-thumbnail.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(15);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->getJson(route('admin.display-template-thumbnail.index'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
