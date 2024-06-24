<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\SetRegistrationMembershipLevelRequest;
use App\Api\Accounts\Rules\CheckValidLevelMethod;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class SelectMembershipLevelRequestTest extends TestCase
{
    use AdditionalAssertions;

    private SetRegistrationMembershipLevelRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SetRegistrationMembershipLevelRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'level_id' => [
                    'integer',
                    'required',
                    'exists:' . MembershipLevel::table() . ',id',
                    new CheckValidLevelMethod
                ]
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->assertTrue($this->request->authorize());
    }

    /** @test */
    public function can_validate_level_and_return_errors()
    {
        $level = MembershipLevel::factory()->create(['status' => 0]);
        $registration = Registration::factory()->create();

        $this->postJson(route('registration.level.store'), ['level_id' => $level->id, 'registration_id' => $registration->id])
            ->assertJsonValidationErrorFor('level_id')
            ->assertJsonFragment(["message" => __('Invalid membership level')])
            ->assertStatus(422);

        $this->assertNotEquals($level->id, Registration::first()->level_id);
    }
}
