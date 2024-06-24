<?php

namespace Domain\Sites\Actions\Offline;

use App\Api\Admin\Sites\Requests\UpdateOfflineSettingsRequest;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateOfflineSettings
{
    use AsObject;

    public function handle(
        Site $site,
        UpdateOfflineSettingsRequest $request
    ): Site {
        $site->update(['offline_message' => $request->offline_message]);
        $site->settings()->update(['offline_layout_id' => $request->offline_layout_id]);
        return $site;
    }
}
