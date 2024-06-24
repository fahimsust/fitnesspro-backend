<?php

namespace App\Api\Admin\MemberShipLevels\Controllers;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MemberShipLevelController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            MembershipLevel::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
