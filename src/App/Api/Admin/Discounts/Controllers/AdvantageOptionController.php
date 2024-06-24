<?php
namespace App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdvantageOptionController extends AbstractController
{
    public function index()
    {
        return response(
            DiscountAdvantageTypes::options(),
            Response::HTTP_OK
        );
    }
}
