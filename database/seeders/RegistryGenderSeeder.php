<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Support\Models\Gender;

class RegistryGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Male',1],
            [2,'Female',1],
            [3,'Transgender',0],
            [4,'Unknown',1]
        ];
        $fields = ['id','name','status'];

        foreach ($rows as $row) {
            Gender::create(array_combine($fields, $row));
        }
    }
}
