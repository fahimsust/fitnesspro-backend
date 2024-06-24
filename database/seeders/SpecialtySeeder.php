<?php

namespace Database\Seeders;

use Domain\Accounts\Models\Specialty;

class SpecialtySeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            Specialty::class,
            ['id', 'parent_id', 'name', 'rank', 'status'],
            [
                [1, null, 'Golf Pro', 8, 1],
                [2, null, 'Squash Pro', 9, 0],
                [3, null, 'Nurse', 9, 0],
                [4, null, 'Group Fitness Instructor', 1, 1],
                [5, 4, 'Bosu', 0, 1],
                [6, 4, 'Kickboxing', 0, 1],
                [7, null, 'Personal Trainer', 4, 1],
                [8, null, 'Yoga Instructor', 2, 1],
                [9, null, 'Pilates Instructor', 5, 1],
                [10, null, 'Zumba Instructor', 7, 1],
                [11, 4, 'High/Low', 0, 1],
                [12, 4, 'Aqua Fit', 0, 1],
                [13, 8, '500hr', 0, 1],
                [14, 8, '200hr', 0, 1],
                [15, 8, 'Certified', 0, 1],
                [16, 7, 'BootCamp', 0, 1],
                [17, 7, 'Sculpting Class', 0, 1],
                [18, 7, 'Group Circuit Training', 0, 1],
                [19, 4, 'Bootcamp', 0, 1],
                [20, 4, 'Sculpting', 0, 1],
                [21, 4, 'Step', 0, 1],
                [22, 4, 'Tai Chi', 0, 1],
                [23, 4, 'Dance Based', 0, 1],
                [24, null, 'Cycling Instructor', 8, 1],
                [25, null, 'CEC Provider', 10, 1],
                [26, null, 'Dietician', 8, 0],
                [27, null, 'Club/Studio Operator', 9, 1],
                [28, null, 'Massage Therapist', 9, 0],
                [29, null, 'Tennis Coach', 3, 1],
                [30, null, 'Chiropractor', 9, 0],
                [31, null, 'Fitness Enthusiast', 8, 1],
                [32, null, 'Health/Fitness Biz', 8, 1],
                [33, null, 'Squash Pro', 9, 0],
                [34, 7, 'Group Class Approved', 0, 1],
                [35, null, 'D.J.', 8, 1],
                [36, null, 'Dance Instructor', 8, 0],
                [37, 36, 'Ball Room', 0, 1],
                [38, 36, 'Latin', 0, 1],
                [39, 36, 'Urban, HipHop', 0, 1],
                [40, 4, 'SUP', 0, 1],
                [41, 8, 'SUP Yoga', 0, 1],
                [42, 4, 'Pole Dance Instructor', 0, 0],
                [43, null, 'Pound Fitness', 50, 0],
                [44, 4, 'TRX certified', 0, 1],
                [45, 7, 'TRX certified', 0, 1],
                [46, 4, 'Barre', 0, 1],
                [47, 4, 'HIIT/Tabata', 0, 1],
                [48, 7, 'HIIT/Tabata', 0, 1],
                [49, 4, 'CrossFit', 0, 1],
                [50, 7, 'CrossFit', 0, 1],
                [51, 4, 'Yoga Sculpt', 0, 1],
                [52, 8, 'Yoga Sculpt', 0, 1],
                [53, 4, 'Stretching', 0, 1],
                [54, 7, 'Stretching', 0, 1],
                [55, 8, 'Kids Programming', 0, 1],
                [56, 10, 'Kids Programming', 0, 1],
                [57, 29, 'Kids Programming', 0, 1],
                [58, 7, 'Kids Programming', 0, 1],
                [59, 8, 'PiYo or Yogalates', 0, 1],
                [60, 9, 'PiYo or Yogalates', 0, 1],
                [61, null, 'Musician', 9, 1],
                [62, 4, 'Belly Dancing', 0, 0],
                [63, 36, 'Belly Dancing', 0, 1],
                [64, 4, 'Will Power and Grace', 0, 0],
                [65, 4, 'Kids Programming', 0, 1],
                [66, null, 'Kids Programming', 0, 0],
                [67, null, 'Pickle Ball Coach', 1, 1],
                [68, 4, 'Pound - bring your own sticks', 1, 1],
                [69, null, 'Barre', 3, 1],
                [70, null, 'Strong Nation', 1, 1],
                [71, 10, 'Strong Nation', 1, 1],
                [72, null, 'Aqua Instructor', 1, 1],
                [73, 4, 'Strong Nation', 1, 1],
                [74, 70, 'STRONG 30', 1, 1],
                [75, null, 'STRONG 30', 1, 1],
                [76, 70, 'Strong Nation', 1, 0],
                [77, null, 'Pole Dance Instructor', 1, 0],
                [78, null, 'Pound', 1, 1],
                [79, null, 'Tai Chi', 1, 1],
                [80, null, 'BurnAlong Partner', 1, 1],
            ]);
    }
}
