<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class Product extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'stock',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->variants()->exists() && $variantWithImage = $this->variants()->whereNotNull('image')->first()) {
            return Storage::url($variantWithImage->image);
        }

        return 'https://via.placeholder.com/400x400';
    }
}
