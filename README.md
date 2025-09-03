# منصة تويق - الدليل الشامل

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-brightgreen.svg)](#)

## نظرة عامة

**تويق** هي منصة التواصل الاجتماعي العربية الحديثة المبنية بـ PHP، مصممة خصيصاً للمجتمع العربي مع دعم كامل للغة العربية والكتابة من اليمين إلى اليسار (RTL). توفر المنصة تجربة تواصل اجتماعي شاملة تشمل التغريدات، الرسائل المباشرة، الريلز، والفعاليات.

## 🌟 الميزات الرئيسية

### ✅ الميزات الأساسية
- **نظام المصادقة**: تسجيل دخول آمن وإدارة الحسابات
- **التغريدات**: كتابة ومشاركة المحتوى مع دعم الوسائط
- **التفاعل الاجتماعي**: إعجاب، رد، إعادة تغريد، ومتابعة
- **الرسائل الخاصة**: نظام دردشة مباشر بين المستخدمين
- **البحث المتقدم**: البحث في التغريدات والمستخدمين والهاشتاغات

### 🎥 ميزات الوسائط
- **الريلز**: مقاطع فيديو قصيرة مع تفاعلات
- **رفع الملفات**: دعم الصور والفيديوهات
- **معرض الوسائط**: عرض وتنظيم الملفات المرفقة

### 👥 الميزات الاجتماعية
- **الملفات الشخصية**: صفحات مستخدمين مخصصة
- **المتابعة والمتابعون**: نظام شبكة اجتماعية كامل
- **القوائم**: تنظيم المستخدمين في مجموعات
- **الأحداث**: إنشاء ومشاركة الفعاليات والبث المباشر

### 🎨 واجهة المستخدم
- **تصميم حديث**: واجهة عصرية مع Bootstrap 5
- **دعم اللغة العربية**: تخطيط RTL كامل
- **استجابة كاملة**: متوافق مع جميع الأجهزة
- **النمط المظلم/الفاتح**: تبديل سلس بين الأنماط
- **مكونات تفاعلية**: شريط تنقل، قائمة جانبية، وفوتر متقدم

## 🚀 التثبيت السريع

### المتطلبات الأساسية
- PHP 8.2 أو أحدث
- Composer
- SQLite3 (مُضمن) أو MySQL/PostgreSQL
- خادم ويب (Apache/Nginx/PHP Built-in)

### خطوات التثبيت

```bash
# 1. تنزيل المشروع
git clone https://github.com/your-username/tewiiq.git
cd tewiiq

# 2. تثبيت التبعيات
composer install --no-dev --optimize-autoloader

# 3. إعداد البيئة
cp .env.example .env
nano .env  # تحرير الإعدادات

# 4. إعداد الصلاحيات
chmod -R 755 .
chmod 666 tewiiq.db
chmod -R 777 uploads/

# 5. تشغيل التطبيق
php -S localhost:5000 -t public/
```

### معاينة سريعة
بعد التثبيت، افتح المتصفح وانتقل إلى `http://localhost:5000`

**بيانات تجريبية:**
- اسم المستخدم: `ahmed_dev`
- كلمة المرور: `password123`

## 📚 الوثائق الشاملة

### للمستخدمين
- **[دليل التثبيت](docs/installation.md)** - خطوات التثبيت التفصيلية لجميع البيئات
- **[دليل المستخدم](docs/user-guide.md)** - كيفية استخدام جميع ميزات المنصة
- **[حل المشاكل](docs/troubleshooting.md)** - حلول للمشاكل الشائعة

### للمديرين
- **[دليل الإدارة](docs/admin-guide.md)** - إدارة النظام والمستخدمين والمحتوى
- **[النسخ الاحتياطي](docs/admin-guide.md#النسخ-الاحتياطي)** - استراتيجيات الحماية والاستعادة
- **[المراقبة والأمان](docs/admin-guide.md#مراقبة-النظام)** - أدوات الرصد والحماية

### للمطورين
- **[دليل المطورين](docs/developer-guide.md)** - البنية التقنية وإرشادات التطوير
- **[واجهات برمجة التطبيقات](docs/developer-guide.md#واجهات-برمجة-التطبيقات)** - API للتكامل الخارجي
- **[الاختبارات](docs/developer-guide.md#الاختبارات)** - كيفية كتابة وتشغيل الاختبارات

## 🏗 البنية التقنية

### Backend
- **PHP 8.2+** مع أفضل الممارسات الحديثة
- **RedBean ORM** لإدارة قاعدة البيانات بدون تعقيد
- **League Plates** محرك قوالب PHP أصلي
- **SQLite** قاعدة بيانات سريعة ومحمولة
- **Composer** لإدارة التبعيات

### Frontend
- **Bootstrap 5.3** إطار عمل UI حديث
- **Bootstrap Icons + Font Awesome** مكتبات أيقونات شاملة
- **Google Fonts** خطوط عربية محسنة (Tajawal, Cairo)
- **Vanilla JavaScript** تفاعلات سريعة وخفيفة
- **CSS3** مع متغيرات وانيميشن متقدم

### قاعدة البيانات
```
users              - حسابات المستخدمين
tweets             - التغريدات الرئيسية
replies            - ردود التغريدات
likes              - إعجابات التغريدات
follows            - علاقات المتابعة
messages           - الرسائل الخاصة
conversations      - محادثات الدردشة
reels              - مقاطع الفيديو القصيرة
events             - الفعاليات والأحداث
lists              - قوائم المستخدمين
usersettings       - إعدادات الحسابات
```

## 🔧 خيارات التخصيص

### إعدادات التطبيق
```php
// config/app.php
return [
    'site_name' => 'تويق',
    'max_tweet_length' => 280,
    'max_file_size' => 10 * 1024 * 1024, // 10MB
    'allowed_file_types' => ['jpg', 'jpeg', 'png', 'gif', 'mp4'],
    'features' => [
        'registration_open' => true,
        'reels_enabled' => true,
        'events_enabled' => true,
        'lists_enabled' => true,
    ]
];
```

### متغيرات البيئة
```env
# إعدادات التطبيق
APP_NAME="تويق"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# قاعدة البيانات
DB_CONNECTION=sqlite
DB_DATABASE=./tewiiq.db

# الميزات
REELS_ENABLED=true
EVENTS_ENABLED=true
REGISTRATION_OPEN=true
```

## 🚀 النشر في الإنتاج

### خادم مشترك
```bash
# رفع الملفات عبر FTP/cPanel
# تثبيت التبعيات محلياً ورفع مجلد vendor/
composer install --no-dev --optimize-autoloader

# إعداد .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
```

### VPS/الخادم المخصص
```bash
# إعداد Apache/Nginx
# إعداد SSL/HTTPS
# إعداد النسخ الاحتياطي التلقائي
# تفعيل التخزين المؤقت
```

### Docker
```dockerfile
FROM php:8.2-apache
COPY . /var/www/html/
RUN composer install --no-dev --optimize-autoloader
EXPOSE 80
```

## 🛡 الأمان والخصوصية

### ميزات الأمان المُضمنة
- **حماية من CSRF** على جميع النماذج
- **تنظيف المدخلات** تلقائياً
- **تشفير كلمات المرور** بـ bcrypt
- **جلسات آمنة** مع انتهاء صلاحية
- **حماية من SQL Injection** باستخدام Prepared Statements

### إعدادات الخصوصية
- **حسابات خاصة/عامة**
- **التحكم في المتابعين**
- **حظر وكتم المستخدمين**
- **إعدادات الرؤية المخصصة**

## 📊 الأداء والمراقبة

### تحسين الأداء
```php
// تفعيل OPcache
opcache.enable=1
opcache.memory_consumption=128

// ضغط المحتوى
gzip on;
gzip_types text/plain text/css application/json;

// التخزين المؤقت
Cache-Control: public, max-age=3600
```

### أدوات المراقبة
- **مراقبة استخدام الموارد**
- **تتبع أداء قاعدة البيانات**
- **سجلات النشاط والأخطاء**
- **إحصائيات المستخدمين**

## 🤝 المساهمة

نرحب بمساهماتكم! يرجى قراءة [دليل المطورين](docs/developer-guide.md) أولاً.

### خطوات المساهمة
1. Fork المشروع
2. إنشاء فرع للميزة (`git checkout -b feature/amazing-feature`)
3. Commit التغييرات (`git commit -m 'feat: إضافة ميزة رائعة'`)
4. Push للفرع (`git push origin feature/amazing-feature`)
5. إنشاء Pull Request

### معايير الكود
- **PSR-12** لتنسيق الكود
- **PHPDoc** للتوثيق
- **اختبارات الوحدة** للكود الجديد
- **أمان أولاً** في جميع التطوير

## 📞 الدعم والمساعدة

### طرق التواصل
- **الوثائق**: هذا المستودع
- **المسائل**: [GitHub Issues](https://github.com/your-username/tewiiq/issues)
- **البريد الإلكتروني**: support@tewiiq.com
- **الدردشة**: قريباً

### الأسئلة الشائعة
**س: هل يمكن استخدام قاعدة بيانات MySQL بدلاً من SQLite؟**
ج: نعم، غير إعدادات قاعدة البيانات في ملف `.env`

**س: كيف يمكن تخصيص التصميم؟**
ج: عدّل ملفات CSS في `public/assets/` أو استخدم متغيرات CSS

**س: هل المنصة آمنة للاستخدام في الإنتاج؟**
ج: نعم، مع اتباع [دليل الأمان](docs/admin-guide.md#إدارة-الأمان)

## 📋 خريطة الطريق

### الإصدار الحالي (v1.0)
- ✅ جميع الميزات الأساسية
- ✅ واجهة مستخدم متقدمة
- ✅ نظام إدارة شامل
- ✅ وثائق كاملة

### الإصدارات القادمة
- 🔄 تطبيق جوال (React Native)
- 🔄 إشعارات فورية (WebSockets)
- 🔄 نظام الاشتراكات المدفوعة
- 🔄 تحليلات وإحصائيات متقدمة
- 🔄 API GraphQL
- 🔄 دعم لغات إضافية

## 📄 الترخيص

هذا المشروع مرخص تحت [رخصة MIT](LICENSE) - راجع ملف LICENSE للتفاصيل.

## 🙏 شكر وتقدير

- **Bootstrap Team** - إطار عمل UI الرائع
- **RedBean ORM** - مكتبة قاعدة البيانات المرنة
- **League Plates** - محرك القوالب السريع
- **مجتمع PHP العربي** - الدعم والإلهام

---

<div align="center">

**صُنع بـ ❤️ للمجتمع العربي**

[الموقع الرسمي](https://tewiiq.com) • [الوثائق](docs/) • [الدعم](support@tewiiq.com)

</div>