# دليل الإدارة والصيانة - منصة تويق

## مقدمة

هذا الدليل مخصص لمديري النظام والمطورين المسؤولين عن صيانة وإدارة منصة تويق. يغطي جميع جوانب الإدارة من المراقبة إلى الصيانة والنسخ الاحتياطي.

## لوحة الإدارة

### الوصول إلى لوحة الإدارة

```bash
# الوصول عبر المتصفح
http://your-domain.com/admin

# أو عبر سطر الأوامر
php admin/console.php
```

### أذونات المدير

#### إنشاء حساب مدير
```php
// في ملف admin/create-admin.php
<?php
require_once '../vendor/autoload.php';
require_once '../database/Database.php';

Database::init();

$admin = \RedBeanPHP\R::dispense('users');
$admin->username = 'admin';
$admin->email = 'admin@tewiiq.com';
$admin->fullname = 'مدير النظام';
$admin->password = password_hash('your-secure-password', PASSWORD_DEFAULT);
$admin->role = 'admin';
$admin->verified = 1;
$admin->created_at = date('Y-m-d H:i:s');

$adminId = \RedBeanPHP\R::store($admin);
echo "تم إنشاء حساب المدير بنجاح. ID: " . $adminId . "\n";
?>
```

#### مستويات الأذونات
- **admin**: صلاحيات كاملة للنظام
- **moderator**: إدارة المحتوى والمستخدمين
- **editor**: تحرير المحتوى فقط
- **user**: مستخدم عادي

## إدارة قاعدة البيانات

### النسخ الاحتياطي

#### النسخ الاحتياطي اليدوي
```bash
#!/bin/bash
# backup-db.sh

BACKUP_DIR="/var/backups/tewiiq"
DATE=$(date +%Y%m%d_%H%M%S)
DB_FILE="tewiiq.db"

# إنشاء مجلد النسخ الاحتياطي
mkdir -p $BACKUP_DIR

# نسخ قاعدة البيانات
cp $DB_FILE $BACKUP_DIR/tewiiq_$DATE.db

# ضغط النسخة الاحتياطية
gzip $BACKUP_DIR/tewiiq_$DATE.db

# حذف النسخ القديمة (أكثر من 30 يوم)
find $BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "تم إنشاء نسخة احتياطية: tewiiq_$DATE.db.gz"
```

#### النسخ الاحتياطي التلقائي
```bash
# إضافة إلى crontab
crontab -e

# نسخة احتياطية يومية في الساعة 2:00 صباحاً
0 2 * * * /path/to/tewiiq/backup-db.sh

# نسخة احتياطية أسبوعية
0 2 * * 0 /path/to/tewiiq/backup-full.sh
```

### استعادة النسخ الاحتياطي

```bash
#!/bin/bash
# restore-db.sh

BACKUP_FILE=$1

if [ -z "$BACKUP_FILE" ]; then
    echo "الاستخدام: $0 <backup-file>"
    exit 1
fi

# إيقاف الخدمات
systemctl stop apache2  # أو nginx

# نسخ احتياطي للقاعدة الحالية
cp tewiiq.db tewiiq.db.backup

# استعادة النسخة الاحتياطية
if [[ $BACKUP_FILE == *.gz ]]; then
    gunzip -c $BACKUP_FILE > tewiiq.db
else
    cp $BACKUP_FILE tewiiq.db
fi

# إعادة تشغيل الخدمات
systemctl start apache2

echo "تم استعادة قاعدة البيانات من: $BACKUP_FILE"
```

### تحسين قاعدة البيانات

```php
<?php
// admin/optimize-db.php
require_once '../vendor/autoload.php';
require_once '../database/Database.php';

Database::init();

// تحسين جداول SQLite
\RedBeanPHP\R::exec('VACUUM');
\RedBeanPHP\R::exec('ANALYZE');

// حذف البيانات القديمة والمحذوفة
$deleted = \RedBeanPHP\R::exec('DELETE FROM tweets WHERE deleted_at IS NOT NULL AND deleted_at < ?', [
    date('Y-m-d H:i:s', strtotime('-30 days'))
]);

$deletedMessages = \RedBeanPHP\R::exec('DELETE FROM messages WHERE deleted_at IS NOT NULL AND deleted_at < ?', [
    date('Y-m-d H:i:s', strtotime('-7 days'))
]);

echo "تم حذف $deleted تغريدة قديمة\n";
echo "تم حذف $deletedMessages رسالة قديمة\n";
echo "تم تحسين قاعدة البيانات\n";
?>
```

## إدارة المستخدمين

### عرض إحصائيات المستخدمين

