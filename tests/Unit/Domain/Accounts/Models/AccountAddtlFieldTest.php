<?php

namespace Tests\Unit\Domain\Accounts\Models;

use Database\Seeders\SiteSeeder;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountField;
use Tests\UnitTestCase;

class AccountAddtlFieldTest extends UnitTestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private AccountField $accountField;

    /** @test */
    public function can_get_account()
    {
        $account = $this->accountField->account;

        $this->assertIsObject($account);
        $this->assertEquals($this->accountField->account_id, $account->id);
    }

    /** @test */
    public function can_get_form()
    {
        $customForm = $this->accountField->form;

        $this->assertIsObject($customForm);
    }

    /** @test */
    public function can_get_form_section()
    {
        $section = $this->accountField->formSection;

        $this->assertIsObject($section);
    }

    /** @test */
    public function can_get_field()
    {
        $field = $this->accountField->field;

        $this->assertIsObject($field);
    }

    /** @test */
    public function can_find_by_account_and_field_id()
    {
        $accountField = AccountField::FindByAccountAndFieldId(Account::first(), $this->accountField->field_id);

        $this->assertIsObject($accountField);
    }

    /** @test */
    public function html_tags_are_decoded_from_field_value()
    {
//        dd($this->accountField);
        $htmlContent = $this->accountField->value;

        $this->assertTrue($this->isHtml($htmlContent));
    }

    /** @test */
    public function can_seed()
    {
        $this->assertCount(1, AccountField::all());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountField = AccountField::factory()->create();
    }
}
