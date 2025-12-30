<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Telefon, bilgisayar, tablet ve elektronik aksesuarlar',
                'is_active' => true
            ],
            [
                'name' => 'Giyim',
                'slug' => 'giyim',
                'description' => 'Erkek, kadın ve çocuk giyim ürünleri',
                'is_active' => true
            ],
            [
                'name' => 'Ev & Yaşam',
                'slug' => 'ev-yasam',
                'description' => 'Ev dekorasyonu, mobilya ve yaşam ürünleri',
                'is_active' => true
            ],
            [
                'name' => 'Spor & Outdoor',
                'slug' => 'spor-outdoor',
                'description' => 'Spor ekipmanları ve outdoor ürünleri',
                'is_active' => true
            ],
            [
                'name' => 'Kitap & Hobi',
                'slug' => 'kitap-hobi',
                'description' => 'Kitaplar, oyunlar ve hobi malzemeleri',
                'is_active' => true
            ],
            [
                'name' => 'Kozmetik',
                'slug' => 'kozmetik',
                'description' => 'Kozmetik ve kişisel bakım ürünleri',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}