<?php

namespace Tests\Feature\App\Api\Support\Controllers;

use App\Api\Support\Requests\SupportEmailRequest;
use Domain\Sites\Models\Site;
use Domain\Support\Actions\Mail\SendSupportEmail;
use Domain\Support\Models\SupportDepartment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Support\Mail\CustomMailable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;


class SupportEmailControllerTest extends TestCase
{
    private Collection $supportDepartments;

    protected function setUp(): void
    {
        parent::setUp();

        $this->supportDepartments = SupportDepartment::factory(5)->create();
    }

    /** @test */
    public function can_get_support_department()
    {
        $this->getJson(route('support.departments'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5)
            ->assertJsonStructure(
                [
                    '*' => [
                        'name',
                        'email',
                        'subject'
                    ]
                ]
            );
    }

    /** @test */
    public function can_send_support_email()
    {
        $site = Site::factory()->create(['id' => config('site.id')]);

        Mail::fake();
        SupportEmailRequest::fake();

        $this->withoutExceptionHandling();

        $this->postJson(route('support.send-email'), ['email' => "test@test.com"])
            ->assertCreated();

        Mail::assertQueued(CustomMailable::class);
        Mail::assertQueued(
            CustomMailable::class,
            fn($mail) =>
//                dd($mail) &&
                $mail->to[0]['address'] == $this->supportDepartments->first()->email
                && $mail->from[0]['address'] == $site->sendFrom()
                && $mail->replyTo[0]['address'] == "test@test.com"
        );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        Mail::fake();
        SupportEmailRequest::fake();

        $this->postJson(route('support.send-email'), ['email' => ""])
            ->assertJsonValidationErrorFor('email')
            ->assertStatus(422);

        Mail::assertNotQueued(
            CustomMailable::class,
        );
    }

    /** @test */
    public function can_handle_errors()
    {
        Mail::fake();
        SupportEmailRequest::fake();

        $this->postJson(route('support.send-email'))
            ->assertStatus(404);

        Mail::assertNotQueued(
            CustomMailable::class,
        );
    }
}
