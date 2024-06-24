<?php

namespace Domain\Payments\Services\AuthorizeNet\Actions;

use net\authorize\api\contract\v1\ANetApiResponseType;
use Support\Contracts\AbstractAction;

class MockApiResponse extends AbstractAction
{
    public function __construct(
        public ANetApiResponseType $responseType,
        public string $jsonResponse,
    )
    {
    }

    public function result(): ANetApiResponseType
    {
        return $this->responseType;
    }

    public function execute(): static
    {
        $this->responseType->set($this->parseJson());

        return $this;
    }

    public function parseJson()
    {
        $possibleBOM = substr($this->jsonResponse, 0, 3);
        $utfBOM = pack("CCC", 0xef, 0xbb, 0xbf);

        if (0 === strncmp($possibleBOM, $utfBOM, 3)) {
            return json_decode( substr($this->jsonResponse,3), true);
        }
        else {
            return json_decode($this->jsonResponse, true);
        }
    }
}
