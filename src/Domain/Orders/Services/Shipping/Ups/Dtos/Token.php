<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Token extends Data
{
    public function __construct(
        public string $refreshToken,
        public string $accessToken,
        public string $tokenType,
        public string $expiresIn,
        public string $refreshTokenExpiresIn,
        public string $issuedAt,
        public string $refreshTokenIssuedAt,
        public string $status,
        public string $refreshTokenStatus,
        public string $clientId,
        public Carbon|string|null $expiresAt = null,
        public ?string $scope = null,
        public ?string $refreshCount = null,
        public ?string $oldAccessTokenLifeTime = null,
    )
    {
        if(is_string($this->expiresAt)) {
            $this->expiresAt = Carbon::parse($this->expiresAt);
        }
    }

    public static function fromApi(array $data): self
    {
        return new self(
            refreshToken: $data['refresh_token'],
            accessToken: $data['access_token'],
            tokenType: $data['token_type'],
            expiresIn: $data['expires_in'],
            refreshTokenExpiresIn: $data['refresh_token_expires_in'],
            issuedAt: $data['issued_at'],
            refreshTokenIssuedAt: $data['refresh_token_issued_at'],
            status: $data['status'],
            refreshTokenStatus: $data['refresh_token_status'],
            clientId: $data['client_id'],
            expiresAt: Carbon::now()->addSeconds($data['expires_in']),
            scope: $data['scope'] ?? null,
            refreshCount: $data['refresh_count'] ?? null,
            oldAccessTokenLifeTime: $data['old_access_token_life_time'] ?? null,
        );
    }

    public function isExpired(): bool
    {
        if ($this->expiresAt) {
            return $this->expiresAt->isBefore(now()->addMinute());
        }

        return Carbon::createFromTimestamp($this->issuedAt)
            ->addSeconds($this->expiresIn)
            ->isBefore(now()->addMinute());
    }
}

/*
    "refresh_token_expires_in": "604799",
    "refresh_token_status": "approved",
    "token_type": "Bearer",
    "issued_at": "1662558626563",
    "client_id": "testClientID",
    "access_token": "access_token",
    "refresh_token": "refresh_token",
    "scope": "",
    "refresh_token_issued_at": "1662558626563",
    "expires_in": "14399",
    "refresh_count": "0",
    "status": "approved"


    "old_access_token_life_time": "61228",
 */
