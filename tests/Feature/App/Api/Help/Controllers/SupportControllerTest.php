<?php

namespace Tests\Feature\App\Api\Help\Controllers;

use Database\Seeders\SiteMessageTemplateSeeder;
use Database\Seeders\SiteSeeder;
use Domain\Messaging\Mail\SupportContact;
use Domain\Sites\Models\Site;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use function route;

class SupportControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seedSite();
    }

    private function seedSite(): void
    {
        $this->seed([SiteSeeder::class, SiteMessageTemplateSeeder::class]);
    }

    private function mailFake()
    {
        Mail::fake();
        Mail::assertNothingSent();
    }

    private function postSupport(): void
    {
        $this->postJson(route('mobile.support.store'), [
            'name' => 'test name',
            'email' => 'john@782media.com',
            'phone' => '555-444-3333',
            'message' => "testing message\r\nhello!",
        ])->assertCreated();
    }

    private function mailSent(): void
    {
        Mail::assertSent(SupportContact::class, function ($mail) {
            return $mail->hasTo(Site::first()->email);
        });
    }

    /** @test */
    public function account_authed_can_submit()
    {
        $this->apiTestToken();

        $this->mailFake();

        $this->postSupport();

        $this->mailSent();
    }

    /** @test */
    public function app_authed_can_submit()
    {
        $this->appApiTestToken();

        $this->mailFake();

        $this->postSupport();

        $this->mailSent();
    }

    /** @test */
    public function not_open_to_public()
    {
        $this->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);

        $this->postJson(route('mobile.support.store'));
    }
}
