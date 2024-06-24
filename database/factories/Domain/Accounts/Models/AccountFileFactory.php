<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountFile;
use Domain\Accounts\Models\Certifications\Certification;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccountFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        return [
            'account_id' => Account::firstOrFactory(),
            'uploaded' => Carbon::now(),
            'site_id' => Site::firstOrFactory(),
            'approval_status' => true,
            'filename' => $faker->word . '.' . $faker->fileExtension,
        ];
    }
}
