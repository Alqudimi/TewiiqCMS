# دليل المطورين - منصة تويق

## مقدمة

هذا الدليل مخصص للمطورين الذين يرغبون في المساهمة في تطوير منصة تويق أو بناء تطبيقات تتكامل معها. يغطي البنية التقنية، الـ APIs، وأفضل الممارسات في التطوير.

## البنية التقنية

### هيكل المشروع

```
tewiiq/
├── public/                 # نقطة الدخول العامة
│   ├── index.php          # الراوتر الرئيسي
│   ├── assets/            # الملفات الثابتة (CSS, JS, Images)
│   └── uploads/           # الملفات المرفوعة
├── controllers/           # تحكم في المنطق
├── views/                 # قوالب العرض
│   ├── layouts/          # قوالب التخطيط
│   ├── pages/            # صفحات المحتوى
│   └── components/       # مكونات قابلة للإعادة الاستخدام
├── models/               # نماذج البيانات
├── database/             # إعداد قاعدة البيانات
├── vendor/               # مكتبات Composer
├── docs/                 # الوثائق
├── admin/                # أدوات الإدارة
├── api/                  # واجهات برمجة التطبيقات
├── config/               # ملفات الإعداد
├── storage/              # ملفات التخزين المؤقت والسجلات
├── tests/                # اختبارات الكود
├── .env                  # متغيرات البيئة
├── composer.json         # تبعيات PHP
└── README.md            # معلومات المشروع
```

### التقنيات المستخدمة

#### Backend
- **PHP 8.2+**: لغة البرمجة الأساسية
- **RedBean ORM**: للتعامل مع قاعدة البيانات
- **League Plates**: محرك القوالب
- **Composer**: إدارة التبعيات
- **SQLite**: قاعدة البيانات الافتراضية

#### Frontend
- **Bootstrap 5.3**: إطار عمل CSS
- **Bootstrap Icons**: مكتبة الأيقونات
- **Font Awesome**: أيقونات إضافية
- **Google Fonts**: خطوط عربية (Tajawal, Cairo)
- **Vanilla JavaScript**: للتفاعلات

## إعداد بيئة التطوير

### المتطلبات

```bash
# تثبيت PHP وامتداداته
sudo apt-get install php8.2 php8.2-cli php8.2-common \
    php8.2-curl php8.2-gd php8.2-json php8.2-mbstring \
    php8.2-sqlite3 php8.2-xml php8.2-zip

# تثبيت Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# تثبيت Git
sudo apt-get install git
```

### استنساخ المشروع

```bash
# استنساخ المشروع
git clone https://github.com/your-username/tewiiq.git
cd tewiiq

# تثبيت التبعيات
composer install

# إعداد البيئة
cp .env.example .env.dev
```

### إعداد ملف البيئة للتطوير

```env
# .env.dev
APP_NAME="تويق - تطوير"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:5000

# قاعدة البيانات
DB_CONNECTION=sqlite
DB_DATABASE=./tewiiq_dev.db

# إعدادات التطوير
CACHE_ENABLED=false
LOG_LEVEL=debug
ERROR_REPORTING=true

# إعدادات البريد للاختبار
MAIL_MAILER=log
```

### تشغيل بيئة التطوير

```bash
# تشغيل الخادم المحلي
php -S localhost:5000 -t public/

# أو باستخدام خادم مخصص
./dev-server.sh
```

## معمارية التطبيق

### نمط MVC

#### Controllers (المتحكمات)
```php
<?php
// مثال: controllers/ExampleController.php
class ExampleController {
    private $templates;

    public function __construct($templates = null) {
        $this->templates = $templates ?: new \League\Plates\Engine(__DIR__ . '/../views');
    }

    public function index() {
        // منطق العمل
        $data = $this->getData();
        
        // عرض القالب
        echo $this->templates->render('pages/example', [
            'title' => 'صفحة المثال',
            'data' => $data
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // معالجة البيانات
            $this->handleCreate();
            
            // إعادة توجيه
            header('Location: /example');
            exit;
        }
        
        // عرض نموذج الإنشاء
        echo $this->templates->render('pages/example-create');
    }

    private function getData() {
        // استعلام قاعدة البيانات
        return \RedBeanPHP\R::findAll('examples');
    }

    private function handleCreate() {
        // تحقق من البيانات
        $this->validateInput();
        
        // حفظ في قاعدة البيانات
        $example = \RedBeanPHP\R::dispense('examples');
        $example->title = $_POST['title'];
        $example->content = $_POST['content'];
        $example->created_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($example);
    }

    private function validateInput() {
        if (empty($_POST['title'])) {
            throw new InvalidArgumentException('العنوان مطلوب');
        }
        
        if (strlen($_POST['title']) > 100) {
            throw new InvalidArgumentException('العنوان طويل جداً');
        }
    }
}
?>
```

