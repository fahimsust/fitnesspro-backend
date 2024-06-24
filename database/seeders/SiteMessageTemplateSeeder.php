<?php

namespace Database\Seeders;

use Domain\Sites\Models\SiteMessageTemplate;
use Illuminate\Database\Seeder;

class SiteMessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteMessageTemplate::factory()->create();
    }
}
