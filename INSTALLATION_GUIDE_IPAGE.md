# دليل التثبيت على iPage Shared Hosting

## متطلبات التثبيت

تأكد من توفر المتطلبات التالية على حساب iPage الخاص بك:
- PHP 8.0.2 أو أحدث
- MySQL 5.7.8 أو أحدث
- Apache مع mod_rewrite
- PHP Extensions: cURL, OpenSSL, mbstring, PDO, MySQLi, GD, JSON, EXIF
- allow_url_fopen: On

## خطوات التثبيت

### 1. رفع الملفات

#### الهيكل المطلوب على iPage:
```
/home/username/
├── public_html/              (مجلد الويب الرئيسي)
│   ├── index.php            (الملف الجديد)
│   ├── .htaccess            (الملف الجديد)
│   ├── robots.txt
│   ├── favicon.png
│   ├── cover.jpg
│   └── [جميع ملفات public الأخرى]
│
└── laravel-app/             (مجلد التطبيق - خارج public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── routes/
    ├── storage/
    ├── themes/
    ├── vendor/
    ├── .env
    ├── artisan
    └── composer.json
```

#### خطوات الرفع:

1. **ارفع ملفات التطبيق الرئيسية:**
   - قم بإنشاء مجلد `laravel-app` (أو أي اسم تريده) خارج `public_html`
   - ارفع جميع الملفات والمجلدات التالية داخل `laravel-app`:
     - app/
     - bootstrap/
     - config/
     - database/
     - lang/
     - routes/
     - storage/
     - themes/
     - tests/
     - composer.json
     - composer.lock
     - artisan
     - phpunit.xml

2. **ارفع ملفات public إلى public_html:**
   - انسخ الملف الجديد `index.php` (من جذر المشروع) إلى `public_html/`
   - انسخ الملف الجديد `.htaccess` (من جذر المشروع) إلى `public_html/`
   - انسخ جميع ملفات من `public/` الأصلي إلى `public_html/`:
     - robots.txt
     - favicon.png
     - cover.jpg

3. **تعديل مسار التطبيق في index.php:**
   إذا كان اسم المجلد الذي أنشأته غير `laravel-app`، عدّل السطر التالي في `public_html/index.php`:
   ```php
   const BASE_APP_PATH = __DIR__ . '/..';
   ```
   إلى:
   ```php
   const BASE_APP_PATH = __DIR__ . '/../اسم_المجلد_الخاص_بك';
   ```

### 2. إعداد قاعدة البيانات

1. **إنشاء قاعدة بيانات MySQL:**
   - سجل الدخول إلى لوحة تحكم iPage
   - اذهب إلى MySQL Databases
   - أنشئ قاعدة بيانات جديدة
   - أنشئ مستخدم وأعطه صلاحيات كاملة على القاعدة

2. **احفظ معلومات الاتصال:**
   - اسم قاعدة البيانات
   - اسم المستخدم
   - كلمة المرور
   - المضيف (عادةً: localhost)

### 3. تثبيت Composer Dependencies

**خيار 1: عبر SSH (إذا كان متاحاً):**
```bash
cd ~/laravel-app
composer install --no-dev --optimize-autoloader
```

**خيار 2: رفع vendor يدوياً:**
- قم بتشغيل `composer install --no-dev --optimize-autoloader` على جهازك المحلي
- ارفع مجلد `vendor/` كاملاً إلى `laravel-app/`

### 4. إعداد ملف البيئة (.env)

1. انسخ `.env.ipage` إلى `.env` في مجلد `laravel-app/`
2. عدّل القيم التالية:

```env
APP_URL=https://yourdomain.com

# معلومات قاعدة البيانات من الخطوة 2
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

# إعدادات البريد الإلكتروني (اختياري)
MAIL_HOST=smtp.yourdomain.com
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_email_password
```

### 5. توليد Application Key

**عبر SSH:**
```bash
cd ~/laravel-app
php artisan key:generate
```

**بدون SSH:**
- قم بتوليد المفتاح محلياً: `php artisan key:generate`
- انسخ قيمة `APP_KEY` من ملف `.env` المحلي إلى `.env` على السيرفر

### 6. ضبط صلاحيات المجلدات

عبر SSH أو File Manager في cPanel:

```bash
chmod -R 755 ~/laravel-app/storage
chmod -R 755 ~/laravel-app/bootstrap/cache
```

إذا استمرت مشاكل الصلاحيات، جرب:
```bash
chmod -R 775 ~/laravel-app/storage
chmod -R 775 ~/laravel-app/bootstrap/cache
```

### 7. إعداد قاعدة البيانات

**عبر SSH:**
```bash
cd ~/laravel-app
php artisan migrate --force
```

**بدون SSH:**
1. صدّر قاعدة البيانات محلياً بعد تشغيل `php artisan migrate`
2. استورد ملف SQL عبر phpMyAdmin في iPage

