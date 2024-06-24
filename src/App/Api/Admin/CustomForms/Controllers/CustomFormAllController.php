<?php

namespace App\Api\Admin\CustomForms\Controllers;

use Domain\CustomForms\Models\CustomForm;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CustomFormAllController extends AbstractController
{
    public function index()
    {
        return response(
            CustomForm::all(),
            Response::HTTP_OK
        );
    }
}
