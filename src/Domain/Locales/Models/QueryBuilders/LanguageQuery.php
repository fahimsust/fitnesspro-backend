<?php

namespace Domain\Locales\Models\QueryBuilders;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LanguageQuery extends Builder
{
    public function search(Request $request): static
    {
        if ($request->filled('site_id')) {
            $language_ids = Site::find($request->site_id)->siteLanguages->pluck('language_id')->toArray();
            if($language_ids)
                $this->whereNotIn('id',$language_ids);
        }
        return $this;

    }
}
