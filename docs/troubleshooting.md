# دليل حل المشاكل - منصة تويق

## مقدمة

هذا الدليل يساعدك في حل المشاكل الشائعة التي قد تواجهها أثناء تثبيت أو تشغيل أو استخدام منصة تويق. يتضمن خطوات التشخيص والحلول العملية.

## مشاكل التثبيت

### 1. خطأ: "PHP version not supported"

**الأعراض:**
```
Fatal error: This application requires PHP 8.1 or higher
```

**الأسباب:**
- إصدار PHP قديم
- تعدد إصدارات PHP على النظام

**الحلول:**
```bash
# فحص إصدار PHP الحالي
php -v

# تحديث PHP على Ubuntu/Debian
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-common \
    php8.2-curl php8.2-gd php8.2-json php8.2-mbstring \
    php8.2-sqlite3 php8.2-xml php8.2-zip

# تحديث PHP على CentOS/RHEL
sudo yum install php82 php82-php-cli php82-php-common \
    php82-php-curl php82-php-gd php82-php-json \
    php82-php-mbstring php82-php-sqlite3

# تغيير الإصدار الافتراضي
sudo update-alternatives --set php /usr/bin/php8.2
```

### 2. خطأ: "Composer not found"

**الأعراض:**
```
bash: composer: command not found
```

**الحلول:**
```bash
# تثبيت Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# أو باستخدام package manager
# Ubuntu/Debian
sudo apt install composer

# CentOS/RHEL
sudo yum install composer

# التحقق من التثبيت
composer --version
```

### 3. خطأ: "Permission denied"

**الأعراض:**
```
Permission denied: Cannot write to database file
Permission denied: Cannot create directory uploads/
```

**الحلول:**
```bash
# إعطاء صلاحيات للمجلدات المطلوبة
sudo chown -R www-data:www-data /path/to/tewiiq
sudo chmod -R 755 /path/to/tewiiq
sudo chmod -R 777 /path/to/tewiiq/uploads
sudo chmod 666 /path/to/tewiiq/tewiiq.db

# في البيئات المشتركة
chmod -R 755 .
chmod -R 777 uploads/
chmod 666 tewiiq.db

# إنشاء مجلد uploads إذا لم يكن موجوداً
mkdir -p uploads/{avatars,covers,tweets,reels,temp}
chmod -R 777 uploads/
```

### 4. خطأ: "Required PHP extensions missing"

**الأعراض:**
```
Fatal error: Call to undefined function json_encode()
Fatal error: Class 'SQLite3' not found
```

**الحلول:**
```bash
# فحص الامتدادات المثبتة
php -m

# تثبيت الامتدادات المطلوبة - Ubuntu/Debian
sudo apt install php8.2-json php8.2-mbstring php8.2-sqlite3 \
    php8.2-curl php8.2-gd php8.2-zip php8.2-xml

# CentOS/RHEL
sudo yum install php82-php-json php82-php-mbstring \
    php82-php-sqlite3 php82-php-curl php82-php-gd

# إعادة تشغيل خادم الويب
sudo systemctl restart apache2
# أو
sudo systemctl restart nginx
```

## مشاكل قاعدة البيانات

### 1. خطأ: "Database file not found"

**الأعراض:**
```
SQLSTATE[HY000] [14] unable to open database file
```

**التشخيص:**
```bash
# فحص وجود ملف قاعدة البيانات
ls -la tewiiq.db

# فحص صلاحيات الملف
ls -la tewiiq.db
```

**الحلول:**
```bash
# إنشاء ملف قاعدة البيانات
touch tewiiq.db
chmod 666 tewiiq.db

# أو استعادة من نسخة احتياطية
cp backups/tewiiq_latest.db tewiiq.db
chmod 666 tewiiq.db

# التحقق من مسار قاعدة البيانات في .env
cat .env | grep DB_DATABASE
```

### 2. خطأ: "Database is locked"

**الأعراض:**
```
SQLSTATE[HY000] [5] database is locked
```

**الأسباب:**
- عمليات متزامنة على قاعدة البيانات
- عملية معلقة لم تنته
- ملف قاعدة البيانات تالف

**الحلول:**
```bash
# فحص العمليات المعلقة
ps aux | grep php

# قتل العمليات المعلقة
sudo pkill -f "php.*tewiiq"

# إعادة تشغيل خادم الويب
sudo systemctl restart apache2

# في الحالات الصعبة، استعادة نسخة احتياطية
cp backups/tewiiq_latest.db tewiiq.db

# تحسين قاعدة البيانات
php admin/optimize-db.php
```

