<?php

namespace Domain\Products\Models\SearchForm;

use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class SearchForm
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 *
 * @property Collection|array<CategorySiteSettings> $categories_settings_sites
 * @property Collection|array<CategorySettingsTemplate> $categories_settings_templates
 * @property Collection|array<SearchFormField> $search_forms_fields
 * @property Collection|array<SearchFormSection> $search_forms_sections
 * @property Collection|array<SiteSettings> $sites_settings
 *
 * @package Domain\Products\Models\SearchForm
 */
class SearchForm extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'search_forms';

    protected $casts = [
        'status' => 'bool',
    ];

    //  public function categories_settings_sites()
    //  {
//      return $this->hasMany(CategorySettingsSite::class);
    //  }
//
    //  public function categories_settings_templates()
    //  {
//      return $this->hasMany(CategorySettingsTemplate::class);
    //  }

    public function fields()
    {
        return $this->hasMany(SearchFormField::class, 'search_id');
    }

    public function sections()
    {
        return $this->hasMany(SearchFormSection::class, 'form_id');
    }

//  public function sites_settings()
//  {
//      return $this->hasMany(SitesSetting::class, 'default_category_search_form_id');
//  }
}
