<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use Tests\TestCase;
use Domain\Accounts\Models\Account;
use Tests\RequestFactories\App\Api\Accounts\Requests\Membership\NewMemberRequestFactory;
use Database\Seeders\CountrySeeder;
use Database\Seeders\SiteSeeder;
use Database\Seeders\StateSeeder;


class NewMemberRequestTest extends TestCase
{
    public Account $account_data;
    public array $account_array;


    protected function setUp(): void
    {
        parent::setUp();

        $this->account_data = Account::factory()->create();
        $this->seed([
            CountrySeeder::class,
            StateSeeder::class,
            SiteSeeder::class,
        ]);
    }
    // /** @test */
    // public function check_all_validation_rules_works()
    // {
    //     foreach ($this->invalidAccount() as $value) {

    //          $this->postJson(route('membership.new'), $value[0])
    //              ->assertJsonValidationErrorFor($value[1])
    //              ->assertStatus(422);
    //     }
    //     $this->assertDatabaseCount(Account::Table(), 1);
    // }
    public function invalidAccount()
    {
        $return_array = [];

        $return_array = $this->userNameError($return_array);
        $return_array = $this->emailError($return_array);
        $return_array = $this->specialtiesError($return_array);
        $return_array = $this->lastNameError($return_array);
        $return_array = $this->firstNameError($return_array);
        //$return_array = $this->lastLoginError($return_array);
        //$return_array = $this->statusError($return_array);
        $return_array = $this->passwordError($return_array);

        return $return_array;

    }

    private function specialtiesError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $data = array_merge($account_array, ['specialties' => '']);
        $return_array[] = [
            $data,
            'specialties'
        ];
        $data = array_merge($account_array, ['specialties' => 'ABC']);
        $return_array[] = [
            $data,
            'specialties'
        ];

        return $return_array;
    }

    private function lastNameError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $data = array_merge($account_array, ['last_name' => '']);
        $return_array[] = [
            $data,
            'last_name'
        ];
        $data = array_merge($account_array, ['last_name' => 123]);
        $return_array[] = [
            $data,
            'last_name'
        ];

        return $return_array;
    }

    private function firstNameError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $data = array_merge($account_array, ['first_name' => '']);
        $return_array[] = [
            $data,
            'first_name'
        ];
        $data = array_merge($account_array, ['first_name' => 123]);
        $return_array[] = [
            $data,
            'first_name'
        ];

        return $return_array;
    }

    private function lastLoginError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $data = array_merge($account_array, ['lastlogin_at' => '2021--10-1']);
        $return_array[] = [
            $data,
            'lastlogin_at'
        ];

        return $return_array;
    }

    private function statusError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $data = array_merge($account_array, ['status_id' => 'A']);
        $return_array[] = [
            $data,
            'status_id'
        ];
        $data = array_merge($account_array, ['status_id' => '']);
        $return_array[] = [
            $data,
            'status_id'
        ];

        return $return_array;
    }

    private function userNameError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $account_data = $this->account_data;
        $data = array_merge($account_array, ['username' => '']);
        $return_array[] = [
            $data,
            'username'
        ];
        $data = array_merge($account_array, ['username' => 123]);
        $return_array[] = [
            $data,
            'username'
        ];
        if (config('accounts.account_use_username')) {
            $data = array_merge($account_array, ['username' => $account_data->username]);
            $return_array[] = [
                $data,
                'username'
            ];
        }

        return $return_array;
    }

    private function passwordError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $data = array_merge($account_array, ['password' => '']);
        $return_array[] = [
            $data,
            'password'
        ];
        $data = array_merge($account_array, ['password' => 12345]);
        $return_array[] = [
            $data,
            'password'
        ];
        $data = array_merge($account_array, ['password_confirmation' => '654321F', 'password' => '654321D']);
        $return_array[] = [
            $data,
            'password'
        ];

        return $return_array;
    }

    private function emailError($return_array)
    {
        $account_array = NewMemberRequestFactory::new()->create();
        $account_data = $this->account_data;
        $data = array_merge($account_array, ['email' => '']);
        $return_array[] = [
            $data,
            'email'
        ];
        $data = array_merge($account_array, ['email' => 'test@']);
        $return_array[] = [
            $data,
            'email'
        ];
        if (!config('accounts.account_use_username') || config('accounts.dont_allow_duplicate_email')) {
            $data = array_merge($account_array, ['email' => $account_data->email]);
            $return_array[] = [
                $data,
                'email'
            ];
        }
        if (config('accounts.blacklist_email_tld')) {
            $black_list_array = config('accounts.blacklist_email_tld');
            $data = array_merge($account_array, ['email' => "test@" . $black_list_array[0]]);
            $return_array[] = [
                $data,
                'email'
            ];

        }

        return $return_array;
    }
}
