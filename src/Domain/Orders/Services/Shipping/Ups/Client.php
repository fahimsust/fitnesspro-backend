<?php

namespace Domain\Orders\Services\Shipping\Ups;

use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class Client
{
    private PendingRequest $request;
    private Response $response;

    public static bool $dumpResponse = false;

    public function __construct(
        public string  $clientId,
        public string  $clientSecret,
        public Modes   $mode,
        public ?string $token = null
    )
    {
    }

    private function resetRequest(): PendingRequest
    {
        return $this->request = \Http::withToken($this->token)
            ->asJson();
    }

    public function post(
        string $uri,
        ?array $data = null,
        ?array $query = null,
    ): static
    {
        if ($query) {
            $uri .= "?" . http_build_query($query);
        }

        $this->request(
            action: "post",
            uri: $uri,
            data: $data
        );

        return $this;
    }

    public function get(
        string $uri,
        ?array $data = null,
    ): static
    {
        if ($data) {
            $uri .= "?" . http_build_query($data);
        }

        $this->request(
            action: "get",
            uri: $uri
        );

        return $this;
    }

    public function request(
        string $action,
        string $uri,
        ?array $data = null,
    ): static
    {
//        dd($data);
        $this->handleResponse(
            $this->resetRequest()
                ->$action(
                    $this->url(ltrim($uri, '/')),
                    $data
                )
        );

        return $this;
    }

    private function authRequest(): PendingRequest
    {
        return $this->request = \Http::withToken(
           base64_encode($this->clientId.':'.$this->clientSecret),
            "Basic"
        )
            ->asForm();
    }

    protected function url(string $uri): string
    {
        return $this->mode->url() . $uri;
    }

    public function generateToken(
        string $authCode,
        string $redirectUri
    ): Token
    {
        $this->handleResponse(
            $this->authRequest()
                ->post(
                    $this->url("security/v1/oauth/token"),
                    [
                        'grant_type' => 'authorization_code',
                        'code' => $authCode,
                        'redirect_uri' => $redirectUri
                    ]
                )
        );

        return Token::fromApi($this->json());
    }

    public function refreshToken(string $refreshToken): Token
    {
        $this->handleResponse(
            $this->authRequest()
                ->post(
                    $this->url("security/v1/oauth/refresh"),
                    [
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $refreshToken
                    ]
                )
        );

        return Token::fromApi($this->json());
    }

    protected function handleResponse(Response $response): static
    {
        $this->response = $response;

        if (self::$dumpResponse) {
            dd(
                $this->response->body(),
                $this->response->status(),
                $this->response->headers(),
                $this->request->dump(),
            );
        }

        $this->response
            ->throw();

        return $this;
    }

    public function json(string $key = null): array
    {
        return $this->response->json($key);
    }
}
