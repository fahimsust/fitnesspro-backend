<?php

namespace Tests\Unit\Domain\Accounts\Actions\Signup;

use Tests\TestCase;

class CreateAccountFromNewMemberDataTest extends TestCase
{
//     protected function setUp(): void
//     {
//         parent::setUp();

//         $this->seed([
//             SiteSeeder::class,
//             SpecialtySeeder::class,
//             CountrySeeder::class,
//             StateSeeder::class,
//             AccountTypeSeeder::class,
//         ]);
//     }

//     /** @test */
//     public function can_create_account()
//     {
//         Event::fake();

//         //todo replace with request factory
//         //Response : I need an object of NewMemberRequest to call RegisteringMemberData::fromRequest($memberRequest).
// //        $accountData = NewMemberRequestFactory::new()->create();
// //
// //todo - @fahim, i think this is what you want.  i've built it into a helper method
// //        $memberRequest = new NewMemberRequest();
// //        $memberRequest->setMethod('POST');
// //        $memberRequest->request->add(NewMemberRequest::factory()->create());
//         $memberRequest = $this->formRequestFactory(NewMemberRequest::class, "POST");
//         //dd($memberRequest->all());

//         $createdAccount = CreateAccountFromNewMemberData::run(
//             RegisteringMemberData::fromRequest(
//                 $memberRequest
//             ),
//             AddressData::fromRequest(
//                 $memberRequest
//             )
//         );

//         $this->assertEquals($createdAccount->username, $createdAccount->username);
//         $this->assertEquals($createdAccount->email, $createdAccount->email);

//         $this->assertEquals([1, 2], $createdAccount->specialties->pluck('specialty_id')->toArray());

//         Event::assertDispatched(AccountCreated::class);
//     }
}
