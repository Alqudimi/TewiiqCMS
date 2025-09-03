<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Tweet.php';

echo "بدء إضافة البيانات التجريبية...\n";

try {
    Database::init();
    
    // Create sample users
    $users = [
        [
            'username' => 'ahmed_dev',
            'email' => 'ahmed@example.com',
            'password' => 'password123',
            'fullname' => 'أحمد محمد',
            'bio' => 'مطور تطبيقات ويب ومحب للتكنولوجيا 💻 | أشارك أفكاري حول البرمجة والتطوير'
        ],
        [
            'username' => 'sara_tech',
            'email' => 'sara@example.com',
            'password' => 'password123',
            'fullname' => 'سارة أحمد',
            'bio' => 'مهندسة برمجيات | خبيرة في الذكاء الاصطناعي 🤖'
        ],
        [
            'username' => 'omar_design',
            'email' => 'omar@example.com',
            'password' => 'password123',
            'fullname' => 'عمر خالد',
            'bio' => 'مصمم واجهات المستخدم | UX/UI Designer 🎨'
        ]
    ];
    
    $userIds = [];
    foreach ($users as $userData) {
        if (!User::findByUsername($userData['username'])) {
            $userId = User::create($userData);
            $userIds[] = $userId;
            echo "تم إنشاء المستخدم: {$userData['fullname']}\n";
        } else {
            $existingUser = User::findByUsername($userData['username']);
            $userIds[] = $existingUser->id;
            echo "المستخدم موجود بالفعل: {$userData['fullname']}\n";
        }
    }
    
    // Create sample tweets
    $tweets = [
        [
            'user_id' => $userIds[0],
            'content' => 'مرحباً بكم في Tewiiq! 🎉 منصة التواصل الاجتماعي العربية الجديدة. نحن متحمسون لرؤية مشاركاتكم!'
        ],
        [
            'user_id' => $userIds[1],
            'content' => 'البرمجة ليست مجرد كتابة كود، بل هي فن وعلم في نفس الوقت. كل مشكلة لها حل إبداعي! 💡'
        ],
        [
            'user_id' => $userIds[2],
            'content' => 'التصميم الجيد يجعل التكنولوجيا غير مرئية. المستخدم يجب أن يركز على المحتوى وليس على الواجهة 🎨'
        ],
        [
            'user_id' => $userIds[0],
            'content' => 'تعلمت اليوم مفهوماً جديداً في PHP. RedBeanPHP مكتبة رائعة لإدارة قواعد البيانات! 📚'
        ],
        [
            'user_id' => $userIds[1],
            'content' => 'الذكاء الاصطناعي يتطور بسرعة مذهلة. ما رأيكم في تأثيره على مستقبل البرمجة؟ 🤔'
        ]
    ];
    
    foreach ($tweets as $tweetData) {
        Tweet::create($tweetData);
        echo "تم إنشاء تغريدة جديدة\n";
    }
    
    // Add some follows
    if (count($userIds) >= 3) {
        User::follow($userIds[0], $userIds[1]);
        User::follow($userIds[0], $userIds[2]);
        User::follow($userIds[1], $userIds[0]);
        User::follow($userIds[2], $userIds[0]);
        echo "تم إضافة علاقات المتابعة\n";
    }
    
    echo "تم الانتهاء من إضافة البيانات التجريبية بنجاح! ✅\n";
    echo "\nيمكنك الآن تسجيل الدخول باستخدام:\n";
    echo "اسم المستخدم: ahmed_dev\n";
    echo "كلمة المرور: password123\n";
    
} catch (Exception $e) {
    echo "خطأ: " . $e->getMessage() . "\n";
}