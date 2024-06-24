<?php

namespace Database\Seeders;

use Domain\Messaging\Models\MessageTemplateCategory;
use Illuminate\Database\Seeder;

class MessageTemplateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MessageTemplateCategory::factory(10)->create();
    }
}
