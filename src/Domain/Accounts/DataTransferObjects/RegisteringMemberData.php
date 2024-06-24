<?php

namespace Domain\Accounts\DataTransferObjects;

use App\Api\Accounts\Requests\Membership\NewMemberRequest;
use Domain\Accounts\Models\AccountType;
use DOmain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

class RegisteringMemberData extends Data
{
    public string $email;
    public string $username;
    public string $password;
    public ?string $phone = null;
    public int $type_id = 1;

    public ?int $affiliate_id = null;
    public ?int $cim_profile_id = null;

    public string $first_name;
    public string $last_name;

    public ?int $level_id = null;
    public ?float $amount_paid = null;
    public ?float $subscription_price = null;
    public ?int $product_id = null;
    public ?int $order_id = null;

    public array $specialties = [];

    public ?AccountType $accountType = null;
    public ?MembershipLevel $level = null;

    //these aren't part of registration process so not needed in this dto
    //public ?string $admin_notes = null;
//    public ?int $photo_id = null;
//    public ?int $default_billing_id = null;
//    public ?int $default_shipping_id = null;
//    public ?int $status_id = null;
//    public ?int $loyaltypoints_id = null;

    public function __construct() {
    }

    public static function fromRequest(NewMemberRequest $request): static
    {
        if (Cookie::get('affiliate_referral_id') > 0 && ! $request->affiliate_id) {
            $request->affiliate_id = Cookie::get('affiliate_referral_id');

            Cookie::queue(
                Cookie::forget('affiliate_referral_id')
            );
        }

        unset($request->password_confirmation);
        unset($request->email_confirmation);

        return self::from([
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => $request['password'],
            'phone' => $request['phone'],
            'type_id' => $request['type_id'],
            'affiliate_id' => $request['affiliate_id'],
            'cim_profile_id' => $request['cim_profile_id'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'level_id' => $request['level_id'],
            'amount_paid' => $request['amount_paid'],
            'subscription_price' => $request['subscription_price'],
            'specialties' => $request['specialties'],
            'product_id' => $request['product_id'],
        ]);
    }

    public function accountType(): AccountType
    {
        return $this->accountType ?: AccountType::findOrFail($this->type_id);
    }

    public function membershipLevel(): MembershipLevel
    {
        return $this->level = MembershipLevel::find($this->level_id);
    }

    public function subscriptionArray(): array
    {
        return [
            'level_id' => $this->level_id,
            'amount_paid' => $this->amount_paid,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s', strtotime('+1 year')),
            'subscription_price' => $this->subscription_price,
            'product_id' => $this->product_id,
            'order_id' => $this->order_id,
        ];
    }

    public function accountArray(): array
    {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'type_id' => $this->type_id,
            'affiliate_id' => $this->affiliate_id,
            'cim_profile_id' => $this->cim_profile_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'site_id' => config('site.id'),
            'status_id' => $this->accountType()->default_account_status,
        ];
    }
}
