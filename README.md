# E-Ticaret Projesi

Modern ve tam fonksiyonel bir e-ticaret web uygulaması. Laravel 11 ve Tailwind CSS ile geliştirilmiştir.

## 🚀 Özellikler

### Müşteri Tarafı
- ✅ Ürün listeleme ve arama
- ✅ Kategoriye göre filtreleme
- ✅ Ürün detay sayfaları
- ✅ Alışveriş sepeti
- ✅ Sipariş oluşturma
- ✅ Ödeme sistemi (mockup)
- ✅ Sipariş takibi
- ✅ Kullanıcı profil yönetimi

### Admin Paneli
- ✅ Dashboard (istatistikler)
- ✅ Ürün yönetimi (CRUD)
- ✅ Sipariş yönetimi
- ✅ Sipariş durumu güncelleme
- ✅ Ödeme durumu güncelleme
- ✅ Stok takibi

### Teknik Özellikler
- ✅ Laravel 11
- ✅ Laravel Breeze (Authentication)
- ✅ Middleware (IsAdmin, CheckStock)
- ✅ Policy (ProductPolicy, OrderPolicy)
- ✅ Event & Listener (OrderPlaced)
- ✅ Tailwind CSS
- ✅ Responsive tasarım

## 📋 Gereksinimler

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL veya MariaDB

## 🔧 Kurulum

### 1. Projeyi Klonlayın

```bash
git clone https://github.com/kullanici-adiniz/eticaret.git
cd eticaret
```

### 2. Bağımlılıkları Yükleyin

```bash
composer install
npm install
```

### 3. Environment Dosyasını Oluşturun

```bash
cp .env.example .env
```

### 4. Uygulama Anahtarı Oluşturun

```bash
php artisan key:generate
```

### 5. Veritabanı Ayarları

`.env` dosyasını düzenleyin:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eticaret_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Veritabanını Oluşturun

MySQL'e giriş yapın ve veritabanını oluşturun:

```sql
CREATE DATABASE eticaret_db;
```

### 7. Migration ve Seed İşlemleri

```bash
php artisan migrate
php artisan db:seed
```

### 8. Asset'leri Derleyin

İki ayrı terminal açın:

**Terminal 1:**
```bash
npm run dev
```

**Terminal 2:**
```bash
php artisan serve
```

### 9. Tarayıcıda Açın

```
http://localhost:8000
```

## 👤 Demo Kullanıcı

Seeder çalıştırıldıktan sonra aşağıdaki kullanıcıları kullanabilirsiniz:

**Admin:**
- Email: `admin@example.com`
- Şifre: `password`

**NOT:** İlk kullanıcıyı kayıt olduktan sonra admin yapmak için:

```bash
php artisan tinker
```

```php
$user = User::first();
$user->role = 'admin';
$user->save();
exit
```

## 📁 Proje Yapısı

```
eticaret/
├── app/
│   ├── Events/           # Event sınıfları
│   ├── Http/
│   │   ├── Controllers/  # Controller'lar
│   │   ├── Middleware/   # Custom middleware'ler
│   ├── Listeners/        # Event listener'ları
│   ├── Models/           # Eloquent modeller
│   └── Policies/         # Authorization policy'leri
├── database/
│   ├── migrations/       # Veritabanı migration'ları
│   └── seeders/          # Seed dosyaları
├── resources/
│   └── views/            # Blade template'leri
│       ├── admin/        # Admin panel view'ları
│       ├── products/     # Ürün sayfaları
│       ├── orders/       # Sipariş sayfaları
│       └── cart/         # Sepet sayfaları
└── routes/
    └── web.php           # Web route'ları
```

## 🎨 Ekran Görüntüleri

### Anasayfa
Modern ve kullanıcı dostu arayüz

### Ürün Listesi
Kategoriye göre filtreleme ve arama

### Admin Paneli
Sidebar menü ile kolay navigasyon

### Sipariş Takibi
Timeline ile sipariş durumu görüntüleme

## 🔐 Güvenlik

- Middleware ile yetki kontrolü
- Policy ile kaynak bazlı yetkilendirme
- CSRF koruması
- SQL Injection koruması (Eloquent ORM)
- XSS koruması

## 🛠️ Teknolojiler

- **Backend:** Laravel 11
- **Frontend:** Blade Templates, Tailwind CSS
- **Veritabanı:** MySQL
- **Authentication:** Laravel Breeze
- **Build Tool:** Vite

## 📝 Önemli Notlar

- Ödeme sistemi mockup'tır, gerçek ödeme entegrasyonu yoktur
- Resimler placeholder servislerden çekilmektedir
- Email bildirimleri log'a yazılmaktadır

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit edin (`git commit -m 'Add some amazing feature'`)
4. Push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 👨‍💻 Geliştirici

**Emir** - [GitHub](https://github.com/brokendevops)

## 🙏 Teşekkürler

Bu projeyi geliştirirken kullanılan açık kaynak projelerine teşekkürler:
- Laravel Framework
- Tailwind CSS
- Laravel Breeze

---

⭐ Projeyi beğendiyseniz yıldız vermeyi unutmayın!