```php
<?php
// admin/user-stats.php
require_once '../vendor/autoload.php';
require_once '../database/Database.php';

Database::init();

$totalUsers = \RedBeanPHP\R::count('users');
$activeUsers = \RedBeanPHP\R::count('users', 'last_login > ?', [date('Y-m-d H:i:s', strtotime('-30 days'))]);
$newUsers = \RedBeanPHP\R::count('users', 'created_at > ?', [date('Y-m-d H:i:s', strtotime('-7 days'))]);

echo "إجمالي المستخدمين: $totalUsers\n";
echo "المستخدمون النشطون (آخر 30 يوم): $activeUsers\n";
echo "المستخدمون الجدد (آخر 7 أيام): $newUsers\n";
?>
```

### إدارة المستخدمين المخالفين

```php
<?php
// admin/moderate-users.php
class UserModerator {
    
    public static function suspendUser($userId, $reason, $duration = null) {
        $user = \RedBeanPHP\R::load('users', $userId);
        if (!$user->id) return false;
        
        $user->status = 'suspended';
        $user->suspension_reason = $reason;
        $user->suspended_at = date('Y-m-d H:i:s');
        
        if ($duration) {
            $user->suspension_until = date('Y-m-d H:i:s', strtotime($duration));
        }
        
        \RedBeanPHP\R::store($user);
        
        // إرسال إشعار للمستخدم
        self::sendSuspensionNotification($user, $reason);
        
        return true;
    }
    
    public static function banUser($userId, $reason) {
        $user = \RedBeanPHP\R::load('users', $userId);
        if (!$user->id) return false;
        
        $user->status = 'banned';
        $user->ban_reason = $reason;
        $user->banned_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($user);
        
        // حذف جلسات المستخدم
        \RedBeanPHP\R::exec('DELETE FROM sessions WHERE user_id = ?', [$userId]);
        
        return true;
    }
    
    public static function deleteUser($userId) {
        $user = \RedBeanPHP\R::load('users', $userId);
        if (!$user->id) return false;
        
        // حذف بيانات المستخدم
        \RedBeanPHP\R::exec('DELETE FROM tweets WHERE user_id = ?', [$userId]);
        \RedBeanPHP\R::exec('DELETE FROM messages WHERE sender_id = ? OR receiver_id = ?', [$userId, $userId]);
        \RedBeanPHP\R::exec('DELETE FROM follows WHERE follower_id = ? OR following_id = ?', [$userId, $userId]);
        
        // حذف الحساب
        \RedBeanPHP\R::trash($user);
        
        return true;
    }
    
    private static function sendSuspensionNotification($user, $reason) {
        // إرسال بريد إلكتروني أو إشعار
        // يمكن تطوير هذه الدالة حسب الحاجة
    }
}
?>
```

## إدارة المحتوى

### مراقبة المحتوى

```php
<?php
// admin/content-monitor.php
class ContentMonitor {
    
    public static function getReportedContent() {
        return \RedBeanPHP\R::find('reports', 'status = ? ORDER BY created_at DESC', ['pending']);
    }
    
    public static function flagTweet($tweetId, $reason) {
        $tweet = \RedBeanPHP\R::load('tweets', $tweetId);
        if (!$tweet->id) return false;
        
        $tweet->flagged = 1;
        $tweet->flag_reason = $reason;
        $tweet->flagged_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($tweet);
        return true;
    }
    
    public static function deleteTweet($tweetId, $reason) {
        $tweet = \RedBeanPHP\R::load('tweets', $tweetId);
        if (!$tweet->id) return false;
        
        $tweet->deleted_at = date('Y-m-d H:i:s');
        $tweet->deletion_reason = $reason;
        
        \RedBeanPHP\R::store($tweet);
        return true;
    }
    
    public static function getContentStats() {
        $totalTweets = \RedBeanPHP\R::count('tweets');
        $flaggedTweets = \RedBeanPHP\R::count('tweets', 'flagged = 1');
        $deletedTweets = \RedBeanPHP\R::count('tweets', 'deleted_at IS NOT NULL');
        
        return [
            'total' => $totalTweets,
            'flagged' => $flaggedTweets,
            'deleted' => $deletedTweets
        ];
    }
}
?>
```

### فلترة المحتوى التلقائية

