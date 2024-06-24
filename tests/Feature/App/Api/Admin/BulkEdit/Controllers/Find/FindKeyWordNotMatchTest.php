<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Locales\Models\Language;
use Domain\Products\Enums\BulkEdit\SearchOptions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindKeyWordNotMatchTest extends ControllerTestCase
{
    public Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->language = Language::factory()->create();
        $this->createProducts($this->language->id);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_product()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 title',
                'column' => 'p.title'
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(17);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_product_translation()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 translation title',
                'column' => 'p.title',
                'language_id'=>$this->language->id
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(2);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_product_details()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 title',
                'column' => 'pd.summary'
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(2);
    }
    /** @test */
    public function can_search_product_by_keyword_not_match_product_details_translation()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 translation title',
                'column' => 'pd.summary',
                'language_id'=>$this->language->id
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(2);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_product_option()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 title',
                'column' => 'po.name'
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(7);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_product_option_translation()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 translation title',
                'column' => 'po.name',
                'language_id'=>$this->language->id
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(3);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_option_value()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 title',
                'column' => 'pov.name'
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(3);
    }

    /** @test */
    public function can_search_product_by_keyword_not_match_option_value_translation()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'keyword' => 'test001 translation title',
                'column' => 'pov.name',
                'language_id'=>$this->language->id
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(3);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY->value,
                'column' => 'pov.name'
            ]
        )
        ->assertJsonValidationErrorFor('keyword')
        ->assertStatus(422);
    }
}
