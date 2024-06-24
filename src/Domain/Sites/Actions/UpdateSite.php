<?php

namespace Domain\Sites\Actions;

use App\Api\Admin\Sites\Requests\UpdateSiteRequest;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateSite
{
    use AsObject;

    public function handle(
        Site $site,
        UpdateSiteRequest $request
    ): Site {
        $site->update(
            [
                'name' => $request->name,
                'domain' => $request->domain,
                'email' => $request->email,
                'phone' => $request->phone,
                'url' => $request->url,
                'logo_url' => $request->logo_url,
            ]
        );
        return $site;
    }
}
