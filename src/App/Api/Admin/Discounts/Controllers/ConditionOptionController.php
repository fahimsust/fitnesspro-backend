<?php
namespace App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountConditionTypes;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionOptionController extends AbstractController
{
    public function index()
    {
        return response(
            DiscountConditionTypes::options(),
            Response::HTTP_OK
        );
    }
}
