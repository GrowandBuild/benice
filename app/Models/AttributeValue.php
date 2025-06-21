<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attributeValue) {
            $attributeValue->slug = Str::slug($attributeValue->value);
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_values');
    }
}
