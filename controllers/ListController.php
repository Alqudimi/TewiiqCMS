<?php

require_once __DIR__ . '/../models/TweetList.php';
require_once __DIR__ . '/../models/User.php';

class ListController 
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
        
        // Get user's lists
        $myLists = TweetList::getByUserId($_SESSION['user_id']);
        
        // Get public lists
        $publicLists = TweetList::getPublicLists(20, 0);
        
        echo $this->templates->render('pages/lists', [
            'myLists' => $myLists,
            'publicLists' => $publicLists,
            'title' => 'القوائم والمجموعات'
        ]);
    }
    
    public function show($listId) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $list = TweetList::findById($listId);
        if (!$list->id) {
            http_response_code(404);
            echo $this->templates->render('errors/404');
            return;
        }
        
        // Check if list is private and user has access
        if ($list->is_private && $list->user_id != $_SESSION['user_id']) {
            if (!TweetList::isMember($listId, $_SESSION['user_id'])) {
                http_response_code(403);
                echo $this->templates->render('errors/403');
                return;
            }
        }
        
        // Get list members
        $members = TweetList::getMembers($listId);
        
        // Check if current user is member
        $isMember = TweetList::isMember($listId, $_SESSION['user_id']);
        
        // Get list owner
        $owner = User::findById($list->user_id);
        
        echo $this->templates->render('pages/list-detail', [
            'list' => $list,
            'members' => $members,
            'isMember' => $isMember,
            'owner' => $owner,
            'isOwner' => $list->user_id == $_SESSION['user_id'],
            'title' => $list->name
        ]);
    }
    
    public function create() 
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
            'user_id' => $_SESSION['user_id'],
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'is_private' => isset($_POST['is_private']) ? 1 : 0,
            'cover_image' => null // TODO: Handle image uploads
        ];
        
        if (empty($data['name'])) {
            $_SESSION['error'] = 'اسم القائمة مطلوب';
            header('Location: /lists');
            exit;
        }
        
        try {
            $listId = TweetList::create($data);
            $_SESSION['success'] = 'تم إنشاء القائمة بنجاح';
            header('Location: /lists/' . $listId);
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء إنشاء القائمة';
            header('Location: /lists');
        }
        
        exit;
    }
    
    public function update($listId) 
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
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'is_private' => isset($_POST['is_private']) ? 1 : 0
        ];
        
        if (empty($data['name'])) {
            $_SESSION['error'] = 'اسم القائمة مطلوب';
            header('Location: /lists/' . $listId);
            exit;
        }
        
        try {
            $success = TweetList::update($listId, $data, $_SESSION['user_id']);
            if ($success) {
                $_SESSION['success'] = 'تم تحديث القائمة بنجاح';
            } else {
                $_SESSION['error'] = 'غير مصرح لك بتحديث هذه القائمة';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء التحديث';
        }
        
        header('Location: /lists/' . $listId);
        exit;
    }
    
    public function delete($listId) 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        try {
            $success = TweetList::delete($listId, $_SESSION['user_id']);
            if ($success) {
                $_SESSION['success'] = 'تم حذف القائمة بنجاح';
            } else {
                $_SESSION['error'] = 'غير مصرح لك بحذف هذه القائمة';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء الحذف';
        }
        
        header('Location: /lists');
        exit;
    }
    
    public function join($listId) 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'غير مسجل الدخول']);
            return;
        }
        
        try {
            $success = TweetList::addMember($listId, $_SESSION['user_id']);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'تم الانضمام للقائمة']);
            } else {
                echo json_encode(['success' => false, 'message' => 'أنت عضو بالفعل']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function leave($listId) 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'غير مسجل الدخول']);
            return;
        }
        
        try {
            $success = TweetList::removeMember($listId, $_SESSION['user_id']);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'تم مغادرة القائمة']);
            } else {
                echo json_encode(['success' => false, 'message' => 'لست عضواً في هذه القائمة']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function addMember($listId) 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'غير مسجل الدخول']);
            return;
        }
        
        $username = $_POST['username'] ?? '';
        
        if (empty($username)) {
            echo json_encode(['success' => false, 'message' => 'اسم المستخدم مطلوب']);
            return;
        }
        
        // Check if current user owns the list
        $list = TweetList::findById($listId);
        if (!$list->id || $list->user_id != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'غير مصرح']);
            return;
        }
        
        // Find user by username
        $user = User::findByUsername($username);
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'المستخدم غير موجود']);
            return;
        }
        
        try {
            $success = TweetList::addMember($listId, $user->id);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'تم إضافة العضو']);
            } else {
                echo json_encode(['success' => false, 'message' => 'المستخدم عضو بالفعل']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function removeMember($listId, $userId) 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'غير مسجل الدخول']);
            return;
        }
        
        // Check if current user owns the list
        $list = TweetList::findById($listId);
        if (!$list->id || $list->user_id != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'غير مصرح']);
            return;
        }
        
        try {
            $success = TweetList::removeMember($listId, $userId);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'تم إزالة العضو']);
            } else {
                echo json_encode(['success' => false, 'message' => 'العضو غير موجود']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
}