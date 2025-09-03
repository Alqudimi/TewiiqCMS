<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/User.php';

class AuthController 
{
    private $templates;
    
    public function __construct() 
    {
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views');
    }
    
    public function showLogin() 
    {
        echo $this->templates->render('auth/login');
    }
    
    public function showRegister() 
    {
        echo $this->templates->render('auth/register');
    }
    
    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }
        
        $identifier = $_POST['identifier'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);
        
        if (empty($identifier) || empty($password)) {
            $_SESSION['error'] = 'يرجى ملء جميع الحقول المطلوبة';
            header('Location: /login');
            exit;
        }
        
        $user = User::authenticate($identifier, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['fullname'] = $user->fullname;
            
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + (86400 * 30), '/', '', false, true);
                // Here you would store the token in database for security
            }
            
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = 'بيانات الدخول غير صحيحة';
            header('Location: /login');
            exit;
        }
    }
    
    public function register() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }
        
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validation
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'اسم المستخدم مطلوب';
        } elseif (strlen($username) < 3) {
            $errors[] = 'اسم المستخدم يجب أن يكون على الأقل 3 أحرف';
        } elseif (User::findByUsername($username)) {
            $errors[] = 'اسم المستخدم مستخدم بالفعل';
        }
        
        if (empty($email)) {
            $errors[] = 'البريد الإلكتروني مطلوب';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'البريد الإلكتروني غير صحيح';
        } elseif (User::findByEmail($email)) {
            $errors[] = 'البريد الإلكتروني مستخدم بالفعل';
        }
        
        if (empty($fullname)) {
            $errors[] = 'الاسم الكامل مطلوب';
        }
        
        if (empty($password)) {
            $errors[] = 'كلمة المرور مطلوبة';
        } elseif (strlen($password) < 6) {
            $errors[] = 'كلمة المرور يجب أن تكون على الأقل 6 أحرف';
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = 'كلمة المرور وتأكيدها غير متطابقتان';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: /register');
            exit;
        }
        
        // Create user
        $userData = [
            'username' => $username,
            'email' => $email,
            'fullname' => $fullname,
            'password' => $password
        ];
        
        $userId = User::create($userData);
        
        if ($userId) {
            $_SESSION['success'] = 'تم إنشاء الحساب بنجاح، يمكنك الآن تسجيل الدخول';
            header('Location: /login');
            exit;
        } else {
            $_SESSION['error'] = 'حدث خطأ أثناء إنشاء الحساب';
            header('Location: /register');
            exit;
        }
    }
    
    public function logout() 
    {
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        header('Location: /login');
        exit;
    }
}