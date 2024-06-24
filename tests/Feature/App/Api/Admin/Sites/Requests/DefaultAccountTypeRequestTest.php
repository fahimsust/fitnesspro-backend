<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\DefaultAccountTypeRequest;
use Domain\Accounts\Models\AccountType;
use Domain\Sites\Enums\RequireLogin;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class DefaultAccountTypeRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private DefaultAccountTypeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DefaultAccountTypeRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'account_type_id' => ['numeric', 'exists:' . AccountType::Table() . ',id', 'required'],
                'required_account_types' => ['array','nullable'],
                'requireLogin' => ['string',Rule::in(array_column(RequireLogin::cases(),'value')),'required'],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->createAndAuthAdminUser();

        $this->assertTrue($this->request->authorize());
    }
}
