<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'featured',
        'reference_number',
        'movement',
        'case_material',
        'dial_color',
        'bracelet',
        'power_reserve',
        'water_resistance',
        'case_diameter',
        'condition'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'featured' => 'boolean',
        'stock' => 'integer'
    ];

    // Relasi ke Category: Satu produk masuk ke satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke ProductImages (Galeri foto multi-gambar)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Scope untuk mencari produk unggulan
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Auto-generate slug ketika Product dibuat
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
