<?php

namespace App\Api\Admin\Speciality\Controllers;

use App\Api\Admin\Speciality\Requests\SpecialitySearchRequest;
use Domain\Accounts\Models\Specialty;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SpecialitiesController extends AbstractController
{
    public function __invoke(SpecialitySearchRequest $request)
    {
        return response(
            Specialty::query()
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->search($request)
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
