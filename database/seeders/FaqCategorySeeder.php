<?php

namespace Database\Seeders;


use Domain\Content\Models\Faqs\FaqCategory;

class FaqCategorySeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqCategory::factory(26)->create();
    }
}
