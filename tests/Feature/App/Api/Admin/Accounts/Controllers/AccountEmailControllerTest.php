<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountEmailRequest;
use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteMessageTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Support\Mail\MailerMailable;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccountEmailControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_email_sent()
    {
        $account = Account::factory()->create();
        AdminEmailsSent::factory(5)->create(['account_id' => $account->id]);
        $this->getJson(route('admin.contact-customer.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'subject',
                    'content',
                    'sent_date',
                    'sent_by',
                    'sent_to_account'
                ]
            ])
            ->assertJsonCount(5);
    }
    /** @test */
    public function can_send_email()
    {
        Site::factory()->create();
        SiteMessageTemplate::factory()->create();
        Mail::fake();
        $account = Account::factory()->create();
        AccountEmailRequest::fake();
        $this->postJson(route('admin.contact-customer.store'));
        $this->assertDatabaseCount(AdminEmailsSent::Table(), 1);

        Mail::assertSent(MailerMailable::class, function ($mail) use ($account) {
            return $mail->to[0]['address'] === $account->email;
        });
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        AccountEmailRequest::fake(['body' => '']);
        $this->postJson(route('admin.contact-customer.store'))
            ->assertJsonValidationErrorFor('body')
            ->assertStatus(422);

        $this->assertDatabaseCount(AdminEmailsSent::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        AccountEmailRequest::fake();
        $this->postJson(route('admin.contact-customer.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AdminEmailsSent::Table(), 0);
    }
}
