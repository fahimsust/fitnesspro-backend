<?php

namespace Database\Seeders;

use Domain\Products\Models\Attribute\AttributeType;

class AttributeTypeSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            AttributeType::class,
            ['id', 'name'],
            [
                [1, 'Select Menu'],
                [2, 'Checkboxes'],
            ]
        );
    }
}
