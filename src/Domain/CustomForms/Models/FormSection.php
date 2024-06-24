<?php

namespace Domain\CustomForms\Models;

use Domain\Accounts\Models\AccountField;
use Domain\CustomForms\QueryBuilders\FormSectionQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class FormSection extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'custom_forms_sections';

    protected $casts = [
        'form_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'form_id',
        'title',
        'rank',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }

    public function accountSections()
    {
        return $this->hasMany(AccountField::class, 'section_id');
    }

    public function fields()
    {
        return $this->belongsToMany(
            CustomField::class,
            FormSectionField::class,
            'section_id',
            'field_id'
        )->withPivot('rank','required','new_row','id');
    }
    public function newEloquentBuilder($query)
    {
        return new FormSectionQuery($query);
    }
    public function translations()
    {
        return $this->hasMany(
            FormSectionTranslation::class,
            'section_id'
        );
    }

//    public function orders_products_customfields()
//    {
//        return $this->hasMany(OrderProductCustomField::class, 'section_id');
//    }
//
//    public function saved_cart_items_customfields()
//    {
//        return $this->hasMany(SavedCartItemsCustomfield::class, 'section_id');
//    }
//
//    public function wishlists_items_customfields()
//    {
//        return $this->hasMany(WishlistsItemsCustomfield::class, 'section_id');
//    }
}
