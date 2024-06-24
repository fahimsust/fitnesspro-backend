<?php

namespace Domain\Sites\Actions;

use App\Api\Admin\Sites\Requests\CreateSiteRequest;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateSite
{
    use AsObject;

    public function handle(
        CreateSiteRequest $request
    ): Site {
        $site = Site::create(
            [
                'name' => $request->name,
                'domain' => $request->domain,
                'email' => $request->email,
                'phone' => $request->phone,
                'url' => $request->url,
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_desc' => $request->meta_desc,
                'logo_url' => $request->logo_url,
            ]
        );

        $site->settings()->create();
        $site->messageTemplate()->create();

        return $site;
    }
}