```php
<?php
// admin/content-filter.php
class ContentFilter {
    
    private static $bannedWords = [
        'كلمة_محظورة_1',
        'كلمة_محظورة_2',
        // إضافة المزيد حسب الحاجة
    ];
    
    public static function filterTweet($content) {
        $issues = [];
        
        // فحص الكلمات المحظورة
        foreach (self::$bannedWords as $word) {
            if (stripos($content, $word) !== false) {
                $issues[] = "يحتوي على كلمة محظورة: $word";
            }
        }
        
        // فحص طول المحتوى
        if (strlen($content) > 280) {
            $issues[] = "المحتوى طويل جداً";
        }
        
        // فحص الروابط المشبوهة
        if (preg_match('/http[s]?:\/\/[^\s]+/i', $content, $matches)) {
            // يمكن إضافة فحص للروابط الآمنة هنا
        }
        
        return $issues;
    }
    
    public static function autoModerate($tweetId) {
        $tweet = \RedBeanPHP\R::load('tweets', $tweetId);
        if (!$tweet->id) return false;
        
        $issues = self::filterTweet($tweet->content);
        
        if (!empty($issues)) {
            ContentMonitor::flagTweet($tweetId, implode(', ', $issues));
            return true;
        }
        
        return false;
    }
}
?>
```

## مراقبة النظام

### مراقبة الأداء

```php
<?php
// admin/performance-monitor.php
class PerformanceMonitor {
    
    public static function getSystemStats() {
        $stats = [];
        
        // استخدام الذاكرة
        $stats['memory_usage'] = memory_get_usage(true);
        $stats['memory_peak'] = memory_get_peak_usage(true);
        
        // حجم قاعدة البيانات
        $stats['db_size'] = filesize('tewiiq.db');
        
        // عدد المستخدمين المتصلين
        $stats['active_sessions'] = \RedBeanPHP\R::count('sessions', 'last_activity > ?', [
            date('Y-m-d H:i:s', strtotime('-5 minutes'))
        ]);
        
        // متوسط وقت الاستجابة
        $stats['avg_response_time'] = self::getAverageResponseTime();
        
        return $stats;
    }
    
    public static function logPerformance() {
        $stats = self::getSystemStats();
        
        $log = \RedBeanPHP\R::dispense('performance_logs');
        $log->memory_usage = $stats['memory_usage'];
        $log->db_size = $stats['db_size'];
        $log->active_sessions = $stats['active_sessions'];
        $log->response_time = $stats['avg_response_time'];
        $log->logged_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($log);
    }
    
    private static function getAverageResponseTime() {
        // يمكن تطوير هذه الدالة لحساب متوسط وقت الاستجابة
        return 0;
    }
}
?>
```

### سجلات النظام

```php
<?php
// admin/logger.php
class SystemLogger {
    
    public static function log($level, $message, $context = []) {
        $log = \RedBeanPHP\R::dispense('system_logs');
        $log->level = $level;
        $log->message = $message;
        $log->context = json_encode($context);
        $log->ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $log->user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $log->logged_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($log);
    }
    
    public static function logUserAction($userId, $action, $details = []) {
        self::log('info', "User action: $action", [
            'user_id' => $userId,
            'details' => $details
        ]);
    }
    
    public static function logError($error, $context = []) {
        self::log('error', $error, $context);
    }
    
    public static function logSecurity($event, $context = []) {
        self::log('security', $event, $context);
    }
    
    public static function getLogs($level = null, $limit = 100) {
        if ($level) {
            return \RedBeanPHP\R::find('system_logs', 'level = ? ORDER BY logged_at DESC LIMIT ?', [$level, $limit]);
        }
        
        return \RedBeanPHP\R::find('system_logs', 'ORDER BY logged_at DESC LIMIT ?', [$limit]);
    }
}
?>
```

## إدارة الأمان

### مراقبة محاولات الاختراق

```php
<?php
// admin/security-monitor.php
class SecurityMonitor {
    
    public static function detectBruteForce($username) {
        $attempts = \RedBeanPHP\R::count('login_attempts', 
            'username = ? AND attempted_at > ? AND success = 0', 
            [$username, date('Y-m-d H:i:s', strtotime('-15 minutes'))]
        );
        
        return $attempts >= 5;
    }
    
    public static function logLoginAttempt($username, $success, $ip) {
        $attempt = \RedBeanPHP\R::dispense('login_attempts');
        $attempt->username = $username;
        $attempt->success = $success ? 1 : 0;
        $attempt->ip_address = $ip;
        $attempt->attempted_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($attempt);
        
        if (!$success) {
            SystemLogger::logSecurity('Failed login attempt', [
                'username' => $username,
                'ip' => $ip
            ]);
        }
    }
    
    public static function blockIp($ip, $reason, $duration = '1 hour') {
        $block = \RedBeanPHP\R::dispense('ip_blocks');
        $block->ip_address = $ip;
        $block->reason = $reason;
        $block->blocked_at = date('Y-m-d H:i:s');
        $block->blocked_until = date('Y-m-d H:i:s', strtotime($duration));
        
        \RedBeanPHP\R::store($block);
        
        SystemLogger::logSecurity('IP blocked', [
            'ip' => $ip,
            'reason' => $reason
        ]);
    }
    
    public static function isIpBlocked($ip) {
        return \RedBeanPHP\R::count('ip_blocks', 
            'ip_address = ? AND blocked_until > ?', 
            [$ip, date('Y-m-d H:i:s')]
        ) > 0;
    }
}
?>
```

