<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'sku',
        'images',
        'is_featured',
        'is_active'];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'];

    // Bir ürün bir kategoriye aittir
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

  // Ürün resmini al
public function getImageUrl($width = 400, $height = 300)
{
    // Eğer images alanında veri varsa
    if (!empty($this->images)) {
        $images = $this->images;
        
        if (isset($images[0]) && filter_var($images[0], FILTER_VALIDATE_URL)) {
            return $images[0];
        }
    }
    
    // LoremFlickr - kategoriye göre gerçek fotoğraflar
    $keywords = $this->category->getUnsplashKeywords();
    
    return "https://loremflickr.com/{$width}/{$height}/{$keywords}";

}
}
