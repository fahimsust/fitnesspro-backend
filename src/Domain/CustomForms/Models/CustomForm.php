<?php

namespace Domain\CustomForms\Models;

use Domain\Accounts\Models\AccountField;
use Domain\Accounts\Models\AccountType;
use Domain\CustomForms\QueryBuilders\CustomFormQuery;
use Domain\Orders\Models\Order\OrderCustomForm;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class CustomForm extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'custom_forms';

    protected $casts = [
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'status',
    ];

    public function newEloquentBuilder($query)
    {
        return new CustomFormQuery($query);
    }

    public function accountForms()
    {
        return $this->hasMany(AccountField::class, 'form_id');
    }

    public function accountTypes()
    {
        return $this->hasMany(AccountType::class);
    }

    public function sections()
    {
        return $this->hasMany(FormSection::class, 'form_id');
    }

    public function custom_forms_show()
    {
        return $this->hasOne(FormShow::class, 'form_id');
    }

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            ProductForm::class
        )
//        return $this->belongsToMany(
//            Product::class,
//            'custom_forms_show_products',
//            'form_id'
//        )
            ->withPivot('rank');
    }

    public function productTypes()
    {
        return $this->hasOne(ProductFormType::class, 'form_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderCustomForm::class, 'form_id');
    }
    public function translations()
    {
        return $this->hasMany(
            CustomFormTranslation::class,'form_id'
        );
    }

//    public function orders_products_customfields()
//    {
//        return $this->hasMany(OrderProductCustomField::class, 'form_id');
//    }
//
//    public function saved_cart_items_customfields()
//    {
//        return $this->hasMany(SavedCartItemsCustomfield::class, 'form_id');
//    }
//
//    public function wishlists_items_customfields()
//    {
//        return $this->hasMany(WishlistsItemsCustomfield::class, 'form_id');
//    }
}
