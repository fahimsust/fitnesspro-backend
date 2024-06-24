<?php

namespace Tests;

use Illuminate\Foundation\Http\FormRequest;

trait RequestFactoryHelpers
{

    public function postRequestFactory(string $class): FormRequest
    {
        return $this->formRequestFactory($class, "POST");
    }

    public function getRequestFactory(string $class): FormRequest
    {
        return $this->formRequestFactory($class);
    }

    public function formRequestFactory(
        string $class,
        string $method = "GET"
    ): FormRequest
    {
        $formRequest = new $class;
        $formRequest->setMethod($method);
        $formRequest->request->add($class::factory()->create());

        return $formRequest;
    }
}
