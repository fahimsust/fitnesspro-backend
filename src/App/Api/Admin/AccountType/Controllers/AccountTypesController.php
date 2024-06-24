<?php

namespace App\Api\Admin\AccountType\Controllers;

use App\Api\Admin\AccountType\Requests\AccountTypeSearchRequest;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\QueryBuilders\AccountTypeQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountTypesController extends AbstractController
{
    public function __invoke(AccountTypeSearchRequest $request)
    {
        return response(
            AccountType::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn (AccountTypeQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->with('defaultStatus','discountLevel')
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
