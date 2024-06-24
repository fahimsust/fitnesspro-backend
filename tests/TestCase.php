<?php

namespace Tests;

use App\Firebase\App;
use App\Firebase\User;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountField;
use Domain\CustomForms\Models\CustomField;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RequestFactoryHelpers;
    use CreatesApplication;
    use FastRefreshDatabase;

    protected Account $account;

    protected bool $createApiToken = true;

    protected $cellphoneField;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    protected function apiTestToken(): void
    {
        $this->createTestAccount();

        $this->actingAs(new User($this->account), 'firebase');
    }

    protected function appApiTestToken()
    {
        $this->actingAs(new App('test'), 'firebase');
    }

    protected function createLoginAccount()
    {
        $this->actingAs($this->createTestAccount(), 'web');
    }

    protected function createTestAccount()
    {
        return $this->account = Account::factory([
            'username' => 'test',
            'password' => Hash::make('pass'),
            'status_id' => 1,
        ])->create();
    }

    protected function seedAccountCellphoneField()
    {
        //create cellphone field in accounts_addtl_fields for $this->account
        $cellphoneCustomField = CustomField::factory()->create(['id' => config('account_fields.cellphone_field_id')]);
        $this->cellphoneField = AccountField::factory()->create([
            'account_id' => $this->account->id,
            'field_id' => $cellphoneCustomField->id,
            'value' => '1112223333',
        ]);
    }
}