#### Models (النماذج)
```php
<?php
// models/Tweet.php
class Tweet {
    
    public static function create($userId, $content, $media = null) {
        // التحقق من البيانات
        self::validateTweet($content);
        
        // إنشاء التغريدة
        $tweet = \RedBeanPHP\R::dispense('tweets');
        $tweet->user_id = $userId;
        $tweet->content = $content;
        $tweet->media = $media ? json_encode($media) : null;
        $tweet->created_at = date('Y-m-d H:i:s');
        $tweet->likes_count = 0;
        $tweet->replies_count = 0;
        $tweet->retweets_count = 0;
        
        return \RedBeanPHP\R::store($tweet);
    }
    
    public static function findById($id) {
        return \RedBeanPHP\R::load('tweets', $id);
    }
    
    public static function getTimeline($userId, $limit = 20, $offset = 0) {
        // الحصول على تغريدات المستخدمين المتابعين
        $following = \RedBeanPHP\R::find('follows', 'follower_id = ?', [$userId]);
        $followingIds = array_column($following, 'following_id');
        $followingIds[] = $userId; // إضافة المستخدم نفسه
        
        $placeholders = str_repeat('?,', count($followingIds) - 1) . '?';
        
        return \RedBeanPHP\R::find('tweets', 
            "user_id IN ($placeholders) AND deleted_at IS NULL 
             ORDER BY created_at DESC LIMIT ? OFFSET ?", 
            array_merge($followingIds, [$limit, $offset])
        );
    }
    
    public static function like($tweetId, $userId) {
        // التحقق من وجود الإعجاب
        $existingLike = \RedBeanPHP\R::findOne('likes', 
            'tweet_id = ? AND user_id = ?', [$tweetId, $userId]
        );
        
        if ($existingLike) {
            // إزالة الإعجاب
            \RedBeanPHP\R::trash($existingLike);
            
            // تقليل العداد
            \RedBeanPHP\R::exec('UPDATE tweets SET likes_count = likes_count - 1 WHERE id = ?', [$tweetId]);
            
            return false;
        } else {
            // إضافة الإعجاب
            $like = \RedBeanPHP\R::dispense('likes');
            $like->tweet_id = $tweetId;
            $like->user_id = $userId;
            $like->created_at = date('Y-m-d H:i:s');
            
            \RedBeanPHP\R::store($like);
            
            // زيادة العداد
            \RedBeanPHP\R::exec('UPDATE tweets SET likes_count = likes_count + 1 WHERE id = ?', [$tweetId]);
            
            return true;
        }
    }
    
    public static function reply($tweetId, $userId, $content) {
        // إنشاء الرد
        $reply = \RedBeanPHP\R::dispense('replies');
        $reply->tweet_id = $tweetId;
        $reply->user_id = $userId;
        $reply->content = $content;
        $reply->created_at = date('Y-m-d H:i:s');
        
        $replyId = \RedBeanPHP\R::store($reply);
        
        // زيادة عداد الردود
        \RedBeanPHP\R::exec('UPDATE tweets SET replies_count = replies_count + 1 WHERE id = ?', [$tweetId]);
        
        return $replyId;
    }
    
    private static function validateTweet($content) {
        if (empty(trim($content))) {
            throw new InvalidArgumentException('محتوى التغريدة مطلوب');
        }
        
        if (strlen($content) > 280) {
            throw new InvalidArgumentException('التغريدة طويلة جداً (الحد الأقصى 280 حرف)');
        }
    }
}
?>
```

