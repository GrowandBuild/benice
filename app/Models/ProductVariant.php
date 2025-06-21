<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'sku',
        'stock',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_values');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        // Se a variante não tiver imagem, podemos retornar a imagem principal do produto.
        // Isso requer que o relacionamento 'product' com 'featuredImage' esteja carregado.
        return $this->product->featuredImage->image_url ?? $this->product->image_url;
    }
}
