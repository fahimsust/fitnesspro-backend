<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Future\GiftRegistry\RegistryType;

class RegistryTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Baby Shower',1],
            [2,'Wedding',1]
        ];
        $fields = ['id','name','status'];

        foreach ($rows as $row) {
            RegistryType::create(array_combine($fields, $row));
        }
    }
}