### 3. خطأ: "Database corruption"

**الأعراض:**
```
SQLSTATE[HY000] [11] database disk image is malformed
```

**التشخيص:**
```bash
# فحص سلامة قاعدة البيانات
sqlite3 tewiiq.db "PRAGMA integrity_check;"
```

**الحلول:**
```bash
# استعادة من نسخة احتياطية
cp backups/tewiiq_latest.db tewiiq.db.backup
cp backups/tewiiq_latest.db tewiiq.db

# أو إصلاح قاعدة البيانات
sqlite3 tewiiq.db ".recover" | sqlite3 tewiiq_recovered.db
mv tewiiq.db tewiiq.db.corrupted
mv tewiiq_recovered.db tewiiq.db
chmod 666 tewiiq.db
```

## مشاكل الخادم

### 1. خطأ 500 - Internal Server Error

**التشخيص:**
```bash
# فحص سجلات الأخطاء
tail -f /var/log/apache2/error.log
# أو
tail -f /var/log/nginx/error.log

# تفعيل عرض الأخطاء مؤقتاً
# في ملف .env
APP_DEBUG=true
ERROR_REPORTING=true
```

**الحلول الشائعة:**
```bash
# 1. فحص صلاحيات الملفات
chmod -R 755 .
chmod 666 tewiiq.db
chmod -R 777 uploads/

# 2. فحص ملف .htaccess
cat .htaccess

# 3. تثبيت التبعيات المفقودة
composer install

# 4. فحص ملف .env
cat .env

# 5. مسح ذاكرة التخزين المؤقت
rm -rf storage/cache/*
```

### 2. خطأ 404 - Page Not Found

**الأعراض:**
- الصفحة الرئيسية تعمل لكن الصفحات الأخرى تظهر 404
- جميع الصفحات تظهر 404

**التشخيص:**
```bash
# فحص إعدادات الخادم
apache2ctl -M | grep rewrite
# يجب أن يظهر: rewrite_module

# فحص ملف .htaccess
cat .htaccess
```

**الحلول:**
```bash
# Apache - تفعيل mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Nginx - إعداد التوجيه
# في ملف إعداد الموقع
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

# فحص ملف .htaccess
cat > .htaccess << 'EOF'
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
EOF
```

### 3. بطء في الأداء

**الأعراض:**
- الصفحات تستغرق وقتاً طويلاً للتحميل
- استجابة بطيئة للتفاعلات

**التشخيص:**
```bash
# فحص استخدام الموارد
top
htop
df -h
free -m

# فحص حجم قاعدة البيانات
ls -lh tewiiq.db

# فحص سجلات الأداء
tail -f /var/log/apache2/access.log
```

**الحلول:**
```bash
# 1. تحسين قاعدة البيانات
php admin/optimize-db.php

# 2. تنظيف الملفات القديمة
php admin/cleanup-files.php

# 3. تفعيل OPcache في php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000

# 4. ضغط المحتوى - Apache
a2enmod deflate
a2enmod gzip

# Nginx
gzip on;
gzip_types text/plain text/css application/json;

# 5. زيادة ذاكرة PHP
memory_limit = 512M
max_execution_time = 300
```

## مشاكل رفع الملفات

### 1. خطأ: "File upload failed"

**الأعراض:**
```
Failed to upload file: Permission denied
File size exceeds limit
```

**التشخيص:**
```bash
# فحص مجلد الرفع
ls -la uploads/
df -h uploads/

# فحص إعدادات PHP
php -i | grep -E "(upload_max_filesize|post_max_size|memory_limit)"
```

**الحلول:**
```bash
# 1. إصلاح صلاحيات مجلد الرفع
chmod -R 777 uploads/
chown -R www-data:www-data uploads/

# 2. زيادة حدود الرفع في php.ini
upload_max_filesize = 10M
post_max_size = 10M
max_file_uploads = 20
memory_limit = 128M

# 3. إنشاء مجلدات فرعية مفقودة
mkdir -p uploads/{avatars,covers,tweets,reels,temp}
chmod -R 777 uploads/

# 4. فحص مساحة القرص
df -h

# إعادة تشغيل الخادم
sudo systemctl restart apache2
```

### 2. مشاكل أنواع الملفات

**الأعراض:**
```
File type not allowed
Invalid file format
```

