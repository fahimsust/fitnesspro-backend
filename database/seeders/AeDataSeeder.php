<?php

namespace Database\Seeders;

class AeDataSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->execSql('data');
    }
}
