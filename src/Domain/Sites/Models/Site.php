<?php

namespace Domain\Sites\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Content\Models\Menus\Menu;
use Domain\Content\Models\Menus\MenusSites;
use Domain\Content\Models\Pages\Page;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Inventory\InventoryGateway;
use Domain\Distributors\Models\Inventory\InventoryGatewaySite;
use Domain\Locales\Models\Currency;
use Domain\Locales\Models\Language;
use Domain\Messaging\Models\AutomatedEmails\AutoEmail;
use Domain\Modules\Models\Module;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\SavedOrder;
use Domain\Orders\Models\Order\Order;
use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRuleAction;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductPricingTemp;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Domain\Sites\Actions\SendMailFromSite;
use Domain\Sites\Enums\RequireLogin;
use Domain\Sites\Models\QueryBuilders\SiteQuery;
use Domain\Tax\Models\TaxRule;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;
use Support\Mail\AbstractMailable;
use Support\Traits\HasModelUtilities;

class Site extends Model implements CanMailTo, CanMailFrom
{
    use HasFactory,
        HasModelUtilities;

    protected $guarded = ['id'];

    protected $casts = [
        'require_login' => RequireLogin::class,
        'status' => 'bool',
        'required_account_types' => 'array',
    ];

    public function newEloquentBuilder($query)
    {
        return new SiteQuery($query);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Site $site) {
            $site->clearCaches();
        });

        static::updated(function (Site $site) {
            $site->clearCaches();
        });
    }

    public function clearCaches()
    {
        Cache::forget(
            'load-site-by-id.' . $this->id,
        );
    }

    public function settings(): HasOne
    {
        return $this->hasOne(
            SiteSettings::class,
        );
    }

    public function messageTemplate(): HasOne
    {
        return $this->hasOne(
            SiteMessageTemplate::class,
        );
    }

    public static function Init()
    {
        return app(Site::class);
    }

    public static function SendMailable(Mailable $mailable)
    {
        static::Init()->_sendMailable($mailable);
    }

    public function _sendMailable(AbstractMailable $mailable)
    {
        $mailable->setSite($this);

        SendMailFromSite::SendWithMailable(
            $this,
            $mailable
        );
    }

    public static function url($append = '')
    {
        return Site::Init()->url . $append;
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function subscriptionPaymentOptions()
    {
        return $this->hasMany(
            SubscriptionPaymentOption::class
        );
    }

    public function autoEmails()
    {
        return $this->hasMany(
            AutoEmail::class,
            'automated_emails_sites'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            SiteCategory::class,
            'site_id',
            'category_id'
        );
    }

    public function categorySettings()
    {
        return $this->hasMany(
            CategorySiteSettings::class
        );
    }

    public function modules()
    {
        //todo
        return $this->hasManyThrough(
            Module::class,
            SiteSettingsModuleValue::class,
        )
            ->withPivot('id', 'section', 'section_id', 'field_id', 'custom_value');
    }

    public function discountConditions()
    {
        //todo
        return $this->hasManyThrough(
            DiscountCondition::class,
            ConditionSite::class,
            'site_id',
            'condition_id'
        );
    }

    public function inventoryGateways()
    {
        //todo
        return $this->hasManyThrough(
            InventoryGateway::class,
            InventoryGatewaySite::class
        );
    }

    public function menus()
    {
        //todo
        return $this->hasManyThrough(
            Menu::class,
            MenusSites::class,
        )
            ->withPivot('rank');
    }

    //    public function mods_account_certifications_files()
    //    {
    //        return $this->hasMany(CertificationFile::class);
    //    }
    //
    //    public function mods_account_files()
    //    {
    //        return $this->hasMany(AccountFile::class);
    //    }

    public function datesAutoOrderRuleActions()
    {
        return $this->hasMany(
            DatesAutoOrderRuleAction::class,
            'criteria_siteid'
        );
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function pages()
    {
        //todo
        return $this->hasManyThrough(
            Page::class,
            ProductSiteSettingsModuleValue::class,
        )
            ->withPivot('id', 'section_id', 'module_id', 'field_id', 'custom_value');
    }

    public function pricing()
    {
        return $this->hasMany(ProductPricing::class);
    }

    public function pricingTemp()
    {
        return $this->hasMany(ProductPricingTemp::class);
    }

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            ProductSiteSettingsModuleValue::class,
        )
            ->withPivot('id', 'section_id', 'module_id', 'field_id', 'custom_value');
    }

    public function productSiteSettings()
    {
        return $this->hasMany(ProductSiteSettings::class);
    }

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function savedOrders()
    {
        return $this->hasMany(SavedOrder::class);
    }

    public function siteCategories()
    {
        return $this->hasMany(SiteCategory::class);
    }

    public function siteCurrencies()
    {
        return $this->hasMany(SiteCurrency::class);
    }
    public function currencies()
    {
        return $this->belongsToMany(
            Currency::class,
            SiteCurrency::class,
            'site_id',
            'currency_id'
        )->withPivot('rank')
            ->orderByPivot('rank');
    }

    public function inventoryRules()
    {
        return $this->belongsToMany(
            InventoryRule::class,
            SiteInventoryRule::class,
            'site_id',
            'rule_id'
        );
    }

    public function siteInventoryRules()
    {
        return $this->hasMany(
            SiteInventoryRule::class,
        );
    }

    public function siteLanguages()
    {
        return $this->hasMany(
            SiteLanguage::class,
        );
    }

    public function languages()
    {
        return $this->belongsToMany(
            Language::class,
            SiteLanguage::class,
            'site_id',
            'language_id'
        )->withPivot('rank')
            ->orderByPivot('rank');
    }

    public function packingSlip()
    {
        return $this->hasOne(SitePackingSlip::class);
    }

    public function subscriptionPaymentMethods()
    {
        return $this->hasMany(
            SubscriptionPaymentOption::class,
        );
    }

    public function checkoutPaymentMethods()
    {
        return $this->hasMany(
            SitePaymentMethod::class,
        );
    }

    public function paymentMethods()
    {
        //todo
        return $this->hasManyThrough(
            PaymentMethod::class,
            SitePaymentMethod::class,
        )
            ->withPivot('gateway_account_id', 'fee');
    }

    public function taxRules()
    {
        //todo
        return $this->hasManyThrough(
            TaxRule::class,
            SiteTaxRule::class,
        );
    }

    public function theme()
    {
        return $this->hasOne(SitesTheme::class);
    }

    public function sendTo(): string
    {
        return $this->email;
    }

    public function sendToName(): string
    {
        return $this->name;
    }

    public function sendFrom(): string
    {
        return $this->sendTo();
    }

    public function sendFromName(): string
    {
        return $this->sendToName();
    }
    public function translations()
    {
        return $this->hasMany(
            SiteTranslation::class
        );
    }
}
