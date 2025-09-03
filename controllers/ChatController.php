<?php

require_once __DIR__ . '/../models/Conversation.php';
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';

class ChatController 
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
        
        $conversations = Conversation::getUserConversations($_SESSION['user_id']);
        $unreadCount = Message::getUnreadCount($_SESSION['user_id']);
        
        echo $this->templates->render('pages/chats', [
            'title' => 'الرسائل - Tewiiq',
            'conversations' => $conversations,
            'unread_count' => $unreadCount,
            'current_user' => User::findById($_SESSION['user_id'])
        ]);
    }
    
    public function show($conversationId) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $conversation = Conversation::findById($conversationId);
        
        if (!$conversation || 
            ($conversation->participant_one != $_SESSION['user_id'] && 
             $conversation->participant_two != $_SESSION['user_id'])) {
            header('Location: /messages');
            exit;
        }
        
        // Mark messages as read
        Message::markConversationAsRead($conversationId, $_SESSION['user_id']);
        
        $messages = Message::getConversationMessages($conversationId);
        $otherUserId = ($conversation->participant_one == $_SESSION['user_id']) 
            ? $conversation->participant_two 
            : $conversation->participant_one;
        $otherUser = User::findById($otherUserId);
        
        echo $this->templates->render('pages/chat', [
            'title' => 'محادثة مع ' . $otherUser->fullname . ' - Tewiiq',
            'conversation' => $conversation,
            'messages' => $messages,
            'other_user' => $otherUser,
            'current_user' => User::findById($_SESSION['user_id'])
        ]);
    }
    
    public function sendMessage() 
    {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['error' => 'Bad request']);
            return;
        }
        
        $conversationId = $_POST['conversation_id'] ?? null;
        $content = trim($_POST['content'] ?? '');
        
        if (!$conversationId || !$content) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        
        $conversation = Conversation::findById($conversationId);
        
        if (!$conversation || 
            ($conversation->participant_one != $_SESSION['user_id'] && 
             $conversation->participant_two != $_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }
        
        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $_SESSION['user_id'],
            'content' => $content,
            'message_type' => 'text'
        ]);
        
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message_id' => $message->id,
                'content' => $message->content,
                'created_at' => $message->created_at
            ]);
        } else {
            header('Location: /messages/' . $conversationId);
        }
    }
    
    public function startConversation() 
    {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /messages');
            exit;
        }
        
        $otherUserId = $_POST['user_id'] ?? null;
        
        if (!$otherUserId || $otherUserId == $_SESSION['user_id']) {
            header('Location: /messages');
            exit;
        }
        
        $otherUser = User::findById($otherUserId);
        if (!$otherUser->id) {
            header('Location: /messages');
            exit;
        }
        
        $conversation = Conversation::create($_SESSION['user_id'], $otherUserId);
        header('Location: /messages/' . $conversation->id);
    }
    
    public function getMessages() 
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        $conversationId = $_GET['conversation_id'] ?? null;
        $offset = intval($_GET['offset'] ?? 0);
        
        if (!$conversationId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing conversation_id']);
            return;
        }
        
        $conversation = Conversation::findById($conversationId);
        
        if (!$conversation || 
            ($conversation->participant_one != $_SESSION['user_id'] && 
             $conversation->participant_two != $_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }
        
        $messages = Message::getConversationMessages($conversationId, 20, $offset);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'messages' => $messages
        ]);
    }
}