#### Views (القوالب)
```php
<?php 
// views/pages/tweet-detail.php
$this->layout('layouts/app', [
    'title' => 'تفاصيل التغريدة - تويق',
    'currentPage' => 'tweet'
]) 
?>

<div class="tweet-detail-container">
    <!-- التغريدة الأساسية -->
    <div class="tweet-card main-tweet">
        <div class="tweet-header">
            <img src="<?= $tweet->user->avatar ?: '/assets/images/default-avatar.png' ?>" 
                 alt="<?= htmlspecialchars($tweet->user->fullname) ?>" 
                 class="user-avatar">
            <div class="user-info">
                <h4 class="user-name"><?= htmlspecialchars($tweet->user->fullname) ?></h4>
                <span class="username">@<?= htmlspecialchars($tweet->user->username) ?></span>
                <span class="tweet-time"><?= $this->formatTime($tweet->created_at) ?></span>
            </div>
        </div>
        
        <div class="tweet-content">
            <p><?= $this->formatTweetContent($tweet->content) ?></p>
            
            <?php if ($tweet->media): ?>
                <div class="tweet-media">
                    <?php $media = json_decode($tweet->media, true); ?>
                    <?php foreach ($media as $file): ?>
                        <?php if (in_array($file['type'], ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <img src="<?= $file['url'] ?>" alt="صورة التغريدة" class="tweet-image">
                        <?php elseif (in_array($file['type'], ['mp4', 'mov', 'avi'])): ?>
                            <video controls class="tweet-video">
                                <source src="<?= $file['url'] ?>" type="video/<?= $file['type'] ?>">
                                متصفحك لا يدعم عرض الفيديو.
                            </video>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="tweet-actions">
            <button class="action-btn like-btn <?= $isLiked ? 'liked' : '' ?>" 
                    onclick="toggleLike(<?= $tweet->id ?>)">
                <i class="bi bi-heart<?= $isLiked ? '-fill' : '' ?>"></i>
                <span class="count"><?= $tweet->likes_count ?></span>
            </button>
            
            <button class="action-btn reply-btn" onclick="openReplyModal()">
                <i class="bi bi-chat"></i>
                <span class="count"><?= $tweet->replies_count ?></span>
            </button>
            
            <button class="action-btn retweet-btn" onclick="retweet(<?= $tweet->id ?>)">
                <i class="bi bi-arrow-repeat"></i>
                <span class="count"><?= $tweet->retweets_count ?></span>
            </button>
            
            <button class="action-btn share-btn" onclick="shareTweet(<?= $tweet->id ?>)">
                <i class="bi bi-share"></i>
            </button>
        </div>
    </div>
    
    <!-- نموذج الرد -->
    <?php if ($isLoggedIn): ?>
        <div class="reply-form">
            <form action="/tweet/<?= $tweet->id ?>/reply" method="POST">
                <div class="reply-input">
                    <img src="<?= $currentUser->avatar ?: '/assets/images/default-avatar.png' ?>" 
                         alt="صورتك" class="user-avatar small">
                    <textarea name="content" placeholder="اكتب ردك..." maxlength="280" required></textarea>
                </div>
                <div class="reply-actions">
                    <span class="char-count">280</span>
                    <button type="submit" class="btn btn-primary">رد</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
    
    <!-- الردود -->
    <div class="replies-section">
        <h3>الردود (<?= count($replies) ?>)</h3>
        
        <?php foreach ($replies as $reply): ?>
            <div class="reply-card">
                <div class="reply-header">
                    <img src="<?= $reply->user->avatar ?: '/assets/images/default-avatar.png' ?>" 
                         alt="<?= htmlspecialchars($reply->user->fullname) ?>" 
                         class="user-avatar small">
                    <div class="user-info">
                        <h5 class="user-name"><?= htmlspecialchars($reply->user->fullname) ?></h5>
                        <span class="username">@<?= htmlspecialchars($reply->user->username) ?></span>
                        <span class="reply-time"><?= $this->formatTime($reply->created_at) ?></span>
                    </div>
                </div>
                
                <div class="reply-content">
                    <p><?= $this->formatTweetContent($reply->content) ?></p>
                </div>
                
                <div class="reply-actions">
                    <button class="action-btn like-btn" onclick="likeReply(<?= $reply->id ?>)">
                        <i class="bi bi-heart"></i>
                        <span class="count"><?= $reply->likes_count ?></span>
                    </button>
                    
                    <button class="action-btn reply-btn" onclick="replyToReply(<?= $reply->id ?>)">
                        <i class="bi bi-chat"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($replies)): ?>
            <div class="no-replies">
                <p>لا توجد ردود بعد. كن أول من يرد!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// JavaScript للتفاعلات
function toggleLike(tweetId) {
    fetch('/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ tweet_id: tweetId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const likeBtn = document.querySelector('.like-btn');
            const icon = likeBtn.querySelector('i');
            const count = likeBtn.querySelector('.count');
            
            if (data.liked) {
                likeBtn.classList.add('liked');
                icon.className = 'bi bi-heart-fill';
            } else {
                likeBtn.classList.remove('liked');
                icon.className = 'bi bi-heart';
            }
            
            count.textContent = data.likes_count;
        }
    })
    .catch(error => console.error('خطأ:', error));
}

function openReplyModal() {
    document.querySelector('.reply-form textarea').focus();
}

// تحديث عداد الأحرف
document.querySelector('.reply-form textarea').addEventListener('input', function() {
    const remaining = 280 - this.value.length;
    document.querySelector('.char-count').textContent = remaining;
    
    if (remaining < 0) {
        this.classList.add('exceeded');
    } else {
        this.classList.remove('exceeded');
    }
});
</script>
```

