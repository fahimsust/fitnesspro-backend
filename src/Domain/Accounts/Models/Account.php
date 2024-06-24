<?php

namespace Domain\Accounts\Models;

use App\Api\Accounts\Requests\UpdateAccountCellphoneRequest;
use Domain\Accounts\Exceptions\AccountLoginException;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\QueryBuilders\AccountQuery;
use Domain\Addresses\Models\Address;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Affiliates\Models\Affiliate;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\Orders\Models\Order\Order;
use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;
use Domain\Sites\Models\Site;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Support\Contracts\Mail\CanMailFrom;
use Support\Contracts\Mail\CanMailTo;
use Support\Traits\ClearsCache;
use Support\Traits\HasModelUtilities;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use function __;
use function config;

class Account extends Authenticatable implements CanMailFrom, CanMailTo
{
    use HasFactory,
        HasApiTokens,
        Notifiable,
        HasModelUtilities,
        HasRelationships,
        ClearsCache;

    public $field_values = [];

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
        'admin_notes', //use user
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d h:i:s',
        'lastlogin_at' => 'date:Y-m-d h:i:s',
        'last_verify_attempt_date' => 'date:Y-m-d',
        'membership_status' => 'boolean',
        'profile_public' => 'boolean',
    ];

    protected $appends = [
        'user',
        'fullname',
    ]; //used by HandleMessageKeys

    public function newEloquentBuilder($query)
    {
        return new AccountQuery($query);
    }

    protected function cacheTags(): array
    {
        return [
            'account-cache.' . $this->id,
        ];
    }

    public function setLastLogin(): static
    {
        $this->update(['lastlogin_at' => now()]);

        return $this;
    }

    public static function FindByEmail($email): Account
    {
        return self::whereEmail($email)->firstOrFail();
    }

    public static function FindByUsernameAndEmail($email, $user): Account
    {
        return self::whereEmail($email)->whereUsername($user)->first();
    }

    public static function dir()
    {
        return 'account/';
    }

    public static function url()
    {
        return Site::url(self::dir());
    }

    public function getLastLoginAttribute()
    {
        return $this->lastlogin_at;
    }

    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmailAttribute()
    {
        return $this->attributes['email'];
    }

    public function getPhoneAttribute()
    {
        return $this->attributes['phone'];
    }

    public function getUserAttribute()
    {
        return $this->attributes['username'];
    }

    public function getTypeIdAttribute()
    {
        return $this->attributes['type_id'];
    }

    public function getStatusIdAttribute()
    {
        return $this->attributes['status_id'];
    }

    public function getPasswordAttribute()
    {
        return $this->attributes['password'];
    }

    public function isActiveOrThrow()
    {
        if ($this->status_id !== 1) {
            throw new AccountLoginException(__('Account is not active'));
        }

        return $this;
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    public function album()
    {
        return $this->hasOne(PhotoAlbum::class, 'type_id', 'id')
            ->where('type', '=', 1);
    }

    public function profilePhoto()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function hasActiveMembership()
    {
        return (bool)$this->activeMembership()->get()->count();
    }

    public function activeMembership()
    {
        return $this->hasOne(
            Subscription::class,
            'account_id',
            'id'
        )
            ->with(['level', 'product'])
            ->whereNull('cancelled')
            ->where('start_date', '<=', now())
            ->where('end_date', '>', now())
            ->where('status', '=', 1)
            ->orderBy('id', 'DESC');
    }

    public function inactiveMemberships()
    {
        return $this->memberships()->where('status', '!=', 1);
    }
    public function latestMembership()
    {
        return $this->hasOne(Subscription::class)->latest('id');
    }

    public function memberships()
    {
        return $this->hasMany(Subscription::class, 'account_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'account_id', 'id');
    }
    public function rangeOption(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations(
            $this->orders(),
            (new Order)->rangeOption()
        );
    }

    public function accountUsedDiscounts()
    {
        return $this->hasMany(AccountUsedDiscount::class, 'account_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(AccountStatus::class, 'id', 'status_id');
    }

    public function type()
    {
        return $this->hasOne(AccountType::class, 'id', 'type_id');
    }

    public function adminEmailsSentTo()
    {
        return $this->hasMany(
            AdminEmailsSent::class,
            'account_id'
        );
    }

    public function site()
    {
        return $this->hasOne(Site::class, 'id', 'site_id');
    }

    //    public function billingAddress()
    //    {
    //        return $this->addresses()->where('is_billing',1);
    //    }
    //    public function shippingAddress()
    //    {
    //        return $this->addresses()->where('is_shipping',1);
    //    }

    public function addresses()
    {
        return $this->hasMany(
            AccountAddress::class,
            'account_id',
            'id'
        );
    }

    public function accountAddresses(): BelongsToMany
    {
        return $this->belongsToMany(
            Address::class,
            AccountAddress::class,
            'account_id',
            'address_id',
        )->withPivot('id');
    }

    public function defaultBillingAddress(): HasOneThrough
    {
        return $this->hasOneThrough(
            Address::class,
            AccountAddress::class,
            'id',
            'id',
            'default_billing_id',
            'address_id',
        );
    }

    public function billingAddresses(): BelongsToMany
    {
        return $this->accountAddresses()
            ->where('status', true)
            ->where('is_billing', true);
    }

    public function defaultShippingAddress(): HasOneThrough
    {
        return $this->hasOneThrough(
            Address::class,
            AccountAddress::class,
            'id',
            'id',
            'default_shipping_id',
            'address_id',
        );
    }

    public function shippingAddresses(): BelongsToMany
    {
        return $this->accountAddresses()
            ->where('status', true)
            ->where('is_shipping', true);
    }


    public function specialties(): HasMany
    {
        return $this->hasMany(
            AccountSpecialty::class,
            'account_id',
            'id'
        );
    }

    public function assignedSpecialties(): HasManyThrough
    {
        return $this->hasManyThrough(
            Specialty::class,
            AccountSpecialty::class,
            'account_id',
            'id',
            'id',
            'specialty_id'
        );
    }

    public function approvedSpecialties(): HasManyThrough
    {
        return $this->assignedSpecialties()
            ->where('accounts_specialties.approved', 1);
    }

    public function resetPassword(): string
    {
        $newPassword = Str::random(8);

        $this->setPasswordAttribute($newPassword);
        $this->save();

        return $newPassword;
    }

    public function updateCellphone(UpdateAccountCellphoneRequest $request)
    {
        if (is_null($this->cellphoneField()->first())) {
            return $this->cellphone = AccountField::create([
                'form_id' => CustomForm::firstOrFactory()->id,
                'section_id' => FormSection::firstOrFactory()->id,
                'account_id' => $this->id,
                'field_id' => config('account_fields.cellphone_field_id'),
                'field_value' => htmlspecialchars($request->new_cellphone),
            ]);
        }

        $this->cellphoneField()->update([
            'field_value' => htmlspecialchars($request->new_cellphone),
        ]);
    }

    public function getCellphoneAttribute()
    {
        if ($field = $this->cellphoneField) {
            return $field->value;
        }

        return false;
    }

    public function cellphoneField()
    {
        return $this->hasOne(AccountField::class, 'account_id', 'id')
            ->where('field_id', '=', config('account_fields.cellphone_field_id'));
    }

    public function updateLastLogin()
    {
        $this->update(['lastlogin_at' => Carbon::now()->toDateTimeString()]);

        return $this;
    }

    public function sendPasswordResetNotification($token)
    {
        ResetPasswordNotification::createUrlUsing(
            fn() => (config('app.frontend.account.reset_password_url')
                    ?? route('account.reset-password')) . '?token=' . $token
        );

        app(Dispatcher::class)->send($this, new ResetPasswordNotification($token));
    }


    public function linkedAffiliate(): HasOne
    {
        return $this->hasOne(Affiliate::class, 'account_id', 'id')
            ->whereStatus(true);
    }

    public function sendFrom(): string
    {
        return $this->email;
    }

    public function sendFromName(): string
    {
        return $this->first_name;
    }

    public function sendTo(): string
    {
        return $this->sendFrom();
    }

    public function sendToName(): string
    {
        return $this->sendFromName();
    }
}
