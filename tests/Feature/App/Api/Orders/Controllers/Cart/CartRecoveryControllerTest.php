<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart;

use App\Api\Orders\Exceptions\Cart\CartMissingFromSession;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Actions\Cart\StartCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;
use function route;

class CartRecoveryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @todo */
    public function can_recover_cart()
    {
        //find cart by matching hash, load cart into session

        //also check against account, error to login if not logged in and cart is for an account
    }
}
