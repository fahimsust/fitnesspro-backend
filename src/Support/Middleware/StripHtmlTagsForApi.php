<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StripHtmlTagsForApi
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $response->setData(
                $this->updateJson($response->getData())
            );
        }

        return $response;
    }
    /**
     * @param  string  $value
     *
     * @return string
     */
    private function modifyString(string $value): string
    {
        return html_entity_decode(htmlspecialchars_decode(strip_tags($value)));
    }

    private function updateJson($data)
    {
        if (! is_array($data) && ! is_object($data) && ! is_iterable($data)) {
            return is_string($data) ? $this->modifyString($data) : $data;
        }

        foreach ($data as $key => $value) {
            $newValue = is_string($value) ? $this->modifyString($value) : $this->updateJson($value);

            if (is_array($data)) {
                $data[$key] = $newValue;
            } else {
                $data->$key = $newValue;
            }
        }

        return $data;
    }
}
