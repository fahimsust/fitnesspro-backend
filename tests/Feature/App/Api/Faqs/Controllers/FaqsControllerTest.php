<?php

namespace Tests\Feature\App\Api\Reviews\Controllers;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqsCategories;
use Tests\TestCase;
use function route;

class FaqsControllerTest extends TestCase
{

    /** @test */
    public function can_get_faqs_list()
    {
        $categoryActives = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($categoryActives, FaqCategory::factory()->create(['status' => true, 'rank' => $i]));
        }

        $categoryInActives = FaqCategory::factory(5)->create(['status' => false]);

        $faqActives = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($faqActives, Faq::factory()->create(['status' => true, 'rank' => $i]));
        }

        $faqInActives = Faq::factory(5)->create(['status' => false]);
        foreach ($categoryActives as $key => $value) {
            FaqsCategories::factory()->create(
                [
                    'faqs_id' => $faqActives[$key]->id,
                    'categories_id' => $value->id
                ]
            );
            FaqsCategories::factory()->create(
                [
                    'faqs_id' => $faqActives[$key == 0 ? 1 : 0]->id,
                    'categories_id' => $value->id
                ]
            );
            FaqsCategories::factory()->create(
                [
                    'faqs_id' => $faqInActives[$key]->id,
                    'categories_id' => $value->id
                ]
            );
        }
        foreach ($categoryInActives as $key => $value) {
            FaqsCategories::factory()->create(
                [
                    'faqs_id' => $faqActives[$key]->id,
                    'categories_id' => $value->id
                ]
            );
            FaqsCategories::factory()->create(
                [
                    'faqs_id' => $faqInActives[$key]->id,
                    'categories_id' => $value->id
                ]
            );
        }


        $response = $this->getJson(route('faq.list'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'status',
                    'rank',
                    'faqs' => [
                        '*' => [
                            'id',
                            'question',
                            'status',
                            'rank',
                        ]
                    ]
                ]
            ])->assertJsonCount(5);

        for ($i = 0; $i < 5; $i++) {
            if ($i != 4) {
                $this->assertGreaterThanOrEqual($response[$i]['rank'], $response[$i + 1]['rank']);
            }
            $this->assertEquals(2, count($response[$i]['faqs']));
            $this->assertGreaterThanOrEqual($response[$i]['faqs'][0]['rank'], $response[$i]['faqs'][1]['rank']);
        }
    }
}