### الراوتر (Router)

```php
<?php
// public/index.php - نظام التوجيه

class Router {
    private $routes = [];
    
    public function addRoute($method, $pattern, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function dispatch($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method || $route['method'] === 'ANY') {
                if (preg_match($route['pattern'], $uri, $matches)) {
                    $controllerName = $route['controller'];
                    $actionName = $route['action'];
                    
                    $controller = new $controllerName();
                    
                    // تمرير المعاملات المستخرجة من URL
                    $params = array_slice($matches, 1);
                    
                    return call_user_func_array([$controller, $actionName], $params);
                }
            }
        }
        
        // 404 - الصفحة غير موجودة
        http_response_code(404);
        include '404.php';
    }
}

// تعريف الراوتس
$router = new Router();

// راوتس الصفحات الأساسية
$router->addRoute('GET', '/^\/$/i', 'HomeController', 'index');
$router->addRoute('GET', '/^\/about$/i', 'AboutController', 'index');
$router->addRoute('GET', '/^\/help$/i', 'HelpController', 'index');

// راوتس المصادقة
$router->addRoute('GET', '/^\/login$/i', 'AuthController', 'showLogin');
$router->addRoute('POST', '/^\/login$/i', 'AuthController', 'login');
$router->addRoute('GET', '/^\/register$/i', 'AuthController', 'showRegister');
$router->addRoute('POST', '/^\/register$/i', 'AuthController', 'register');
$router->addRoute('ANY', '/^\/logout$/i', 'AuthController', 'logout');

// راوتس التغريدات
$router->addRoute('POST', '/^\/tweet$/i', 'TweetController', 'create');
$router->addRoute('GET', '/^\/tweet\/(\d+)$/i', 'TweetController', 'show');
$router->addRoute('POST', '/^\/tweet\/(\d+)\/like$/i', 'TweetController', 'like');
$router->addRoute('POST', '/^\/tweet\/(\d+)\/reply$/i', 'TweetController', 'reply');

// راوتس المستخدمين
$router->addRoute('GET', '/^\/profile\/([a-zA-Z0-9_]+)$/i', 'ProfileController', 'show');
$router->addRoute('POST', '/^\/follow$/i', 'ProfileController', 'follow');
$router->addRoute('POST', '/^\/unfollow$/i', 'ProfileController', 'unfollow');

// راوتس API
$router->addRoute('GET', '/^\/api\/users\/search$/i', 'ApiController', 'searchUsers');
$router->addRoute('GET', '/^\/api\/tweets\/timeline$/i', 'ApiController', 'getTimeline');

// تشغيل الراوتر
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
?>
```

## واجهات برمجة التطبيقات (APIs)

### API للمطورين الخارجيين

