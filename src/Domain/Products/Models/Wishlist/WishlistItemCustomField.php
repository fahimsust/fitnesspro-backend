<?php

namespace Domain\Products\Models\Wishlist;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class WishlistsItemsCustomfield
 *
 * @property int $id
 * @property int $wishlists_item_id
 * @property int $form_id
 * @property int $section_id
 * @property int $field_id
 * @property string $value
 *
 * @property CustomField $custom_field
 * @property CustomForm $custom_form
 * @property FormSection $custom_forms_section
 * @property WishlistItem $wishlists_item
 *
 * @package Domain\Products\Models\Wishlist
 */
class WishlistItemCustomField extends Model
{
    use HasModelUtilities;
    public $timestamps = false;
    protected $table = 'wishlists_items_customfields';

    protected $casts = [
        'wishlists_item_id' => 'int',
        'form_id' => 'int',
        'section_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'wishlists_item_id',
        'form_id',
        'section_id',
        'field_id',
        'value',
    ];

    public function field()
    {
        return $this->belongsTo(CustomField::class, 'field_id');
    }

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }

    public function formSection()
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }

    public function item()
    {
        return $this->belongsTo(WishlistItem::class);
    }
}
