<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountRequest;
use App\Api\Admin\Accounts\Requests\AccountSearchRequest;
use Domain\Accounts\Actions\UpdateAccount;
use Domain\Accounts\Models\Account;
use Domain\Accounts\QueryBuilders\AccountQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
    public function index(AccountSearchRequest $request)
    {
        $accounts = Account::search($request)
            ->when(
                $request->filled('order_by'),
                fn (AccountQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc'),
                fn (AccountQuery $query) => $query->orderBy('created_at', 'DESC')
            )
            ->with('status', 'type')
            ->paginate($request?->per_page);

        $accounts->getCollection()->transform(function ($account) {
            return $account->makeVisible(['username']);
        });
        return response(
            $accounts,
            Response::HTTP_OK
        );
    }
    public function update(AccountRequest $request, Account $account)
    {
        return response(
            UpdateAccount::run($request, $account),
            Response::HTTP_CREATED
        );
    }
    public function show(Account $account)
    {
        return response(
            $account->makeVisible(['username', 'admin_notes']),
            Response::HTTP_CREATED
        );
    }
}