```php
<?php
// api/v1/TweetAPI.php
class TweetAPI {
    
    private function authenticate() {
        $headers = getallheaders();
        $apiKey = $headers['Authorization'] ?? '';
        
        if (!$apiKey || !$this->isValidApiKey($apiKey)) {
            http_response_code(401);
            echo json_encode(['error' => 'مطلوب مفتاح API صالح']);
            exit;
        }
        
        return $this->getUserByApiKey($apiKey);
    }
    
    public function create() {
        $user = $this->authenticate();
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'محتوى التغريدة مطلوب']);
            return;
        }
        
        try {
            $tweetId = Tweet::create($user->id, $input['content'], $input['media'] ?? null);
            
            echo json_encode([
                'success' => true,
                'tweet_id' => $tweetId,
                'message' => 'تم إنشاء التغريدة بنجاح'
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    
    public function get($tweetId) {
        $tweet = Tweet::findById($tweetId);
        
        if (!$tweet->id) {
            http_response_code(404);
            echo json_encode(['error' => 'التغريدة غير موجودة']);
            return;
        }
        
        echo json_encode([
            'id' => $tweet->id,
            'content' => $tweet->content,
            'author' => [
                'id' => $tweet->user->id,
                'username' => $tweet->user->username,
                'fullname' => $tweet->user->fullname,
                'avatar' => $tweet->user->avatar
            ],
            'created_at' => $tweet->created_at,
            'likes_count' => $tweet->likes_count,
            'replies_count' => $tweet->replies_count,
            'retweets_count' => $tweet->retweets_count
        ]);
    }
    
    public function getTimeline() {
        $user = $this->authenticate();
        
        $page = $_GET['page'] ?? 1;
        $limit = min($_GET['limit'] ?? 20, 100); // حد أقصى 100 تغريدة
        $offset = ($page - 1) * $limit;
        
        $tweets = Tweet::getTimeline($user->id, $limit, $offset);
        
        $result = [];
        foreach ($tweets as $tweet) {
            $result[] = [
                'id' => $tweet->id,
                'content' => $tweet->content,
                'author' => [
                    'id' => $tweet->user->id,
                    'username' => $tweet->user->username,
                    'fullname' => $tweet->user->fullname,
                    'avatar' => $tweet->user->avatar
                ],
                'created_at' => $tweet->created_at,
                'likes_count' => $tweet->likes_count,
                'replies_count' => $tweet->replies_count,
                'retweets_count' => $tweet->retweets_count
            ];
        }
        
        echo json_encode([
            'tweets' => $result,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'has_more' => count($tweets) === $limit
            ]
        ]);
    }
    
    private function isValidApiKey($apiKey) {
        return \RedBeanPHP\R::count('api_keys', 'key = ? AND active = 1', [$apiKey]) > 0;
    }
    
    private function getUserByApiKey($apiKey) {
        $apiKeyRecord = \RedBeanPHP\R::findOne('api_keys', 'key = ?', [$apiKey]);
        return \RedBeanPHP\R::load('users', $apiKeyRecord->user_id);
    }
}
?>
```

### إنشاء مفاتيح API

```php
<?php
// admin/api-management.php
class APIManagement {
    
    public static function generateApiKey($userId, $name, $permissions = []) {
        $apiKey = \RedBeanPHP\R::dispense('api_keys');
        $apiKey->user_id = $userId;
        $apiKey->name = $name;
        $apiKey->key = bin2hex(random_bytes(32));
        $apiKey->permissions = json_encode($permissions);
        $apiKey->active = 1;
        $apiKey->created_at = date('Y-m-d H:i:s');
        $apiKey->last_used = null;
        
        return \RedBeanPHP\R::store($apiKey);
    }
    
    public static function revokeApiKey($keyId) {
        $apiKey = \RedBeanPHP\R::load('api_keys', $keyId);
        $apiKey->active = 0;
        $apiKey->revoked_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($apiKey);
    }
    
    public static function logApiUsage($apiKey, $endpoint, $method) {
        $usage = \RedBeanPHP\R::dispense('api_usage');
        $usage->api_key_id = $apiKey->id;
        $usage->endpoint = $endpoint;
        $usage->method = $method;
        $usage->ip_address = $_SERVER['REMOTE_ADDR'];
        $usage->user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $usage->used_at = date('Y-m-d H:i:s');
        
        \RedBeanPHP\R::store($usage);
        
        // تحديث آخر استخدام
        $apiKey->last_used = date('Y-m-d H:i:s');
        \RedBeanPHP\R::store($apiKey);
    }
}
?>
```

## الاختبارات

### إعداد بيئة الاختبار

