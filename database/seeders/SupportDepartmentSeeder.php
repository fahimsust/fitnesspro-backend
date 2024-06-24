<?php

namespace Database\Seeders;

use Domain\Support\Models\SupportDepartment;
use Illuminate\Database\Seeder;

class SupportDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            ['Trip support','Customer Service and Trip Inquiries','missy@fitbodiesinc.com'],
            ['Account support','Account Questions and Comments','denise@fitbodiesinc.com'],
            ['Membership','Questions on about Memberships and Rewards ','anna@fitbodiesinc.com'],
            ['Partner','Business ideas/Marketing/partnerships','anna@fitbodiesinc.com'],
            ['Gift fund','questions and logistics regarding the Gift Fund','kevin@fitbodiesinc.com'],
            ['Transfers','questions about ground transportation','erica@fitbodiesinc.com'],
            ['Agency','additional rooms or group/retreats','agent@fitbodiesinc.com']
        ];
        $fields = ['name','subject','email'];

        foreach ($rows as $row) {
            SupportDepartment::create(array_combine($fields, $row));
        }
    }
}
