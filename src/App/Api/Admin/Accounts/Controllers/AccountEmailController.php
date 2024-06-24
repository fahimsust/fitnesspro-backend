<?php

namespace App\Api\Admin\Accounts\Controllers;

use Domain\AdminUsers\Models\AdminEmailsSent;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountEmailController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            AdminEmailsSent::with([
                'sentBy',
                'sentToAccount',
            ])
                ->where('account_id', $request->account_id)
                ->orWhere(function ($query) use ($request) {
                    $query->whereHas('order', function ($q) use ($request) {
                        $q->where('account_id', $request->account_id);
                    });
                })
                ->orderBy('sent_date', 'desc')
                ->limit(100)
                ->get(),
            Response::HTTP_OK
        );
    }
}