```php
<?php
// tests/TestCase.php
abstract class TestCase {
    
    protected function setUp() {
        // إعداد قاعدة بيانات الاختبار
        \RedBeanPHP\R::setup('sqlite:test.db');
        \RedBeanPHP\R::nuke(); // حذف جميع البيانات
        
        // إنشاء البيانات الأساسية للاختبار
        $this->createTestData();
    }
    
    protected function tearDown() {
        // تنظيف بعد الاختبار
        \RedBeanPHP\R::close();
        if (file_exists('test.db')) {
            unlink('test.db');
        }
    }
    
    protected function createTestData() {
        // إنشاء مستخدم للاختبار
        $user = \RedBeanPHP\R::dispense('users');
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->fullname = 'Test User';
        $user->password = password_hash('password', PASSWORD_DEFAULT);
        $user->created_at = date('Y-m-d H:i:s');
        
        $this->testUserId = \RedBeanPHP\R::store($user);
    }
    
    protected function assertJsonResponse($response, $expectedData) {
        $data = json_decode($response, true);
        $this->assertNotNull($data, 'Response should be valid JSON');
        
        foreach ($expectedData as $key => $value) {
            $this->assertEquals($value, $data[$key], "Key '$key' should match");
        }
    }
    
    protected function simulateRequest($method, $url, $data = []) {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $url;
        
        if ($method === 'POST') {
            $_POST = $data;
        } else {
            $_GET = $data;
        }
    }
}
?>
```

### اختبار الوحدة

```php
<?php
// tests/TweetTest.php
require_once 'TestCase.php';
require_once '../models/Tweet.php';

class TweetTest extends TestCase {
    
    public function testCreateTweet() {
        $content = 'هذه تغريدة تجريبية';
        
        $tweetId = Tweet::create($this->testUserId, $content);
        
        $this->assertNotNull($tweetId);
        $this->assertGreaterThan(0, $tweetId);
        
        // التحقق من حفظ التغريدة
        $tweet = Tweet::findById($tweetId);
        $this->assertEquals($content, $tweet->content);
        $this->assertEquals($this->testUserId, $tweet->user_id);
    }
    
    public function testTweetValidation() {
        $this->expectException(InvalidArgumentException::class);
        
        // محتوى فارغ
        Tweet::create($this->testUserId, '');
    }
    
    public function testTweetTooLong() {
        $this->expectException(InvalidArgumentException::class);
        
        // محتوى طويل جداً
        $longContent = str_repeat('أ', 281);
        Tweet::create($this->testUserId, $longContent);
    }
    
    public function testLikeTweet() {
        $tweetId = Tweet::create($this->testUserId, 'تغريدة للاختبار');
        
        // إعجاب بالتغريدة
        $liked = Tweet::like($tweetId, $this->testUserId);
        $this->assertTrue($liked);
        
        // إزالة الإعجاب
        $unliked = Tweet::like($tweetId, $this->testUserId);
        $this->assertFalse($unliked);
    }
    
    public function testReplyToTweet() {
        $tweetId = Tweet::create($this->testUserId, 'تغريدة أساسية');
        $replyContent = 'هذا رد على التغريدة';
        
        $replyId = Tweet::reply($tweetId, $this->testUserId, $replyContent);
        
        $this->assertNotNull($replyId);
        $this->assertGreaterThan(0, $replyId);
        
        // التحقق من زيادة عداد الردود
        $tweet = Tweet::findById($tweetId);
        $this->assertEquals(1, $tweet->replies_count);
    }
    
    public function testGetTimeline() {
        // إنشاء مستخدم آخر
        $user2 = \RedBeanPHP\R::dispense('users');
        $user2->username = 'user2';
        $user2->email = 'user2@example.com';
        $user2->fullname = 'User 2';
        $user2->password = password_hash('password', PASSWORD_DEFAULT);
        $user2Id = \RedBeanPHP\R::store($user2);
        
        // متابعة المستخدم الثاني
        $follow = \RedBeanPHP\R::dispense('follows');
        $follow->follower_id = $this->testUserId;
        $follow->following_id = $user2Id;
        \RedBeanPHP\R::store($follow);
        
        // إنشاء تغريدات
        Tweet::create($this->testUserId, 'تغريدتي');
        Tweet::create($user2Id, 'تغريدة المستخدم الثاني');
        
        // الحصول على التايملاين
        $timeline = Tweet::getTimeline($this->testUserId, 10, 0);
        
        $this->assertCount(2, $timeline);
    }
}

// تشغيل الاختبارات
$test = new TweetTest();
$test->setUp();

try {
    $test->testCreateTweet();
    echo "✅ testCreateTweet passed\n";
    
    $test->testTweetValidation();
    echo "✅ testTweetValidation passed\n";
    
    $test->testTweetTooLong();
    echo "✅ testTweetTooLong passed\n";
    
    $test->testLikeTweet();
    echo "✅ testLikeTweet passed\n";
    
    $test->testReplyToTweet();
    echo "✅ testReplyToTweet passed\n";
    
    $test->testGetTimeline();
    echo "✅ testGetTimeline passed\n";
    
    echo "\n🎉 جميع الاختبارات نجحت!\n";
    
} catch (Exception $e) {
    echo "❌ فشل الاختبار: " . $e->getMessage() . "\n";
} finally {
    $test->tearDown();
}
?>
```

