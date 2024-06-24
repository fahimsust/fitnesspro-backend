<?php

namespace Domain\Orders\Models\Order\OrderItems;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class OrderItemCustomField extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'orders_products_customfields';

    protected $casts = [
        'orders_products_id' => 'int',
        'form_id' => 'int',
        'section_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'value',
    ];

    public function item()
    {
        return $this->belongsTo(
            OrderItem::class,
            'orders_products_id'
        );
    }

    public function field()
    {
        return $this->belongsTo(CustomField::class);
    }

    public function form()
    {
        return $this->belongsTo(CustomForm::class);
    }

    public function section()
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }
}
