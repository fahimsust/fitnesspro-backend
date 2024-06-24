<?php

namespace Tests\Unit\Domain\Sites\Models;

use Database\Seeders\MessageTemplateSeeder;
use Database\Seeders\SiteSeeder;
use Domain\Locales\Models\Language;
use Domain\Messaging\Actions\BuildMessageTemplateMailable;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Actions\SendMailFromSite;
use Domain\Sites\Enums\RequireLogin;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Domain\Sites\Models\SiteMessageTemplate;
use Domain\Sites\Models\SiteTranslation;
use Illuminate\Support\Facades\Mail;
use Support\Helpers\HandleMessageKeys;
use Support\Mail\MailerMailable;
use Support\Mail\MessageTemplateMailable;
use Tests\TestCase;
use function config;

class SiteTest extends TestCase
{
    protected Site $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteSeeder::class);

        $this->site = Site::firstOrFail();
    }

    /** @test */
    public function can_seed()
    {
        $this->assertEquals('Default Site', $this->site->name);
    }

    /** @test */
    public function can_get_url()
    {
//        $this->assertEquals(config('app.url'), $this->site->url());
        $this->assertEquals(config('app.url') . '/', $this->site->url);
    }

    /** @test */
    public function can_send_basic_mail()
    {
        $this->seedMessageTemplate();

        Mail::fake();
        Mail::assertNothingSent();

        $mailer = new SendMailFromSite($this->site);

        $toEmail = 'john@782media.com';

        $mailer
            ->to($toEmail, 'john todd')
            ->from('test@782media.com', 'test todd')
            ->subject('test MailerMailable')
            ->plainText("plain text here\r\nhello!")
            ->html('<p>html here</p><p><b>hello!</b></p>')
            ->send();

        Mail::assertSent(MailerMailable::class, function ($mail) use ($toEmail) {
            return $mail->hasTo($toEmail);
        });
    }

    /** @test */
    public function can_queue_message_template_mailable()
    {
        Mail::fake();

        $this->seed([
            MessageTemplateSeeder::class,
        ]);

        $this->seedMessageTemplate();
        $this->createTestAccount();

        BuildMessageTemplateMailable::run(
            MessageTemplate::FindBySystemId(6)->replaceKeysUsingHandler(
                (new HandleMessageKeys)
                    ->setSite($this->site)
                    ->setAccount($this->account)
            ),
            $this->site,
            $this->account
        )->queueIt();

        Mail::assertQueued(
            MessageTemplateMailable::class,
            fn($mail) => $mail->template->system_id == 6
        );
    }

    /** @test */
    public function can_get_message_template()
    {
        $otherSitesMessageTemplate = SiteMessageTemplate::factory()
            ->create(['site_id' => Site::factory()->create()->id]);
        $this->seedMessageTemplate();

        $siteMessageTemplate = $this->site->messageTemplate;

        $this->assertNotEquals($otherSitesMessageTemplate->site_id, $siteMessageTemplate->site_id);
        $this->assertEquals($this->site->id, $siteMessageTemplate->site_id);
    }

    /** @test */
    public function can_get_site_languages()
    {
        SiteLanguage::factory()->create();
        $this->assertInstanceOf(SiteLanguage::class, $this->site->siteLanguages()->first());
    }
    /** @test */
    public function can_get_languages()
    {
        SiteLanguage::factory()->create();
        $this->assertInstanceOf(Language::class, $this->site->languages()->first());
    }
    /** @test */
    public function can_get_site_translations()
    {
        SiteTranslation::factory()->create();
        $this->assertInstanceOf(SiteTranslation::class, $this->site->translations()->first());
    }

    /** @test */
    public function get_required_login_for()
    {
        $this->assertEquals(RequireLogin::None, $this->site->require_login);
        $this->assertFalse(
            $this->site->require_login->forSite()
            && $this->site->require_login->forCatalog()
            && $this->site->require_login->forCheckout()
        );

        $this->site->require_login = RequireLogin::Site;
        $this->assertEquals(RequireLogin::Site, $this->site->require_login);
        $this->assertTrue(
            $this->site->require_login->forSite()
            && $this->site->require_login->forCatalog()
            && $this->site->require_login->forCheckout()
        );

        $this->site->require_login = RequireLogin::Catalog;
        $this->assertEquals(RequireLogin::Catalog, $this->site->require_login);
        $this->assertTrue(
            !$this->site->require_login->forSite()
            && $this->site->require_login->forCatalog()
            && $this->site->require_login->forCheckout()
        );

        $this->site->require_login = RequireLogin::Checkout;
        $this->assertEquals(RequireLogin::Checkout, $this->site->require_login);
        $this->assertTrue(
            !$this->site->require_login->forSite()
            && !$this->site->require_login->forCatalog()
            && $this->site->require_login->forCheckout()
        );
    }

    private function seedMessageTemplate()
    {
        SiteMessageTemplate::factory()->create(['site_id' => $this->site->id]);
    }
}
