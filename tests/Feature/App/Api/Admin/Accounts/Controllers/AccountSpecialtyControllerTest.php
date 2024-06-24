<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\Specialty;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccountSpecialtyControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_account_specialties()
    {
        $account = Account::factory()->create();
        $specialties = Specialty::factory()->count(3)->create(['parent_id' => null]);
        foreach ($specialties as $key => $specialty) {
            if ($key < 2)
                AccountSpecialty::factory()->create([
                    'specialty_id' => $specialty->id,
                    'account_id' => $account->id,
                    'approved' => ($key == 0) ? true : false
                ]);

            Specialty::factory()->count(2)->create(['parent_id' => $specialty->id]);
        }
        $response = $this->getJson(route('admin.account-specialty.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'account_specialty' => [
                        'exists',
                        'approved'
                    ],
                    'children_recursive' => [
                        '*' => [
                            // Structure of your recursive children
                        ]
                    ]
                ]
            ])
            ->assertJsonCount(3);
        // Check the 'exists' and 'approved' values
        $response->assertJson(function (AssertableJson $json) {
            $json->where('0.account_specialty.exists', true)
                ->where('0.account_specialty.approved', true)
                ->where('1.account_specialty.exists', true)
                ->where('1.account_specialty.approved', false)
                ->where('2.account_specialty.exists', false)
                ->where('2.account_specialty.approved', false)
                ->etc();
        });
    }
    /** @test */
    public function can_store_account_specialty()
    {
        $account = Account::factory()->create();
        $specialty = Specialty::factory()->create();

        $this->postJson(route('admin.account-specialty.store'), [
            'account_id' => $account->id,
            'specialty_id' => $specialty->id,
            'approved' => true,
        ])->assertCreated()
            ->assertJson([
                'account_id' => $account->id,
                'specialty_id' => $specialty->id,
                'approved' => true,
            ]);

        $this->assertDatabaseHas(AccountSpecialty::Table(), [
            'account_id' => $account->id,
            'specialty_id' => $specialty->id,
            'approved' => true,
        ]);
    }

    /** @test */
    public function can_destroy_account_specialty()
    {
        $accountSpecialty = AccountSpecialty::factory()->create();

        $this->deleteJson(route('admin.account-specialty.destroy', [$accountSpecialty]))
            ->assertOk();

        $this->assertDatabaseMissing('accounts_specialties', [
            'id' => $accountSpecialty->id,
        ]);
    }
}
