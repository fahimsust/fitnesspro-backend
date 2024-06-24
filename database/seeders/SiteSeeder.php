<?php

namespace Database\Seeders;

use Domain\Sites\Models\Site;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::factory()->create([
            'id' => config('site.id'),
            'url' => config('app.url') . '/',
            'name' => __('Default Site'),
            'domain' => 'localhost',
            'logo_url' => '',
        ]);
    }
}
