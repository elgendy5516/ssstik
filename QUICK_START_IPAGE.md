# دليل البدء السريع - iPage Shared Hosting

## الملفات المعدلة للنشر

تم إنشاء الملفات التالية لتسهيل النشر على iPage:

### 1. ملفات التكوين الأساسية
- **`.env.ipage`** - إعدادات البيئة المخصصة لـ iPage (عدّله وأعد تسميته إلى `.env`)
- **`index.php`** - ملف الدخول المعدل (ضعه في `public_html/`)
- **`.htaccess`** - إعدادات Apache المحسّنة (ضعه في `public_html/`)
- **`.htaccess.root`** - حماية مجلد التطبيق (ضعه في جذر Laravel كـ `.htaccess`)

### 2. ملفات اختيارية
- **`php.ini.example`** - تكوين PHP مخصص (أعد تسميته إلى `php.ini` إذا لزم الأمر)

### 3. الوثائق
- **`INSTALLATION_GUIDE_IPAGE.md`** - دليل التثبيت الشامل
- **`DEPLOYMENT_CHECKLIST.md`** - قائمة التحقق من النشر

### 4. ميزات إضافية
- **`MaintenanceController.php`** - واجهة ويب لإدارة الصيانة (بديل لـ Artisan)
- تم تحديث `routes/web.php` لإضافة مسارات الصيانة

## الهيكل النهائي على iPage

```
/home/username/
│
├── laravel-app/                    (مجلد التطبيق الرئيسي - خارج public_html)
│   ├── .htaccess                   (من .htaccess.root - للحماية)
│   ├── .env                        (من .env.ipage - معدل)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── storage/                    (صلاحيات 755/775)
│   ├── themes/
│   ├── vendor/
│   └── artisan
│
└── public_html/                    (مجلد الويب الرئيسي)
    ├── index.php                   (الملف الجديد)
    ├── .htaccess                   (الملف الجديد)
    ├── robots.txt
    ├── favicon.png
    └── cover.jpg
```

## خطوات التثبيت السريعة (5 دقائق)

### الخطوة 1: تحضير الملفات (محلياً)
```bash
# تثبيت Dependencies
composer install --no-dev --optimize-autoloader

# نسخ ملف البيئة وتعديله
cp .env.ipage .env
# عدّل قيم DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL
```

### الخطوة 2: إنشاء قاعدة البيانات (iPage)
1. سجل دخول إلى cPanel
2. MySQL Databases → Create New Database
3. أنشئ مستخدم وأضفه إلى القاعدة
4. احفظ: اسم القاعدة، المستخدم، كلمة المرور

### الخطوة 3: رفع الملفات (FTP/cPanel)

**مجلد التطبيق الرئيسي:**
```
ارفع إلى: /home/username/laravel-app/
الملفات: app/, bootstrap/, config/, database/, routes/,
         storage/, themes/, vendor/, .env, artisan
```

**مجلد الويب:**
```
ارفع إلى: /home/username/public_html/
الملفات: index.php (الجديد), .htaccess (الجديد),
         robots.txt, favicon.png, cover.jpg
```

### الخطوة 4: ضبط الصلاحيات
```bash
chmod -R 755 laravel-app/storage
chmod -R 755 laravel-app/bootstrap/cache
```

### الخطوة 5: إعداد قاعدة البيانات

**عبر SSH (إذا متاح):**
```bash
cd laravel-app
php artisan migrate --force
php artisan make:user
```

**بدون SSH:**
1. شغل `php artisan migrate` محلياً
2. صدّر القاعدة (Export SQL)
3. استوردها عبر phpMyAdmin في iPage

### الخطوة 6: الوصول إلى الموقع
- الصفحة الرئيسية: `https://yourdomain.com`
- لوحة الإدارة: `https://yourdomain.com/admin/login`
- أدوات الصيانة: `https://yourdomain.com/admin/maintenance`

## التعديلات الرئيسية

### 1. `bootstrap/app.php`
تم تفعيل مسار `public_html` المخصص:
```php
$app->bind('path.public', function() {
    return base_path('../public_html');
});
```

### 2. `index.php`
تم تحديث المسارات للعمل مع هيكل iPage:
```php
const BASE_APP_PATH = __DIR__ . '/..';
```

### 3. `.env.ipage`
إعدادات محسّنة لـ Production:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `LOG_LEVEL=error`
- `DB_HOST=localhost`

## الميزات الجديدة

### واجهة الصيانة (بدون SSH)
يمكنك الآن إدارة التطبيق من المتصفح:
- مسح الكاش
- تحسين الأداء
- مسح اللوجات
- مراقبة المساحة المستخدمة

الوصول: `https://yourdomain.com/admin/maintenance`

## حل المشكلات السريع

| المشكلة | الحل السريع |
|---------|-------------|
| خطأ 500 | تحقق من صلاحيات `storage/` و `bootstrap/cache/` |
| صفحة بيضاء | تأكد من وجود `vendor/` وصحة `.env` |
| 404 على الصفحات | تحقق من `.htaccess` في `public_html/` |
| قاعدة بيانات لا تتصل | راجع معلومات `DB_*` في `.env` |
| الصور لا تظهر | تأكد من `APP_URL` في `.env` |

## الدعم والموارد

- **دليل التثبيت الكامل:** `INSTALLATION_GUIDE_IPAGE.md`
- **قائمة التحقق:** `DEPLOYMENT_CHECKLIST.md`
- **التوثيق الرسمي:** https://tiktok.docs.codespikex.com

## ملاحظات مهمة

⚠️ **الأمان:**
- تأكد من `APP_DEBUG=false` في الإنتاج
- غيّر `APP_KEY` قبل النشر
- احمِ ملف `.env` من الوصول المباشر

✅ **الأداء:**
- استخدم واجهة الصيانة لتحسين الكاش
- فعّل HTTPS من لوحة تحكم iPage
- راقب استهلاك الموارد بانتظام

🔧 **الصيانة:**
- نسخ احتياطي أسبوعي لقاعدة البيانات
- مراجعة اللوجات في `storage/logs/`
- تحديث Dependencies بانتظام

---

**جاهز للنشر!** 🚀

اتبع الخطوات أعلاه وستكون لديك موقع TikTok Downloader يعمل على iPage في دقائق.
