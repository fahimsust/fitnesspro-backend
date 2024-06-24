<?php

namespace Domain\Products\Models\Product\Specialties;

use Domain\Accounts\Models\Specialty;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class ProductSpecialty extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'products_specialties';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id', 'id');
    }
}
