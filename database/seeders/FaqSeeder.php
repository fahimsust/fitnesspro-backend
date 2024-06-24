<?php

namespace Database\Seeders;


use Domain\Content\Models\Faqs\Faq;

class FaqSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::factory(26)->create();
    }
}
