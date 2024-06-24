<?php
namespace Tests\RequestFactories\App\Api\Admin\Reports\Requests;

use Domain\Accounts\Models\AccountType;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Accounts\Models\Specialty;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Worksome\RequestFactories\RequestFactory;

class CustomerReportRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;

        // You might need to adjust this based on the relationships of your models
        $accountTypeId = AccountType::firstOrFactory()->id;
        $countryId = Country::firstOrFactory()->id;
        $stateId = StateProvince::firstOrFactory()->id;
        $specialtyId = Specialty::firstOrFactory()->id;
        $membershipLevelId = MembershipLevel::firstOrFactory()->id;

        return [
            'name' => $faker->name,
            'start_date' => $faker->date(),
            'end_date' => $faker->date(),
            'account_status' => $faker->numberBetween(0, 3),
            'account_type_id' => [$accountTypeId],
            'ship_to_country' => $countryId,
            'ship_to_city' => $faker->city,
            'has_ordered' => $faker->numberBetween(0, 2),
            'ship_to_state' => [$stateId],
            'specialties' => [$specialtyId],
            'specialty_allany' => $faker->numberBetween(0, 1),
            'membership_level' => $membershipLevelId,
        ];
    }
}
