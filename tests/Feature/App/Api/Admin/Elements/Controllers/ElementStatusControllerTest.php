<?php

namespace Tests\Feature\App\Api\Admin\Elements\Controllers;

use Domain\Content\Models\Element;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ElementStatusControllerTest extends ControllerTestCase
{
    public Element $element;
    protected function setUp(): void
    {
        parent::setUp();
        $this->element = element::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_publish_element()
    {
        $this->element->update(['status'=>false]);
        $this->postJson(route('admin.element.status', [$this->element]),['status'=>true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(true,$this->element->refresh()->status);
    }
    /** @test */
    public function can_hide_element()
    {
        $this->postJson(route('admin.element.status', [$this->element]),['status'=>false])
            ->assertCreated()
            ->assertJsonStructure(['id']);
        $this->assertEquals(false,$this->element->refresh()->status);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        $this->postJson(route('admin.element.status', [$this->element]),['status'=>''])
             ->assertJsonValidationErrorFor('status')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.element.status', [$this->element]),['status'=>false])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
