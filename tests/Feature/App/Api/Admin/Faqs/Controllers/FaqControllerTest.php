<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqRequest;
use Domain\Content\Models\Faqs\Faq;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_faq()
    {
        FaqRequest::fake();

        $this->postJson(route('admin.faq.store'))
            ->assertCreated()
            ->assertJsonStructure(['id','question']);

        $this->assertDatabaseCount(Faq::Table(), 1);
    }

    /** @test */
    public function can_update_faq()
    {
        $faq = Faq::factory()->create();
        FaqRequest::fake(['question' => 'test question','answer'=>'test answer']);

        $this->putJson(route('admin.faq.update', [$faq]))
            ->assertCreated();

        $this->assertDatabaseHas(Faq::Table(),['question' => 'test question','answer'=>'test answer']);
    }

    /** @test */
    public function can_delete_faq()
    {
        $faqs = Faq::factory(5)->create();
        $this->deleteJson(route('admin.faq.destroy', [$faqs->first()]))
            ->assertOk();

        $this->assertDatabaseCount(Faq::Table(), 4);
    }

    /** @test */
    public function can_get_faqs_list()
    {
        Faq::factory(30)->create();

        $response = $this->getJson(route('admin.faq.index', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'question',
                    'status',
                    'rank'
                ]
            ]]);

        $this->assertEquals(5, count($response['data']));
        $this->assertEquals(2, $response['current_page']);
    }
    /** @test */
    public function can_search_faqs()
    {
        Faq::factory()->create(['question' => 'test1']);
        Faq::factory()->create(['answer' => 'test1']);
        Faq::factory()->create(['question' => 'not_match', 'answer' => 'not_match']);

        $this->getJson(
            route('admin.faq.index',["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'question',
                    'status',
                    'rank'
                ]
            ]])->assertJsonCount(2,'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        FaqRequest::fake(['question' => '']);

        $this->postJson(route('admin.faq.store'))
            ->assertJsonValidationErrorFor('question')
            ->assertStatus(422);

        $this->assertDatabaseCount(Faq::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        FaqRequest::fake();

        $this->postJson(route('admin.faq.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Faq::Table(), 0);
    }
}
