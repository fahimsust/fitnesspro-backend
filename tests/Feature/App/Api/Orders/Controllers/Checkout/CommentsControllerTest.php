<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Domain\Orders\Models\Checkout\Checkout;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class CommentsControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToPayForCheckout();
    }

    /** @test */
    public function can()
    {
        $this->assertNull($this->checkout->comments);

        $newComment = 'test comments';

        $response = $this->postJson(
            route(
                'checkout.comments',
                $this->checkout->uuid
            ),
            [
                'comments' => $newComment,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                'checkout' => [
                    'comments'
                ]
            ]);

        $this->assertEquals(
            $this->checkout->fresh()->comments,
            $newComment
        );
        $this->assertEquals(
            $response->json('checkout.comments'),
            $newComment
        );

//        dd($response->json());
    }

    /** @test */
    public function can_error()
    {
        $response = $this->postJson(
            route(
                'checkout.comments',
                $this->checkout->uuid
            ),
            [
                'comments' => null
            ]
        )
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('comments');

//        dd($response->json());
    }
}
