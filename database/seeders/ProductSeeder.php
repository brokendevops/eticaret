<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Elektronik
            [
                'category_id' => 1,
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Apple iPhone 15 Pro 256GB, Titanyum çerçeve, A17 Pro chip',
                'price' => 54999.00,
                'sale_price' => 49999.00,
                'stock' => 25,
                'sku' => 'IP15PRO-256',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'description' => 'Samsung Galaxy S24 Ultra 512GB, S Pen dahil',
                'price' => 49999.00,
                'sale_price' => null,
                'stock' => 30,
                'sku' => 'SGS24U-512',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'category_id' => 1,
                'name' => 'MacBook Air M3',
                'slug' => 'macbook-air-m3',
                'description' => 'Apple MacBook Air 13" M3 chip, 16GB RAM, 512GB SSD',
                'price' => 42999.00,
                'sale_price' => 39999.00,
                'stock' => 20,
                'sku' => 'MBA-M3-512',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'description' => 'Sony kablosuz gürültü önleyici kulaklık',
                'price' => 8999.00,
                'sale_price' => 7499.00,
                'stock' => 50,
                'sku' => 'SONY-WH1000XM5',
                'is_featured' => false,
                'is_active' => true
            ],
            
            // Giyim
            [
                'category_id' => 2,
                'name' => 'Levi\'s 501 Kot Pantolon',
                'slug' => 'levis-501-kot-pantolon',
                'description' => 'Klasik kesim, orijinal kot pantolon',
                'price' => 1299.00,
                'sale_price' => 999.00,
                'stock' => 100,
                'sku' => 'LEV-501-BLU',
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'category_id' => 2,
                'name' => 'Nike Air Max 90',
                'slug' => 'nike-air-max-90',
                'description' => 'Nike spor ayakkabı, beyaz/siyah',
                'price' => 3999.00,
                'sale_price' => 3499.00,
                'stock' => 75,
                'sku' => 'NIKE-AM90-WB',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'category_id' => 2,
                'name' => 'Adidas Hoodie',
                'slug' => 'adidas-hoodie',
                'description' => 'Adidas kapüşonlu sweatshirt, siyah',
                'price' => 899.00,
                'sale_price' => null,
                'stock' => 120,
                'sku' => 'ADI-HOOD-BLK',
                'is_featured' => false,
                'is_active' => true
            ],
            
            // Ev & Yaşam
            [
                'category_id' => 3,
                'name' => 'Dyson V15 Detect',
                'slug' => 'dyson-v15-detect',
                'description' => 'Kablosuz elektrikli süpürge, lazer teknolojisi',
                'price' => 19999.00,
                'sale_price' => 17999.00,
                'stock' => 20,
                'sku' => 'DYS-V15',
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'category_id' => 3,
                'name' => 'Nespresso Kahve Makinesi',
                'slug' => 'nespresso-kahve-makinesi',
                'description' => 'Nespresso kapsüllü kahve makinesi',
                'price' => 4999.00,
                'sale_price' => null,
                'stock' => 35,
                'sku' => 'NESP-MACH',
                'is_featured' => false,
                'is_active' => true
            ],
            
            // Spor & Outdoor
            [
                'category_id' => 4,
                'name' => 'Yoga Mat Premium',
                'slug' => 'yoga-mat-premium',
                'description' => 'Kaymaz yoga matı, 6mm kalınlık',
                'price' => 399.00,
                'sale_price' => 299.00,
                'stock' => 8,
                'sku' => 'YOGA-MAT-6MM',
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'category_id' => 4,
                'name' => 'Dambıl Seti 20kg',
                'slug' => 'dambil-seti-20kg',
                'description' => 'Ayarlanabilir dambıl seti',
                'price' => 1299.00,
                'sale_price' => null,
                'stock' => 45,
                'sku' => 'DUMB-20KG',
                'is_featured' => false,
                'is_active' => true
            ],
            
            // Kitap & Hobi
            [
                'category_id' => 5,
                'name' => 'Suç ve Ceza - Dostoyevski',
                'slug' => 'suc-ve-ceza',
                'description' => 'Türkçe çeviri, ciltli baskı',
                'price' => 89.00,
                'sale_price' => 69.00,
                'stock' => 150,
                'sku' => 'BOOK-SVC',
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'category_id' => 5,
                'name' => 'Monopoly Klasik',
                'slug' => 'monopoly-klasik',
                'description' => 'Klasik Monopoly masa oyunu',
                'price' => 449.00,
                'sale_price' => null,
                'stock' => 60,
                'sku' => 'MONO-CLAS',
                'is_featured' => false,
                'is_active' => true
            ],
            
            // Kozmetik
            [
                'category_id' => 6,
                'name' => 'La Roche-Posay Güneş Kremi',
                'slug' => 'laroche-posay-gunes-kremi',
                'description' => 'SPF 50+ güneş koruyucu krem',
                'price' => 399.00,
                'sale_price' => 349.00,
                'stock' => 80,
                'sku' => 'LRP-SPF50',
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'category_id' => 6,
                'name' => 'Nivea Yüz Kremi',
                'slug' => 'nivea-yuz-kremi',
                'description' => 'Nemlendirici yüz kremi, tüm cilt tipleri',
                'price' => 129.00,
                'sale_price' => null,
                'stock' => 200,
                'sku' => 'NIV-FACE',
                'is_featured' => false,
                'is_active' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}