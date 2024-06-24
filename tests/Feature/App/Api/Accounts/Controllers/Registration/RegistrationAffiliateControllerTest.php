<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use Domain\Accounts\Actions\Registration\AssignAffiliateToRegistration;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use function route;


class RegistrationAffiliateControllerTest extends TestCase
{
    public Registration $registration;
    private array $affiliateStructure;
    private Collection $affiliates;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registration = Registration::factory()->create();
        $this->affiliates = Affiliate::factory(2)->create();
        $this->affiliateStructure = [
            'id',
            'email',
            'name',
            'status',
            'affiliate_level_id',
            'account_id',
        ];
        session(['registrationId' => $this->registration->id]);
    }

    /** @test */
    public function can_assign_affiliate_methods()
    {
        $this->postJson(
            route('registration.affiliate.store'),
            [
                'affiliate_id' => $this->affiliates->first()->id,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(
                $this->affiliateStructure
            );

        $this->assertEquals($this->affiliates->first()->id, $this->registration->fresh()->affiliate_id);
    }

    /** @test */
    public function can_return_selected_affiliate()
    {
        $this->registration->update([
            'affiliate_id' => $this->affiliates->first()->id
        ]);

        $this->getJson(route('registration.affiliate.show'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->affiliateStructure
            );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('registration.affiliate.store'), [ 'affiliate_id' => 0])
            ->assertJsonValidationErrorFor('affiliate_id')
            ->assertStatus(422);

        $this->assertNotEquals($this->affiliates->first()->id, $this->registration->fresh()->affiliate_id);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignAffiliateToRegistration::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('registration.affiliate.store'), [ 'affiliate_id' => $this->affiliates->first()->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($this->affiliates->first()->id, $this->registration->fresh()->affiliate_id);
    }

    /** @test */
    public function can_return_exception()
    {
        $this->registration->update([
            'affiliate_id' => $this->affiliates[1]->id
        ]);

        $this->postJson(route('registration.affiliate.store'), [ 'affiliate_id' => $this->affiliates->first()->id])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('affiliate_id');

        $this->assertNotEquals($this->affiliates->first()->id, $this->registration->fresh()->affiliate_id);
    }
}
