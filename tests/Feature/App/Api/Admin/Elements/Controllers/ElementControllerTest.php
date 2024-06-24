<?php

namespace Tests\Feature\App\Api\Admin\Elements\Controllers;

use App\Api\Admin\Elements\Requests\ElementRequest;
use Domain\Content\Actions\DeleteElement;
use Domain\Content\Models\Element;
use Domain\Products\Models\SearchForm\SearchFormField;
use Domain\Sites\Models\SitePackingSlip;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ElementControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_element()
    {
        ElementRequest::fake();

        $this->postJson(route('admin.element.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'title']);

        $this->assertDatabaseCount(Element::Table(), 1);
    }

    /** @test */
    public function can_update_element()
    {
        $element = Element::factory()->create();
        ElementRequest::fake(['title' => 'test', 'element_content' => 'test content']);

        $this->putJson(route('admin.element.update', [$element]))
            ->assertCreated();

        $this->assertDatabaseHas(Element::Table(), ['title' => 'test', 'content' => 'test content']);
    }

    /** @test */
    public function can_delete_element()
    {
        $element = Element::factory(5)->create();

        $this->deleteJson(route('admin.element.destroy', [$element->first()]))
            ->assertOk();

        $this->assertDatabaseCount(Element::Table(), 4);
    }

    /** @test */
    public function can_get_exception_for_search_form_field_exists()
    {
        $element = Element::factory(5)->create();
        SearchFormField::factory()->create(['help_element_id' => $element->first()->id]);

        $response = $this->deleteJson(route('admin.element.destroy', [$element->first()]))
            ->assertStatus(500);
        $this->assertStringContainsString('there are search fields using this element', $response['message']);
    }

    /** @test */
    public function can_get_exception_for_site_packing_slip_exists()
    {
        $element = Element::factory(5)->create();
        SitePackingSlip::factory()->create(['packingslip_appendix_elementid' => $element->first()->id]);

        $response = $this->deleteJson(route('admin.element.destroy', [$element->first()]))
            ->assertStatus(500);
        $this->assertStringContainsString('there are packing slips using this element', $response['message']);
    }

    /** @test */
    public function can_get_elements_list()
    {
        Element::factory(30)->create();

        $response = $this->getJson(route('admin.element.index', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'notes'
                ]
            ]]);

        $this->assertEquals(5, count($response['data']));
        $this->assertEquals(2, $response['current_page']);
    }

    /** @test */
    public function can_search_elements()
    {
        Element::factory()->create(['title' => 'test1']);
        Element::factory()->create(['notes' => 'test1']);
        Element::factory()->create(['title' => 'not_match', 'notes' => 'not_match']);

        $this->getJson(
            route('admin.element.index',["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'notes'
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ElementRequest::fake(['title' => '']);

        $this->postJson(route('admin.element.store'))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(Element::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(DeleteElement::class)
            ->shouldReceive('handle')
            ->andThrow(new Exception("test"));

        $element = Element::factory(5)->create();

        $this->deleteJson(route('admin.element.destroy', [$element->first()]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Element::Table(), 5);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ElementRequest::fake();

        $this->postJson(route('admin.element.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Element::Table(), 0);
    }
}
