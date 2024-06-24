<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Modules\Models\ModuleTemplate;

class ModuleTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [16, 'Root Template', null],
            [15, 'Account Master', 16],
            [1, 'Products Page', 16],
            [2, 'Catalog Page', 16],
            [3, 'Category Page', 16],
            [4, 'Affiliates Pages', 16],
            [5, 'Account Pages', 15],
            [6, 'Homepage', 16],
            [7, 'Cart Page', 16],
            [8, 'Checkout Pages', 16],
            [12, 'Sitemap Page', 16],
            [13, 'Account Lobby', 15],
            [14, 'Account Networking Lobby', 15],
            [17, 'Book Trip Categories', 16],
            [18, 'Book a Trip', 17],
            [19, 'Resort Details', 17],
            [20, 'Profiles Page', 16],
            [21, 'Order View', 15],
            [22, 'Concierge', 16],
            [23, 'Terms & Conditions', 16]
        ];
        $fields = ['id', 'name', 'parent_template_id'];

        foreach ($rows as $row) {
            ModuleTemplate::create(array_combine($fields, $row));
        }
    }
}
