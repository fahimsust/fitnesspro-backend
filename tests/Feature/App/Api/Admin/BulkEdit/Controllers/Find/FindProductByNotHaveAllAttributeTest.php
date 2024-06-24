<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\CreateProductForAttribute;

use function route;

class FindProductByNotHaveAllAttributeTest extends ControllerTestCase
{
    use CreateProductForAttribute;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->createAttributeProducts();
    }
    /** @test */
    public function can_search_product_by_any_attribute()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DOES_NOT_HAVE_ALL_OF_SELECTED_ATTRIBUTES->value,
                'attributeList' => [
                    $this->productOptionInFirstTen->id,
                    $this->productOptionInAllFifty->id
                ],
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(40);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DOES_NOT_HAVE_ALL_OF_SELECTED_ATTRIBUTES->value,
            ]
        )
        ->assertJsonValidationErrorFor('attributeList')
        ->assertStatus(422);
    }
}
