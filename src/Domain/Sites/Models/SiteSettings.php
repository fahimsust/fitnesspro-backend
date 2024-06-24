<?php

namespace Domain\Sites\Models;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

/**
 * Class SitesSetting
 *
 * @property Layout $display_layout
 * @property ModuleTemplate $modules_template
 * @property SearchForm $search_form
 *
 * @package Domain\Sites\Models
 */
class SiteSettings extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;

    protected $table = 'sites_settings';

    protected $primaryKey = 'site_id';

    protected $casts = [
        'site_id' => 'int',
        'default_layout_id' => 'int',
        'default_category_thumbnail_template' => 'int',
        'default_product_thumbnail_template' => 'int',
        'default_product_detail_template' => 'int',
        'default_product_zoom_template' => 'int',
        'default_feature_thumbnail_template' => 'int',
        'default_feature_count' => 'int',
        'default_product_thumbnail_count' => 'int',
        'default_show_categories_in_body' => 'bool',
        'search_layout_id' => 'int',
        'search_thumbnail_template' => 'int',
        'search_thumbnail_count' => 'int',
        'home_feature_count' => 'int',
        'home_feature_thumbnail_template' => 'int',
        'home_feature_show' => 'bool',
        'home_feature_showsort' => 'bool',
        'home_feature_showmessage' => 'bool',
        'home_show_categories_in_body' => 'bool',
        'home_layout_id' => 'int',
        'default_product_related_count' => 'int',
        'default_product_brands_count' => 'int',
        'default_feature_showsort' => 'bool',
        'default_product_thumbnail_showsort' => 'bool',
        'default_product_thumbnail_showmessage' => 'bool',
        'default_feature_showmessage' => 'bool',
        'default_product_related_template' => 'int',
        'default_product_brands_template' => 'int',
        'default_category_layout_id' => 'int',
        'default_product_layout_id' => 'int',
        'account_layout_id' => 'int',
        'cart_layout_id' => 'int',
        'checkout_layout_id' => 'int',
        'page_layout_id' => 'int',
        'affiliate_layout_id' => 'int',
        'wishlist_layout_id' => 'int',
        'default_module_template_id' => 'int',
        'default_category_module_template_id' => 'int',
        'default_product_module_template_id' => 'int',
        'home_module_template_id' => 'int',
        'account_module_template_id' => 'int',
        'search_module_template_id' => 'int',
        'cart_module_template_id' => 'int',
        'checkout_module_template_id' => 'int',
        'page_module_template_id' => 'int',
        'affiliate_module_template_id' => 'int',
        'wishlist_module_template_id' => 'int',
        'catalog_layout_id' => 'int',
        'catalog_module_template_id' => 'int',
        'catalog_show_products' => 'bool',
        'catalog_feature_show' => 'bool',
        'catalog_show_categories_in_body' => 'bool',
        'catalog_feature_count' => 'int',
        'catalog_feature_thumbnail_template' => 'int',
        'catalog_feature_showsort' => 'bool',
        'catalog_feature_showmessage' => 'bool',
        'cart_addtoaction' => 'int',
        'cart_orderonlyavailableqty' => 'bool',
        'checkout_process' => 'bool',
        'offline_layout_id' => 'int',
        'filter_categories' => 'int',
        'default_category_search_form_id' => 'int',
        'cart_allowavailability' => AsArrayObject::class,
    ];

//    protected $attributes = [
//        'cart_allowavailability' => '{}'
//    ];

    protected $hidden = [
        'recaptcha_secret',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'wishlist_layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'wishlist_module_template_id');
    }

    public function searchForm()
    {
        return $this->belongsTo(SearchForm::class, 'default_category_search_form_id');
    }

    public function allowedToOrderAvailabilities(): ?array
    {
        return $this->cart_allowavailability?->toArray();
    }

    public function limitOrderQtyToAvailableQty(): bool
    {
        return $this->cart_orderonlyavailableqty;
    }
}
