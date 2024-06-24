<?php

namespace Tests\Feature\App\Api\Admin\Faq\Controllers;


use Domain\Content\Models\Faqs\Faq;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqStatusControllerTest extends ControllerTestCase
{
    public Faq $faq;
    protected function setUp(): void
    {
        parent::setUp();
        $this->faq = Faq::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_publish_faq()
    {
        $this->faq->update(['status'=>false]);
        $this->postJson(route('admin.faq.status', [$this->faq]),['status'=>true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(true,$this->faq->refresh()->status);
    }
    /** @test */
    public function can_hide_faq()
    {
        $this->postJson(route('admin.faq.status', [$this->faq]),['status'=>false])
            ->assertCreated()
            ->assertJsonStructure(['id']);
        $this->assertEquals(false,$this->faq->refresh()->status);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        $this->postJson(route('admin.faq.status', [$this->faq]),['status'=>''])
             ->assertJsonValidationErrorFor('status')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.faq.status', [$this->faq]),['status'=>false])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
