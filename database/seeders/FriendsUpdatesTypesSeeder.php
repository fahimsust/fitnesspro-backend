<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Accounts\Models\Friends\UpdateType;

class FriendsUpdatesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Added Photos'],
            [2,'Added Blog Entry'],
            [3,'Added Friend'],
            [4,'Added Article'],
            [5,'Created Group'],
            [6,'Added User to Group'],
            [7,'Posted Job'],
            [8,'Added Event'],
            [9,'Added Topic'],
            [10,'Added Classified Ad'],
            [11,'Add Blog'],
            [12,'Add Group Event'],
            [14,'Add Bulletin Post'],
            [15,'Add Group Bulletin Post']
        ];
        $fields = ['id','name'];

        foreach ($rows as $row) {
            UpdateType::create(array_combine($fields, $row));
        }
    }
}
