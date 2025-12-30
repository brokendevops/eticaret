<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ["name","slug","description","image","is_active"];

    protected $casts = ['is_active' =>'boolean'];
    public function products(){
        return $this->hasMany(Product::class);
    }

    // Kategoriye özel Unsplash anahtar kelimeleri
    public function getUnsplashKeywords(){
        $keywords = [
            'Elektronik' => 'electronics,technology,gadgets',
        'Giyim' => 'clothing,fashion,apparel',
        'Ev & Yaşam' => 'home,furniture,interior',
        'Spor & Outdoor' => 'sports,fitness,outdoor',
        'Kitap & Hobi' => 'books,art,hobby',
        'Kozmetik' => 'cosmetics,beauty,skincare',
        ];

        return $keywords[$this->name] ?? 'product,shopping';
    }

}
