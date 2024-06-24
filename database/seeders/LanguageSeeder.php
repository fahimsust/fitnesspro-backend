<?php

namespace Database\Seeders;

use Domain\Locales\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'English','en_US',1],
            [2,'Spanish','es_ES',1],
            [3,'French','fr_FR',1],
            [4,'German','de_DE',1],
            [5,'Dutch','nl_NL',1],
            [6,'French (Canadian)','fr_CA',1],
            [7,'Chinese','zh_CN',1],
            [8,'Arabic','ar_AE',1]
        ];
        $fields = ['id','name','code','status'];

        foreach ($rows as $row) {
            Language::create(array_combine($fields, $row));
        }
    }
}