### تحديث كلمات المرور

```php
<?php
// admin/password-policy.php
class PasswordPolicy {
    
    public static function enforcePasswordReset() {
        $users = \RedBeanPHP\R::find('users', 'password_updated < ?', [
            date('Y-m-d H:i:s', strtotime('-90 days'))
        ]);
        
        foreach ($users as $user) {
            $user->force_password_reset = 1;
            \RedBeanPHP\R::store($user);
            
            // إرسال إشعار للمستخدم
            self::sendPasswordResetNotification($user);
        }
        
        return count($users);
    }
    
    public static function validatePassword($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'كلمة المرور يجب أن تكون 8 أحرف على الأقل';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'كلمة المرور يجب أن تحتوي على حرف كبير واحد على الأقل';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'كلمة المرور يجب أن تحتوي على حرف صغير واحد على الأقل';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'كلمة المرور يجب أن تحتوي على رقم واحد على الأقل';
        }
        
        return $errors;
    }
    
    private static function sendPasswordResetNotification($user) {
        // إرسال بريد إلكتروني أو إشعار
    }
}
?>
```

## إدارة الملفات والتخزين

### تنظيف الملفات القديمة

```bash
#!/bin/bash
# cleanup-files.sh

UPLOAD_DIR="uploads"
DAYS_OLD=30

echo "بدء تنظيف الملفات القديمة..."

# حذف الملفات المؤقتة
find $UPLOAD_DIR/temp -type f -mtime +1 -delete

# حذف الملفات المحذوفة من قاعدة البيانات
while IFS= read -r file; do
    if [ -f "$file" ]; then
        echo "حذف الملف: $file"
        rm "$file"
    fi
done < <(php admin/get-orphaned-files.php)

# حذف مجلدات الرفع الفارغة
find $UPLOAD_DIR -type d -empty -delete

echo "انتهى تنظيف الملفات"
```

### مراقبة مساحة التخزين

```php
<?php
// admin/storage-monitor.php
class StorageMonitor {
    
    public static function getStorageStats() {
        $uploadDir = 'uploads/';
        $dbFile = 'tewiiq.db';
        
        $stats = [
            'total_files' => 0,
            'total_size' => 0,
            'db_size' => filesize($dbFile),
            'available_space' => disk_free_space('.'),
            'used_space' => disk_total_space('.') - disk_free_space('.')
        ];
        
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadDir));
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $stats['total_files']++;
                $stats['total_size'] += $file->getSize();
            }
        }
        
        return $stats;
    }
    
    public static function cleanupOrphanedFiles() {
        $uploadDir = 'uploads/';
        $deletedCount = 0;
        
        // الحصول على قائمة الملفات المستخدمة في قاعدة البيانات
        $usedFiles = [];
        
        $tweets = \RedBeanPHP\R::find('tweets', 'media IS NOT NULL');
        foreach ($tweets as $tweet) {
            $media = json_decode($tweet->media, true);
            if ($media) {
                foreach ($media as $file) {
                    $usedFiles[] = $file['path'];
                }
            }
        }
        
        $users = \RedBeanPHP\R::find('users', 'avatar IS NOT NULL OR cover IS NOT NULL');
        foreach ($users as $user) {
            if ($user->avatar) $usedFiles[] = $user->avatar;
            if ($user->cover) $usedFiles[] = $user->cover;
        }
        
        // فحص الملفات الموجودة في مجلد الرفع
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadDir));
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace($uploadDir, '', $file->getPathname());
                
                if (!in_array($relativePath, $usedFiles)) {
                    unlink($file->getPathname());
                    $deletedCount++;
                }
            }
        }
        
        return $deletedCount;
    }
}
?>
```

## أتمتة المهام

### إعداد Cron Jobs

