<?php

namespace Domain\Payments\Services\AuthorizeNet\Actions;

use net\authorize\api\contract\v1\ANetApiResponseType;
use net\authorize\api\controller\base\ApiOperationBase;
use Support\Contracts\AbstractAction;

class ExecuteApiCall extends AbstractAction
{
    public ApiOperationBase $controller;
    public string $environment;
    private ?AnetApiResponseType $responseType = null;

    //not using constructor so we can mock in tests
    public static function run(...$args)
    {
        $obj = resolve(static::class);

        $obj->controller = $args[0];
        $obj->environment = $args[1];

        return $obj->execute();
    }

    public function result(): ANetApiResponseType
    {
        return $this->responseType;
    }

    public function execute(): static
    {
        $this->responseType = $this->controller->executeWithApiResponse(
            $this->environment
        );

        return $this;
    }
}