### اختبار API

```php
<?php
// tests/APITest.php
class APITest extends TestCase {
    
    private $apiKey;
    
    protected function setUp() {
        parent::setUp();
        
        // إنشاء مفتاح API للاختبار
        $this->apiKey = APIManagement::generateApiKey($this->testUserId, 'Test API Key');
    }
    
    public function testCreateTweetAPI() {
        $data = [
            'content' => 'تغريدة من API'
        ];
        
        $response = $this->makeAPIRequest('POST', '/api/v1/tweets', $data);
        $responseData = json_decode($response, true);
        
        $this->assertTrue($responseData['success']);
        $this->assertArrayHasKey('tweet_id', $responseData);
    }
    
    public function testGetTimelineAPI() {
        // إنشاء بعض التغريدات
        Tweet::create($this->testUserId, 'تغريدة 1');
        Tweet::create($this->testUserId, 'تغريدة 2');
        
        $response = $this->makeAPIRequest('GET', '/api/v1/timeline?limit=10');
        $responseData = json_decode($response, true);
        
        $this->assertArrayHasKey('tweets', $responseData);
        $this->assertCount(2, $responseData['tweets']);
    }
    
    public function testUnauthorizedAccess() {
        $response = $this->makeAPIRequest('GET', '/api/v1/timeline', [], false);
        
        $this->assertEquals(401, http_response_code());
    }
    
    private function makeAPIRequest($method, $endpoint, $data = [], $authenticate = true) {
        // تجهيز headers
        $headers = [];
        if ($authenticate) {
            $apiKeyRecord = \RedBeanPHP\R::load('api_keys', $this->apiKey);
            $headers['Authorization'] = 'Bearer ' . $apiKeyRecord->key;
        }
        
        // محاكاة الطلب
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $endpoint;
        
        foreach ($headers as $key => $value) {
            $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', $key))] = $value;
        }
        
        if ($method === 'POST') {
            file_put_contents('php://input', json_encode($data));
        }
        
        // تشغيل API وإرجاع الاستجابة
        ob_start();
        include '../api/v1/index.php';
        return ob_get_clean();
    }
}
?>
```

## إرشادات المساهمة

### معايير الكود

#### تسمية المتغيرات والدوال
```php
// ✅ جيد
$userName = 'أحمد';
$userEmail = 'ahmed@example.com';

function getUserById($userId) {
    return User::find($userId);
}

// ❌ سيء
$un = 'أحمد';
$e = 'ahmed@example.com';

function get($id) {
    return User::find($id);
}
```

#### التعليقات
```php
<?php
/**
 * إنشاء تغريدة جديدة
 * 
 * @param int $userId معرف المستخدم
 * @param string $content محتوى التغريدة
 * @param array|null $media الملفات المرفقة (اختياري)
 * @return int معرف التغريدة المنشأة
 * @throws InvalidArgumentException في حالة بيانات غير صالحة
 */
public static function create($userId, $content, $media = null) {
    // التحقق من صحة البيانات
    self::validateInput($content);
    
    // إنشاء التغريدة في قاعدة البيانات
    $tweet = \RedBeanPHP\R::dispense('tweets');
    // ... باقي الكود
}
```

