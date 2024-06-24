<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class AbstractSeeder extends Seeder
{
    protected function execSql($filename)
    {
        DB::transaction(function () use ($filename) {
            DB::unprepared(file_get_contents(base_path('database/seeders/sql/'.$filename.'.sql')));
        });
    }

    protected function bulkCreate($model, $columns, $valueRows)
    {
        foreach ($valueRows as $row) {
            $model::factory()->create(array_combine($columns, $row));
        }
    }
}
