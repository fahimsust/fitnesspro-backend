<?php

namespace App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountMembershipRequest;
use Domain\Accounts\Actions\Membership\CancelActiveMembershipForAccount;
use Domain\Accounts\Actions\Membership\CreateMembership;
use Domain\Accounts\Enums\SubscriptionStatus;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AccountMembershipController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Subscription::orderBy('id', 'DESC')
                ->where('account_id', $request->account_id)
                ->with('level', 'product')->get(),
            Response::HTTP_OK
        );
    }
    public function store(AccountMembershipRequest $request)
    {
        $account = Account::find($request->account_id);
        $level = MembershipLevel::find($request->level_id);
        $product_id =  $level->product->id;
        if ($request->cancel_active && $request->cancel_active == 1) {
            CancelActiveMembershipForAccount::run($account);
        }
        return response(
            CreateMembership::run(
                $account,
                [
                    'level_id' => $request->level_id,
                    'amount_paid' => $request->amount_paid,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'subscription_price' => 0,
                    'product_id' => $product_id,
                    'order_id' => null,
                ]
            )->subscription,
            Response::HTTP_CREATED
        );
    }
    public function show(Account $accountMembership)
    {
        return response(
            $accountMembership->activeMembership,
            Response::HTTP_OK
        );
    }
    public function destroy(Subscription $accountMembership)
    {
        return response(
            $accountMembership->update([
                'status' => SubscriptionStatus::INACTIVE,
                'cancelled' => now(),
            ]),
            Response::HTTP_OK
        );
    }
}