### 8. إنشاء حساب المدير

**عبر SSH:**
```bash
php artisan make:user
```

**بدون SSH:**
- استخدم phpMyAdmin لإضافة سجل في جدول `users`
- استخدم هذا الكود لتشفير كلمة المرور: `password_hash('your_password', PASSWORD_DEFAULT)`

### 9. مسح الكاش (اختياري)

**عبر SSH:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**بدون SSH:**
- احذف جميع الملفات في `storage/framework/cache/`
- احذف جميع الملفات في `storage/framework/views/`

## التحقق من التثبيت

1. افتح موقعك في المتصفح: `https://yourdomain.com`
2. يجب أن تظهر الصفحة الرئيسية للتطبيق
3. للدخول إلى لوحة الإدارة: `https://yourdomain.com/admin`

## حل المشكلات الشائعة

### خطأ 500 - Internal Server Error

**السبب:** صلاحيات خاطئة أو مشكلة في .env

**الحل:**
1. تأكد من صلاحيات storage و bootstrap/cache
2. تحقق من صحة معلومات قاعدة البيانات في .env
3. تأكد من وجود APP_KEY في .env
4. فعّل عرض الأخطاء مؤقتاً: `APP_DEBUG=true`

### الصفحات لا تعمل (404 Not Found)

**السبب:** mod_rewrite غير مفعل أو .htaccess غير صحيح

**الحل:**
1. تأكد من رفع ملف .htaccess إلى public_html/
2. تحقق من تفعيل mod_rewrite في iPage
3. تواصل مع دعم iPage لتفعيله

### الستايلات والصور لا تظهر

**السبب:** مسارات خاطئة أو ملفات غير مرفوعة

**الحل:**
1. تأكد من رفع جميع ملفات public/ إلى public_html/
2. تحقق من إعداد APP_URL في .env
3. امسح الكاش: احذف `bootstrap/cache/config.php`

### خطأ في الاتصال بقاعدة البيانات

**السبب:** معلومات اتصال خاطئة

**الحل:**
1. تحقق من DB_HOST (يجب أن يكون localhost)
2. تأكد من صحة DB_DATABASE, DB_USERNAME, DB_PASSWORD
3. تأكد أن المستخدم له صلاحيات على القاعدة

### خطأ في كتابة الملفات (Storage errors)

**السبب:** صلاحيات غير كافية

**الحل:**
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

## القيود على iPage Shared Hosting

### ما لا يمكن عمله:
1. **أوامر Artisan التفاعلية** (بدون SSH)
   - لا يمكن تشغيل `php artisan` مباشرة
   - الحل: استخدم واجهات ويب أو نفذ العمليات محلياً

2. **Cron Jobs لـ Scheduler**
   - قد يكون محدوداً
   - الحل: استخدم cron jobs في cPanel بدلاً من `schedule:run`

3. **Queue Workers**
   - لا يمكن تشغيل queue workers مستمرة
   - الحل: استخدم `QUEUE_CONNECTION=sync`

4. **WebSockets / Broadcasting**
   - غير مدعوم في shared hosting
   - الحل: استخدم خدمات خارجية مثل Pusher

### حدود الموارد:
- **الذاكرة:** محدودة (عادةً 128-256MB)
- **وقت التنفيذ:** محدود (30-60 ثانية)
- **حجم التحميل:** محدود (عادةً 8-64MB)

## نصائح للأداء

1. **تفعيل الكاش:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **تحسين Autoloader:**
```bash
composer install --optimize-autoloader --no-dev
```

3. **استخدام CDN للأصول الثابتة**

4. **تقليل عدد الاستعلامات:**
   - استخدم Eager Loading
   - فعّل Query Caching

5. **تحسين الصور:**
   - اضغط الصور قبل رفعها
   - استخدم صيغ WebP

## الدعم والمساعدة

إذا واجهت مشاكل:
1. راجع logs في `storage/logs/laravel.log`
2. تواصل مع دعم iPage للمشاكل المتعلقة بالسيرفر
3. راجع التوثيق الرسمي: https://tiktok.docs.codespikex.com

## ملاحظات أمنية

1. **احمِ ملف .env:**
   - تأكد أن .htaccess يمنع الوصول إليه
   - لا تشارك معلومات .env مع أحد

2. **فعّل HTTPS:**
   - استخدم SSL Certificate المجاني من iPage
   - أجبر استخدام HTTPS في .htaccess

3. **حدّث التطبيق بانتظام:**
   - راقب التحديثات الأمنية
   - نفذ composer update بانتظام

4. **عطّل APP_DEBUG في الإنتاج:**
   - تأكد أن `APP_DEBUG=false`
   - استخدم `LOG_LEVEL=error`

---

**مبروك! تم تثبيت التطبيق بنجاح على iPage Shared Hosting** 🎉
