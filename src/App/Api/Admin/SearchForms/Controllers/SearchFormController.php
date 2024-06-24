<?php

namespace App\Api\Admin\SearchForms\Controllers;

use Domain\Products\Models\SearchForm\SearchForm;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SearchFormController extends AbstractController
{
    public function index()
    {
        return response(
            SearchForm::where('status',1)->get(),
            Response::HTTP_OK
        );
    }
}
