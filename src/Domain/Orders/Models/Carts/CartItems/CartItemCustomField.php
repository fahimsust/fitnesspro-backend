<?php

namespace Domain\Orders\Models\Carts\CartItems;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class CartItemCustomField extends Model
{
    use HasModelUtilities,
        HasFactory;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'cart_item_customfields';

    protected $casts = [
        'item_id' => 'int',
        'form_id' => 'int',
        'section_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'value',
    ];

    public function field()
    {
        return $this->belongsTo(CustomField::class);
    }

    public function item()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function form()
    {
        return $this->belongsTo(CustomForm::class);
    }

    public function section()
    {
        return $this->belongsTo(FormSection::class);
    }
}
