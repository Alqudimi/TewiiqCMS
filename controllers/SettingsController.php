<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserSettings.php';

class SettingsController 
{
    private $templates;
    
    public function __construct() 
    {
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views');
    }
    
    public function index() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $user = User::findById($_SESSION['user_id']);
        $settings = UserSettings::getSettings($_SESSION['user_id']);
        
        echo $this->templates->render('pages/settings', [
            'user' => $user,
            'settings' => $settings,
            'title' => 'الإعدادات والخصوصية'
        ]);
    }
    
    public function updateProfile() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $data = [
            'fullname' => trim($_POST['fullname'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'bio' => trim($_POST['bio'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'website' => trim($_POST['website'] ?? ''),
        ];
        
        // Validate required fields
        if (empty($data['fullname']) || empty($data['username']) || empty($data['email'])) {
            $_SESSION['error'] = 'الاسم واسم المستخدم والبريد الإلكتروني مطلوبة';
            header('Location: /settings');
            exit;
        }
        
        // Check if username is already taken
        $existingUser = User::findByUsername($data['username']);
        if ($existingUser && $existingUser->id != $_SESSION['user_id']) {
            $_SESSION['error'] = 'اسم المستخدم مستخدم بالفعل';
            header('Location: /settings');
            exit;
        }
        
        // Check if email is already taken
        $existingEmail = User::findByEmail($data['email']);
        if ($existingEmail && $existingEmail->id != $_SESSION['user_id']) {
            $_SESSION['error'] = 'البريد الإلكتروني مستخدم بالفعل';
            header('Location: /settings');
            exit;
        }
        
        try {
            User::update($_SESSION['user_id'], $data);
            $_SESSION['success'] = 'تم تحديث الملف الشخصي بنجاح';
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء التحديث';
        }
        
        header('Location: /settings');
        exit;
    }
    
    public function updatePassword() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'جميع كلمات المرور مطلوبة';
            header('Location: /settings');
            exit;
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'كلمة المرور الجديدة وتأكيدها غير متطابقين';
            header('Location: /settings');
            exit;
        }
        
        if (strlen($newPassword) < 6) {
            $_SESSION['error'] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
            header('Location: /settings');
            exit;
        }
        
        // Verify current password
        $user = User::findById($_SESSION['user_id']);
        if (!password_verify($currentPassword, $user->password)) {
            $_SESSION['error'] = 'كلمة المرور الحالية غير صحيحة';
            header('Location: /settings');
            exit;
        }
        
        try {
            User::update($_SESSION['user_id'], ['password' => $newPassword]);
            $_SESSION['success'] = 'تم تغيير كلمة المرور بنجاح';
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء تغيير كلمة المرور';
        }
        
        header('Location: /settings');
        exit;
    }
    
    public function updatePrivacy() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $data = [
            'profile_visibility' => $_POST['profile_visibility'] ?? 'public',
            'tweet_privacy' => $_POST['tweet_privacy'] ?? 'public',
            'message_privacy' => $_POST['message_privacy'] ?? 'everyone',
            'tagging_permission' => $_POST['tagging_permission'] ?? 'everyone',
            'location_sharing' => isset($_POST['location_sharing']) ? 1 : 0,
            'photo_tagging' => isset($_POST['photo_tagging']) ? 1 : 0,
            'search_by_email' => isset($_POST['search_by_email']) ? 1 : 0,
            'search_by_phone' => isset($_POST['search_by_phone']) ? 1 : 0,
        ];
        
        try {
            UserSettings::updateSettings($_SESSION['user_id'], $data);
            $_SESSION['success'] = 'تم تحديث إعدادات الخصوصية بنجاح';
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء التحديث';
        }
        
        header('Location: /settings');
        exit;
    }
    
    public function updateNotifications() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $data = [
            'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0,
            'push_notifications' => isset($_POST['push_notifications']) ? 1 : 0,
            'sms_notifications' => isset($_POST['sms_notifications']) ? 1 : 0,
            'like_notifications' => isset($_POST['like_notifications']) ? 1 : 0,
            'reply_notifications' => isset($_POST['reply_notifications']) ? 1 : 0,
            'follow_notifications' => isset($_POST['follow_notifications']) ? 1 : 0,
            'mention_notifications' => isset($_POST['mention_notifications']) ? 1 : 0,
            'retweet_notifications' => isset($_POST['retweet_notifications']) ? 1 : 0,
            'message_notifications' => isset($_POST['message_notifications']) ? 1 : 0,
        ];
        
        try {
            UserSettings::updateSettings($_SESSION['user_id'], $data);
            $_SESSION['success'] = 'تم تحديث إعدادات الإشعارات بنجاح';
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء التحديث';
        }
        
        header('Location: /settings');
        exit;
    }
    
    public function updateAppearance() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $data = [
            'theme' => $_POST['theme'] ?? 'light',
            'font_size' => $_POST['font_size'] ?? 'medium',
            'language' => $_POST['language'] ?? 'ar',
            'timezone' => $_POST['timezone'] ?? 'Asia/Riyadh',
            'autoplay_videos' => isset($_POST['autoplay_videos']) ? 1 : 0,
            'data_saver' => isset($_POST['data_saver']) ? 1 : 0,
            'high_quality_images' => isset($_POST['high_quality_images']) ? 1 : 0,
        ];
        
        try {
            UserSettings::updateSettings($_SESSION['user_id'], $data);
            $_SESSION['success'] = 'تم تحديث إعدادات المظهر بنجاح';
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء التحديث';
        }
        
        header('Location: /settings');
        exit;
    }
    
    public function getSettings() 
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'غير مصرح']);
            return;
        }
        
        $section = $_GET['section'] ?? 'all';
        
        try {
            switch ($section) {
                case 'privacy':
                    $settings = UserSettings::getPrivacySettings($_SESSION['user_id']);
                    break;
                case 'notifications':
                    $settings = UserSettings::getNotificationSettings($_SESSION['user_id']);
                    break;
                case 'appearance':
                    $settings = UserSettings::getAppearanceSettings($_SESSION['user_id']);
                    break;
                default:
                    $settings = UserSettings::getSettings($_SESSION['user_id']);
                    break;
            }
            
            echo json_encode($settings);
        } catch (Exception $e) {
            echo json_encode(['error' => 'حدث خطأ']);
        }
    }
}