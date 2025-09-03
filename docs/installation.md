# دليل التثبيت والإعداد - منصة تويق

## المتطلبات الأساسية

### متطلبات النظام
- **PHP**: الإصدار 8.1 أو أحدث
- **Composer**: لإدارة المكتبات والتبعيات
- **خادم ويب**: Apache أو Nginx أو PHP Built-in Server
- **قاعدة البيانات**: SQLite (مُضمنة) أو MySQL/PostgreSQL (اختياري)
- **ذاكرة**: 512 ميجابايت كحد أدنى، 1 جيجابايت مُستحسن
- **مساحة القرص**: 500 ميجابايت للتطبيق والبيانات

### امتدادات PHP المطلوبة
```bash
# امتدادات أساسية
php-json
php-mbstring
php-sqlite3
php-curl
php-gd
php-zip
php-xml

# امتدادات اختيارية (للتحسين)
php-opcache
php-redis (للتخزين المؤقت)
php-mysql (إذا كنت تستخدم MySQL)
php-pgsql (إذا كنت تستخدم PostgreSQL)
```

## طرق التثبيت

### الطريقة الأولى: التثبيت المحلي

#### 1. تنزيل الكود المصدري
```bash
# استنساخ المشروع من Git
git clone https://github.com/your-username/tewiiq.git
cd tewiiq

# أو تنزيل الملف المضغوط وفك الضغط
wget https://github.com/your-username/tewiiq/archive/main.zip
unzip main.zip
cd tewiiq-main
```

#### 2. تثبيت التبعيات
```bash
# تثبيت مكتبات PHP باستخدام Composer
composer install --no-dev --optimize-autoloader

# للتطوير (يتضمن أدوات التطوير)
composer install
```

#### 3. إعداد الصلاحيات
```bash
# إعداد صلاحيات الكتابة للمجلدات المطلوبة
chmod -R 755 public/
chmod -R 777 uploads/
chmod -R 777 database/
chmod 666 tewiiq.db

# أو باستخدام chown (حسب إعداد الخادم)
chown -R www-data:www-data .
```

#### 4. إعداد متغيرات البيئة
```bash
# نسخ ملف البيئة النموذجي
cp .env.example .env

# تحرير الملف وإضافة الإعدادات
nano .env
```

```env
# إعدادات التطبيق
APP_NAME="تويق"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:5000

# إعدادات قاعدة البيانات
DB_CONNECTION=sqlite
DB_DATABASE=./tewiiq.db

# إعدادات الجلسات
SESSION_LIFETIME=120
SESSION_SECURE=false

# إعدادات الرفع
UPLOAD_MAX_SIZE=10M
ALLOWED_EXTENSIONS=jpg,jpeg,png,gif,mp4,mov,avi

# إعدادات البريد الإلكتروني (اختياري)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

#### 5. تهيئة قاعدة البيانات
```bash
# تشغيل التطبيق لإنشاء قاعدة البيانات تلقائياً
php -S localhost:5000 -t public/

# أو يمكن إنشاء قاعدة البيانات يدوياً
touch tewiiq.db
chmod 666 tewiiq.db
```

### الطريقة الثانية: التثبيت على خادم مشترك

#### 1. رفع الملفات
```bash
# ضغط الملفات محلياً
zip -r tewiiq.zip . -x "*.git*" "node_modules/*" "*.env"

# رفع الملف المضغوط عبر cPanel أو FTP
# فك الضغط في المجلد الجذر للموقع
```

#### 2. إعداد الخادم
```apache
# إضافة إلى .htaccess في المجلد الجذر
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]

# إعدادات PHP (في .user.ini أو php.ini)
memory_limit = 512M
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

#### 3. تشغيل Composer على الخادم
```bash
# إذا كان Composer متوفراً على الخادم
composer install --no-dev --optimize-autoloader

# إذا لم يكن متوفراً، قم بتثبيت التبعيات محلياً ورفعها
# (تأكد من رفع مجلد vendor/)
```

### الطريقة الثالثة: التثبيت باستخدام Docker

#### 1. إنشاء Dockerfile
```dockerfile
FROM php:8.2-apache

# تثبيت امتدادات PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip gd

# تفعيل mod_rewrite
RUN a2enmod rewrite

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات التطبيق
WORKDIR /var/www/html
COPY . .

# تثبيت التبعيات
RUN composer install --no-dev --optimize-autoloader

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
```

#### 2. إنشاء docker-compose.yml
```yaml
version: '3.8'

services:
  tewiiq:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./uploads:/var/www/html/uploads
      - ./tewiiq.db:/var/www/html/tewiiq.db
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
    restart: unless-stopped
```

#### 3. تشغيل التطبيق
```bash
# بناء وتشغيل الحاوية
docker-compose up -d

# عرض السجلات
docker-compose logs -f
```

## الإعداد الأولي

### 1. إنشاء حساب المدير الأول
```bash
# الوصول إلى التطبيق في المتصفح
http://localhost:5000

# التسجيل كمستخدم جديد
# المستخدم الأول سيحصل على صلاحيات المدير تلقائياً
```

