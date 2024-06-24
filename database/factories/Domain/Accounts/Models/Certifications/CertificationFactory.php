<?php

namespace Database\Factories\Domain\Accounts\Models\Certifications;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Certifications\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CertificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        $exp_date = Carbon::now()->addDays(28);
        return [
            'account_id' => Account::firstOrFactory(),
            'cert_num' => $faker->regexify('[A-Za-z0-9]{10}'),
            'cert_type' => substr($faker->word, 0, 55),
            'cert_org' => substr($faker->company, 0, 55),
            'file_name' => $faker->word . '.' . $faker->fileExtension,
            'approval_status' => $faker->boolean,
            'cert_exp' => $exp_date
        ];
    }
}
