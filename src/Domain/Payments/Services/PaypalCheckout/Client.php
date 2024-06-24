<?php

namespace Domain\Payments\Services\PaypalCheckout;

use Domain\Payments\Services\PaypalCheckout\Enums\Endpoints;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    private PendingRequest $request;
    public Response $response;

    public static bool $dumpResponse = false;

    public function __construct(
        public string      $clientId,
        private string     $clientSecret,
        public PaypalModes $mode,
        public ?string     $accessToken = null
    )
    {
        $this->resetRequest();
    }

    protected function resetRequest(): static
    {
        $this->request = Http::asJson();

        return $this;
    }


    public function request(
        string $action,
        string $uri,
        ?array $data = null,
    ): Response
    {
        $url = $this->mode->url() . ltrim($uri, '/');

        $this->response = $this->request
            ->withToken($this->accessToken)
            ->$action(
                $url,
                $data
            );

        if (self::$dumpResponse) {
            dd(
                $action,
                $url,
                $data,
                $this->request->dump(),
                $this->response->body(),
                $this->response->status(),
                $this->response->headers()
            );
        }

        return $this->response->throw();
    }

    public function requestToken(): Response
    {
        $this->request = Http::asForm()
            ->withBasicAuth($this->clientId, $this->clientSecret);

        $this->request(
            action: "post",
            uri: Endpoints::Token->baseUri(),
            data: [
                'grant_type' => 'client_credentials'
            ]
        );

        $this->resetRequest();

        return $this->response;
    }

    public function post(
        string $uri,
        ?array $data = null,
    ): static
    {
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

    public function json(string $key = null): array
    {
        return $this->response->json($key);
    }
}