### 2. إعدادات النظام الأساسية
```php
// في ملف config/app.php (إنشاء إذا لم يكن موجوداً)
<?php
return [
    'site_name' => 'تويق',
    'site_description' => 'منصة التواصل الاجتماعي العربية',
    'timezone' => 'Asia/Riyadh',
    'locale' => 'ar',
    'max_tweet_length' => 280,
    'max_file_size' => 10 * 1024 * 1024, // 10MB
    'allowed_file_types' => ['jpg', 'jpeg', 'png', 'gif', 'mp4'],
    'features' => [
        'registration_open' => true,
        'email_verification' => false,
        'reels_enabled' => true,
        'events_enabled' => true,
        'lists_enabled' => true,
        'messages_enabled' => true,
    ]
];
```

### 3. إعداد الخادم الويب

#### Apache
```apache
# في ملف .htaccess في المجلد الجذر
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/index.php [QSA,L]
</IfModule>

# إعدادات الأمان
<Files ".env">
    Require all denied
</Files>

<Files "*.db">
    Require all denied
</Files>

# إعدادات التخزين المؤقت
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/tewiiq/public;
    index index.php;

    # إعداد اللغة العربية
    charset utf-8;

    # التوجيه للـ front controller
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # معالجة ملفات PHP
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # منع الوصول للملفات الحساسة
    location ~ /\.(env|git|htaccess) {
        deny all;
    }

    location ~ \.db$ {
        deny all;
    }

    # إعدادات التخزين المؤقت
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1M;
        add_header Cache-Control "public, immutable";
    }

    # ضغط الملفات
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
}
```

## التحقق من التثبيت

### 1. فحص النظام
```bash
# التحقق من إصدار PHP
php -v

# التحقق من الامتدادات المطلوبة
php -m | grep -E "(json|mbstring|sqlite3|curl|gd|zip)"

# التحقق من Composer
composer --version

# فحص صلاحيات الملفات
ls -la uploads/
ls -la tewiiq.db
```

### 2. اختبار التطبيق
```bash
# تشغيل الخادم المحلي للاختبار
php -S localhost:5000 -t public/

# فتح المتصفح والانتقال إلى
http://localhost:5000

# التحقق من الصفحات الأساسية:
# - الصفحة الرئيسية
# - تسجيل الدخول
# - إنشاء حساب
# - صفحة من نحن
# - صفحة المساعدة
```

### 3. اختبار قاعدة البيانات
```php
<?php
// ملف test-db.php للاختبار
require_once 'vendor/autoload.php';
require_once 'database/Database.php';

try {
    Database::init();
    echo "✅ قاعدة البيانات تعمل بشكل صحيح\n";
    
    // اختبار إنشاء جدول
    $testUser = \RedBeanPHP\R::dispense('users');
    $testUser->username = 'test_user';
    $testUser->email = 'test@example.com';
    $id = \RedBeanPHP\R::store($testUser);
    
    if ($id) {
        echo "✅ يمكن كتابة البيانات\n";
        \RedBeanPHP\R::trash($testUser);
        echo "✅ يمكن حذف البيانات\n";
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "\n";
}
?>
```

## نصائح ما بعد التثبيت

### 1. الأمان
- تغيير كلمات المرور الافتراضية
- تفعيل HTTPS في البيئة الإنتاجية
- إعداد جدار حماية للخادم
- تحديث PHP والمكتبات بانتظام

### 2. الأداء
- تفعيل OPcache لـ PHP
- استخدام خادم ويب مخصص بدلاً من Built-in Server
- إعداد CDN للملفات الثابتة
- استخدام Redis للتخزين المؤقت

### 3. النسخ الاحتياطي
```bash
# نسخ احتياطي لقاعدة البيانات
cp tewiiq.db backups/tewiiq_$(date +%Y%m%d_%H%M%S).db

# نسخ احتياطي للملفات المرفوعة
tar -czf backups/uploads_$(date +%Y%m%d_%H%M%S).tar.gz uploads/

# نسخ احتياطي شامل
tar -czf backups/tewiiq_full_$(date +%Y%m%d_%H%M%S).tar.gz \
    --exclude='backups' \
    --exclude='node_modules' \
    --exclude='.git' \
    .
```

### 4. المراقبة
- إعداد سجلات للأخطاء
- مراقبة استخدام الموارد
- تتبع أداء قاعدة البيانات
- إعداد تنبيهات للمشاكل

## استكشاف الأخطاء الشائعة

### مشكلة: خطأ 500 (Internal Server Error)
```bash
# فحص سجلات الأخطاء
tail -f /var/log/apache2/error.log
# أو
tail -f storage/logs/error.log

# الحلول الشائعة:
# 1. التحقق من صلاحيات الملفات
# 2. التأكد من تثبيت الامتدادات المطلوبة
# 3. فحص ملف .env
```

### مشكلة: صفحة فارغة أو بيضاء
```php
// تفعيل عرض الأخطاء مؤقتاً
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### مشكلة: لا يمكن رفع الملفات
```bash
# التحقق من إعدادات PHP
php -i | grep -E "(upload_max_filesize|post_max_size|memory_limit)"

# التحقق من صلاحيات مجلد الرفع
ls -la uploads/
chmod 777 uploads/
```

للحصول على مساعدة إضافية، راجع [دليل استكشاف الأخطاء](troubleshooting.md) أو تواصل مع فريق الدعم.