**الحلول:**
```php
// في ملف config/upload.php
<?php
return [
    'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'],
    'max_size' => 10 * 1024 * 1024, // 10MB
    'image_types' => ['jpg', 'jpeg', 'png', 'gif'],
    'video_types' => ['mp4', 'mov', 'avi']
];
```

## مشاكل الجلسات والمصادقة

### 1. خطأ: "Session expired"

**الأعراض:**
- تسجيل خروج تلقائي متكرر
- فقدان البيانات في النماذج

**التشخيص:**
```bash
# فحص إعدادات الجلسات
php -i | grep session

# فحص مجلد الجلسات
ls -la /tmp/
ls -la /var/lib/php/sessions/
```

**الحلول:**
```bash
# في php.ini
session.gc_maxlifetime = 7200
session.cookie_lifetime = 0
session.use_strict_mode = 1

# إنشاء مجلد جلسات مخصص
mkdir -p storage/sessions
chmod 777 storage/sessions

# في ملف .env
SESSION_LIFETIME=120
SESSION_PATH=./storage/sessions
```

### 2. مشاكل تسجيل الدخول

**الأعراض:**
```
Invalid username or password
Account not found
```

**التشخيص:**
```php
// ملف debug للتحقق من البيانات
<?php
require_once 'vendor/autoload.php';
require_once 'database/Database.php';

Database::init();

$username = 'test_user';
$user = \RedBeanPHP\R::findOne('users', 'username = ? OR email = ?', [$username, $username]);

if ($user) {
    echo "المستخدم موجود\n";
    echo "ID: " . $user->id . "\n";
    echo "Username: " . $user->username . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Status: " . ($user->status ?? 'active') . "\n";
} else {
    echo "المستخدم غير موجود\n";
}
?>
```

**الحلول:**
```bash
# إعادة تعيين كلمة مرور مستخدم
php admin/reset-password.php username new_password

# فحص حالة المستخدم
php admin/check-user.php username

# إنشاء مستخدم مدير جديد
php admin/create-admin.php
```

## مشاكل الواجهة والتصميم

### 1. التصميم مكسور أو لا يظهر

**الأعراض:**
- الصفحة تظهر نص فقط بدون تنسيق
- الخطوط العربية لا تظهر صحيحة
- الأيقونات مفقودة

**التشخيص:**
```bash
# فحص ملفات CSS والJS
curl -I http://localhost:5000/assets/css/style.css
curl -I https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css
```

**الحلول:**
```html
<!-- التأكد من وجود المراجع الصحيحة في head -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
```

```bash
# فحص الاتصال بالإنترنت للـ CDN
ping cdn.jsdelivr.net
ping fonts.googleapis.com

# حل مشاكل الخطوط العربية
# إضافة إلى CSS
body {
    font-family: 'Tajawal', 'Cairo', sans-serif;
    direction: rtl;
    text-align: right;
}
```

### 2. مشاكل الاستجابة (Responsive)

**الأعراض:**
- التصميم لا يتكيف مع الأجهزة المحمولة
- عناصر خارج الشاشة

