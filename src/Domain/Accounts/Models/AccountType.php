<?php

namespace Domain\Accounts\Models;

use Domain\Accounts\Models\LoyaltyPoints\LoyaltyProgram;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\QueryBuilders\AccountTypeQuery;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\CustomForms\Models\CustomForm;
use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Messaging\Models\AutoEmailAccountType;
use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AccountType extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'accounts_types';

    protected $casts = [
        'default_account_status' => 'int',
        'custom_form_id' => 'int',
        'email_template_id_creation_admin' => 'int',
        'email_template_id_creation_user' => 'int',
        'email_template_id_activate_user' => 'int',
        'discount_level_id' => 'int',
        'verify_user_email' => 'bool',
        'filter_products' => 'int',
        'filter_categories' => 'int',
        'loyaltypoints_id' => 'int',
        'use_specialties' => 'bool',
        'membership_level_id' => 'int',
        'email_template_id_verify_email' => 'int',
        'affiliate_level_id' => 'int',
        'is_trial' => 'bool',
    ];

    protected $fillable = [
        'name',
        'default_account_status',
        'custom_form_id',
        'email_template_id_creation_admin',
        'email_template_id_creation_user',
        'email_template_id_activate_user',
        'discount_level_id',
        'verify_user_email',
        'filter_products',
        'filter_categories',
        'loyaltypoints_id',
        'use_specialties',
        'membership_level_id',
        'email_template_id_verify_email',
        'affiliate_level_id',
        'is_trial',
    ];

    public function newEloquentBuilder($query)
    {
        return new AccountTypeQuery($query);
    }

    public function defaultStatus()
    {
        return $this->belongsTo(
            AccountStatus::class,
            'default_account_status'
        );
    }

    public function onCreationAdminEmailTemplate()
    {
        return $this->belongsTo(
            MessageTemplate::class,
            'email_template_id_creation_admin'
        );
    }

    public function onCreationUserEmailTemplate()
    {
        return $this->belongsTo(
            MessageTemplate::class,
            'email_template_id_activate_user'
        );
    }

    public function onActivationUserEmailTemplate()
    {
        return $this->belongsTo(
            MessageTemplate::class,
            'email_template_id_creation_user'
        );
    }

    public function verifyEmailTemplate()
    {
        return $this->belongsTo(
            MessageTemplate::class,
            'email_template_id_verify_email'
        );
    }

    public function affiliateLevel()
    {
        return $this->belongsTo(AffiliateLevel::class, 'affiliate_level_id');
    }

    public function customForm()
    {
        return $this->belongsTo(CustomForm::class);
    }

    public function discountLevel()
    {
        return $this->belongsTo(DiscountLevel::class, 'discount_level_id');
    }

    public function loyaltyProgram()
    {
        return $this->belongsTo(LoyaltyProgram::class, 'loyaltypoints_id');
    }

    public function membershipLevel()
    {
        return $this->belongsTo(MembershipLevel::class, 'membership_level_id');
    }

    public function autoEmails()
    {
        return $this->hasMany(AutoEmailAccountType::class, 'account_type_id');
    }

    public function discountConditions()
    {
        return $this->hasMany(ConditionAccountType::class, 'accounttype_id');
    }
}
