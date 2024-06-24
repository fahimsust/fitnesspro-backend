<?php

namespace Database\Seeders;

use Domain\Affiliates\Models\AffiliateLevel;
use Illuminate\Database\Seeder;

class AffiliateLevelPointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AffiliateLevel::all()
            ->each(
                fn(AffiliateLevel $level) => $level->update([
                    'points' => $this->points($level),
                ])
            );
    }

    protected function points(AffiliateLevel $level)
    {
        return match ($level->id) {
            //travel
            2 => [
                'order' => 0,
                'subscription' => [
                    'basic' => 0,
                    'travel' => 500,
                    'medallion' => 650,
                    'enterprise' => 1250,
                ]
            ],

            //medallion
            3 => [
                'order' => 150,
                'subscription' => [
                    'basic' => 0,
                    'travel' => 2500,
                    'medallion' => 3250,
                    'enterprise' => 6500,
                ]
            ],

            //enterprise
            4 => [
                'order' => 300,
                'subscription' => [
                    'basic' => 0,
                    'travel' => 7000,
                    'medallion' => 9000,
                    'enterprise' => 18000,
                ]
            ],

            //other
            default => [
                'order' => 0,
                'subscription' => [],
            ],
        };
    }
}