#### معالجة الأخطاء
```php
<?php
// ✅ معالجة صحيحة للأخطاء
try {
    $tweetId = Tweet::create($userId, $content);
    
    // تسجيل النشاط
    SystemLogger::logUserAction($userId, 'tweet_created', ['tweet_id' => $tweetId]);
    
    return $tweetId;
    
} catch (InvalidArgumentException $e) {
    // خطأ في البيانات المدخلة
    SystemLogger::logError('Invalid tweet data', [
        'user_id' => $userId,
        'error' => $e->getMessage()
    ]);
    
    throw $e;
    
} catch (Exception $e) {
    // خطأ غير متوقع
    SystemLogger::logError('Tweet creation failed', [
        'user_id' => $userId,
        'error' => $e->getMessage()
    ]);
    
    throw new RuntimeException('فشل في إنشاء التغريدة');
}
```

### Git Workflow

#### هيكل الفروع
```
main/master     - الإنتاج
develop         - التطوير الرئيسي
feature/*       - ميزات جديدة
bugfix/*        - إصلاح أخطاء
hotfix/*        - إصلاحات عاجلة
release/*       - تحضير إصدارات
```

#### رسائل Commit
```bash
# ✅ جيد
feat: إضافة ميزة الإعجاب بالتغريدات
fix: إصلاح عداد المتابعين في الملف الشخصي
docs: تحديث دليل المطورين
style: تحسين تصميم صفحة التسجيل
refactor: إعادة تنظيم كود البحث
test: إضافة اختبارات لـ API التغريدات

# ❌ سيء
تحديث
إصلاح
تعديلات مختلفة
WIP
```

#### عملية المراجعة
1. **إنشاء فرع جديد**:
   ```bash
   git checkout -b feature/new-feature-name
   ```

2. **كتابة الكود والاختبارات**
3. **التأكد من نجاح جميع الاختبارات**:
   ```bash
   php tests/run-all-tests.php
   ```

4. **إنشاء Pull Request**
5. **مراجعة الكود** من قبل مطور آخر
6. **دمج الكود** بعد الموافقة

### إرشادات الأمان

#### التحقق من المدخلات
```php
<?php
// تنظيف وتحقق من البيانات
function sanitizeInput($input, $type = 'string') {
    switch ($type) {
        case 'string':
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
            
        case 'email':
            return filter_var($input, FILTER_VALIDATE_EMAIL);
            
        case 'int':
            return filter_var($input, FILTER_VALIDATE_INT);
            
        case 'url':
            return filter_var($input, FILTER_VALIDATE_URL);
            
        default:
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

// استخدام prepared statements
$tweet = \RedBeanPHP\R::findOne('tweets', 'user_id = ? AND id = ?', [$userId, $tweetId]);
```

#### الحماية من CSRF
```php
<?php
// إنشاء رمز CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// التحقق من رمز CSRF
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// في النماذج
echo '<input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">';

// في معالجة النماذج
if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
    throw new SecurityException('رمز الأمان غير صالح');
}
```

## أدوات التطوير

### إعداد IDE

#### VS Code
```json
// .vscode/settings.json
{
    "php.validate.executablePath": "/usr/bin/php",
    "php.suggest.basic": false,
    "files.associations": {
        "*.php": "php"
    },
    "emmet.includeLanguages": {
        "php": "html"
    },
    "editor.tabSize": 4,
    "editor.insertSpaces": true
}
```

#### إضافات مفيدة
- PHP Intelephense
- Arabic Language Pack
- GitLens
- Prettier
- PHP Debug

### أدوات البناء

#### Composer Scripts
```json
{
    "scripts": {
        "test": "php tests/run-all-tests.php",
        "lint": "php -l",
        "format": "php-cs-fixer fix",
        "analyze": "phpstan analyze",
        "dev": "php -S localhost:5000 -t public/",
        "backup": "php admin/backup.php",
        "optimize": "php admin/optimize.php"
    }
}
```

#### Makefile
```makefile
# Makefile
.PHONY: install test dev deploy backup

install:
	composer install
	cp .env.example .env
	php admin/setup.php

test:
	php tests/run-all-tests.php

dev:
	php -S localhost:5000 -t public/

deploy:
	./scripts/deploy.sh

backup:
	./scripts/backup.sh

optimize:
	php admin/optimize-db.php
	php admin/cleanup-files.php
```

---

هذا الدليل يوفر أساساً قوياً للمطورين للمساهمة في تطوير منصة تويق. يُنصح بمراجعة وتحديث هذا الدليل مع تطور المشروع وإضافة ميزات جديدة.