<?php

namespace Domain\Accounts\ValueObjects;

use App\Api\Accounts\Requests\Registration\CreateAccountFromBasicInfoRequest;
use Spatie\LaravelData\Data;

class BasicAccountInfoData extends Data
{
    public function __construct(
        public string  $username,
        public string  $email,
        public string  $password,
        public string  $first_name,
        public string  $last_name,
        public ?string $phone = null,
        public ?int    $affiliate_id = null,
    )
    {
    }

    public static function fromRequest(
        CreateAccountFromBasicInfoRequest $request,
        ?int                              $affiliateId = null
    ): static
    {
        return new static(
            username: $request->username,
            email: $request->email,
            password: $request->password,
            first_name: $request->first_name,
            last_name: $request->last_name,
            phone: $request->phone,
            affiliate_id: $affiliateId,
        );
    }
}