```bash
# crontab -e
# إضافة المهام التالية:

# تنظيف قاعدة البيانات يومياً في الساعة 1:00 صباحاً
0 1 * * * /usr/bin/php /path/to/tewiiq/admin/optimize-db.php

# نسخة احتياطية يومية في الساعة 2:00 صباحاً
0 2 * * * /path/to/tewiiq/backup-db.sh

# تنظيف الملفات أسبوعياً
0 3 * * 0 /path/to/tewiiq/cleanup-files.sh

# مراقبة الأداء كل 15 دقيقة
*/15 * * * * /usr/bin/php /path/to/tewiiq/admin/performance-monitor.php

# فرض إعادة تعيين كلمات المرور شهرياً
0 0 1 * * /usr/bin/php /path/to/tewiiq/admin/password-policy.php
```

### سكريبت الصيانة الشامل

```bash
#!/bin/bash
# maintenance.sh

echo "بدء الصيانة الشاملة..."

# إيقاف الخدمات
systemctl stop apache2

# تحسين قاعدة البيانات
php admin/optimize-db.php

# تنظيف الملفات
./cleanup-files.sh

# إنشاء نسخة احتياطية
./backup-db.sh

# تحديث الصلاحيات
chown -R www-data:www-data .
chmod -R 755 .
chmod 666 tewiiq.db
chmod -R 777 uploads/

# إعادة تشغيل الخدمات
systemctl start apache2

echo "انتهت الصيانة الشاملة"
```

## التحديثات والتطوير

### نشر التحديثات

```bash
#!/bin/bash
# deploy-update.sh

VERSION=$1

if [ -z "$VERSION" ]; then
    echo "الاستخدام: $0 <version>"
    exit 1
fi

echo "نشر الإصدار: $VERSION"

# نسخة احتياطية
./backup-db.sh

# إيقاف الخدمات
systemctl stop apache2

# تحديث الكود
git fetch
git checkout $VERSION

# تحديث التبعيات
composer install --no-dev --optimize-autoloader

# تشغيل migrations إذا كانت موجودة
if [ -f "admin/migrate.php" ]; then
    php admin/migrate.php
fi

# إعادة تشغيل الخدمات
systemctl start apache2

echo "تم نشر الإصدار $VERSION بنجاح"
```

### اختبار النظام

```php
<?php
// admin/system-test.php
class SystemTest {
    
    public static function runAllTests() {
        $results = [
            'database' => self::testDatabase(),
            'uploads' => self::testUploads(),
            'permissions' => self::testPermissions(),
            'security' => self::testSecurity()
        ];
        
        return $results;
    }
    
    private static function testDatabase() {
        try {
            Database::init();
            $testUser = \RedBeanPHP\R::dispense('users');
            $testUser->username = 'test_' . uniqid();
            $id = \RedBeanPHP\R::store($testUser);
            \RedBeanPHP\R::trash($testUser);
            
            return ['status' => 'pass', 'message' => 'قاعدة البيانات تعمل'];
        } catch (Exception $e) {
            return ['status' => 'fail', 'message' => $e->getMessage()];
        }
    }
    
    private static function testUploads() {
        $uploadDir = 'uploads/';
        
        if (!is_writable($uploadDir)) {
            return ['status' => 'fail', 'message' => 'مجلد الرفع غير قابل للكتابة'];
        }
        
        return ['status' => 'pass', 'message' => 'مجلد الرفع يعمل'];
    }
    
    private static function testPermissions() {
        $files = ['tewiiq.db', 'uploads/', '.env'];
        $issues = [];
        
        foreach ($files as $file) {
            if (!file_exists($file)) {
                $issues[] = "الملف غير موجود: $file";
            } elseif (!is_readable($file)) {
                $issues[] = "لا يمكن قراءة: $file";
            }
        }
        
        if (empty($issues)) {
            return ['status' => 'pass', 'message' => 'الصلاحيات صحيحة'];
        } else {
            return ['status' => 'fail', 'message' => implode(', ', $issues)];
        }
    }
    
    private static function testSecurity() {
        $issues = [];
        
        // فحص ملف .env
        if (is_readable('.env') && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $issues[] = 'ملف .env قابل للقراءة من المتصفح';
        }
        
        // فحص قاعدة البيانات
        if (is_readable('tewiiq.db') && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $issues[] = 'قاعدة البيانات قابلة للتنزيل من المتصفح';
        }
        
        if (empty($issues)) {
            return ['status' => 'pass', 'message' => 'الأمان جيد'];
        } else {
            return ['status' => 'fail', 'message' => implode(', ', $issues)];
        }
    }
}
?>
```

---

هذا الدليل يغطي الجوانب الأساسية لإدارة منصة تويق. يُنصح بمراجعة وتحديث هذه الإجراءات بانتظام حسب احتياجات النظام والتطورات الأمنية.