**الحلول:**
```html
<!-- إضافة meta tag للاستجابة -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

```css
/* إصلاح مشاكل العرض */
@media (max-width: 768px) {
    .main-content {
        margin-right: 0 !important;
        padding: 1rem;
    }
    
    .sidebar {
        transform: translateX(100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
}
```

## مشاكل البريد الإلكتروني

### 1. رسائل البريد لا ترسل

**الأعراض:**
```
Failed to send email
SMTP connection failed
```

**التشخيص:**
```bash
# فحص إعدادات البريد في .env
cat .env | grep MAIL

# اختبار الاتصال بخادم SMTP
telnet smtp.gmail.com 587
```

**الحلول:**
```env
# إعدادات Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# إعدادات بديلة للتطوير
MAIL_MAILER=log
MAIL_LOG_CHANNEL=mail
```

```php
// اختبار إرسال بريد
<?php
$to = 'test@example.com';
$subject = 'اختبار البريد';
$message = 'هذه رسالة اختبار';
$headers = 'From: noreply@tewiiq.com' . "\r\n" .
           'Content-Type: text/html; charset=UTF-8' . "\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "تم إرسال البريد بنجاح\n";
} else {
    echo "فشل إرسال البريد\n";
}
?>
```

## أدوات التشخيص

### 1. سكريبت فحص النظام

```php
<?php
// admin/system-check.php
echo "=== فحص النظام ===\n\n";

// فحص PHP
echo "إصدار PHP: " . PHP_VERSION . "\n";

// فحص الامتدادات
$required_extensions = ['json', 'mbstring', 'sqlite3', 'curl', 'gd'];
foreach ($required_extensions as $ext) {
    echo "امتداد $ext: " . (extension_loaded($ext) ? "✅" : "❌") . "\n";
}

// فحص الملفات
$required_files = ['.env', 'tewiiq.db', 'uploads/', 'vendor/'];
foreach ($required_files as $file) {
    echo "ملف $file: " . (file_exists($file) ? "✅" : "❌") . "\n";
}

// فحص الصلاحيات
echo "صلاحيات tewiiq.db: " . (is_writable('tewiiq.db') ? "✅" : "❌") . "\n";
echo "صلاحيات uploads/: " . (is_writable('uploads/') ? "✅" : "❌") . "\n";

// فحص الذاكرة
echo "حد الذاكرة: " . ini_get('memory_limit') . "\n";
echo "حد رفع الملفات: " . ini_get('upload_max_filesize') . "\n";

// فحص قاعدة البيانات
try {
    require_once 'database/Database.php';
    Database::init();
    $count = \RedBeanPHP\R::count('users');
    echo "اتصال قاعدة البيانات: ✅ ($count مستخدم)\n";
} catch (Exception $e) {
    echo "اتصال قاعدة البيانات: ❌ " . $e->getMessage() . "\n";
}

echo "\n=== انتهى الفحص ===\n";
?>
```

### 2. مراقبة السجلات

```bash
#!/bin/bash
# monitor-logs.sh

echo "مراقبة سجلات النظام..."

# سجلات Apache/Nginx
echo "=== سجلات الخادم ==="
tail -f /var/log/apache2/error.log &
tail -f /var/log/nginx/error.log &

# سجلات PHP
echo "=== سجلات PHP ==="
tail -f /var/log/php_errors.log &

# سجلات التطبيق (إذا كانت موجودة)
echo "=== سجلات التطبيق ==="
tail -f storage/logs/app.log &

wait
```

### 3. تنظيف وصيانة تلقائية

```bash
#!/bin/bash
# maintenance.sh

echo "بدء الصيانة التلقائية..."

# تنظيف ملفات مؤقتة
rm -rf uploads/temp/*
echo "تم تنظيف الملفات المؤقتة"

# تحسين قاعدة البيانات
php admin/optimize-db.php
echo "تم تحسين قاعدة البيانات"

# تنظيف ذاكرة التخزين المؤقت
rm -rf storage/cache/*
echo "تم تنظيف الذاكرة المؤقتة"

# تنظيف الجلسات المنتهية الصلاحية
find storage/sessions -name "sess_*" -mtime +1 -delete
echo "تم تنظيف الجلسات القديمة"

# إعادة تشغيل خدمات
sudo systemctl reload apache2
echo "تم إعادة تحميل خدمة الويب"

echo "انتهت الصيانة التلقائية"
```

## الحصول على المساعدة

### مصادر المساعدة

1. **الوثائق الرسمية**: `/docs/`
2. **مركز المساعدة**: `/help`
3. **منتدى المجتمع**: GitHub Issues
4. **الدعم المباشر**: support@tewiiq.com

### معلومات مطلوبة عند طلب المساعدة

```bash
# معلومات النظام
php -v
composer --version
cat .env | grep -v PASSWORD
ls -la tewiiq.db
df -h

# سجلات الأخطاء (آخر 20 سطر)
tail -20 /var/log/apache2/error.log
tail -20 storage/logs/app.log

# تشغيل فحص النظام
php admin/system-check.php
```

### تقرير خطأ

عند الإبلاغ عن خطأ، يرجى تضمين:

1. **وصف المشكلة**: ما الذي حدث؟
2. **خطوات إعادة الإنتاج**: كيف يمكن تكرار المشكلة؟
3. **السلوك المتوقع**: ما الذي كنت تتوقع حدوثه؟
4. **معلومات البيئة**: إصدار PHP، نظام التشغيل، متصفح
5. **سجلات الأخطاء**: أي رسائل خطأ في السجلات
6. **لقطات شاشة**: إذا كانت المشكلة بصرية

---

هذا الدليل يغطي معظم المشاكل الشائعة. إذا لم تجد حلاً لمشكلتك، لا تتردد في التواصل مع فريق الدعم مع تفاصيل المشكلة والمعلومات المطلوبة.