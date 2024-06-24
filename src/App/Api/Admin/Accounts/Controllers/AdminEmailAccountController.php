<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountEmailRequest;
use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\AdminUsers\LogAdminEmailToSend;
use Domain\Messaging\Jobs\SendAdminEmailToAccount;
use Support\Controllers\AbstractController;

class AdminEmailAccountController extends AbstractController
{
    public function __invoke(AccountEmailRequest $request)
    {
        SendAdminEmailToAccount::dispatch(
            LogAdminEmailToSend::now(
                account: LoadAccountByIdFromCache::now($request->account_id),
                subject: $request->subject,
                body: $request->body,
                messageTemplateId: $request->message_template_id,
                adminUserId: auth()->user()->id,
                orderId:$request->order_id,
            )
        );

        return response()->json([
            'message' => 'Sending email to account',
        ]);
    }
}
