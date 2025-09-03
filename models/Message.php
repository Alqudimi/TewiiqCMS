<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class Message 
{
    public static function create($data) 
    {
        Database::init();
        
        $message = R::dispense('messages');
        $message->conversation_id = $data['conversation_id'];
        $message->sender_id = $data['sender_id'];
        $message->content = $data['content'];
        $message->message_type = $data['message_type'] ?? 'text';
        $message->is_read = false;
        $message->created_at = date('Y-m-d H:i:s');
        
        $id = R::store($message);
        
        // Update conversation last activity
        require_once __DIR__ . '/Conversation.php';
        Conversation::updateLastActivity($data['conversation_id']);
        
        return R::load('messages', $id);
    }
    
    public static function getConversationMessages($conversationId, $limit = 50, $offset = 0) 
    {
        Database::init();
        
        $messages = R::find('messages', 
            'conversation_id = ? ORDER BY created_at ASC LIMIT ? OFFSET ?', 
            [$conversationId, $limit, $offset]
        );
        
        $result = [];
        foreach ($messages as $message) {
            $sender = R::load('users', $message->sender_id);
            $result[] = [
                'message' => $message,
                'sender' => $sender
            ];
        }
        
        return $result;
    }
    
    public static function markAsRead($messageId, $userId) 
    {
        Database::init();
        
        $message = R::load('messages', $messageId);
        
        // Only mark as read if user is not the sender
        if ($message->id && $message->sender_id != $userId) {
            $message->is_read = true;
            R::store($message);
            return true;
        }
        
        return false;
    }
    
    public static function markConversationAsRead($conversationId, $userId) 
    {
        Database::init();
        
        $messages = R::find('messages', 
            'conversation_id = ? AND sender_id != ? AND is_read = 0', 
            [$conversationId, $userId]
        );
        
        foreach ($messages as $message) {
            $message->is_read = true;
            R::store($message);
        }
        
        return count($messages);
    }
    
    public static function getUnreadCount($userId) 
    {
        Database::init();
        
        return R::getCell('SELECT COUNT(*) FROM messages m 
                          JOIN conversations c ON m.conversation_id = c.id 
                          WHERE (c.participant_one = ? OR c.participant_two = ?) 
                          AND m.sender_id != ? AND m.is_read = 0', 
                          [$userId, $userId, $userId]);
    }
    
    public static function delete($messageId, $userId) 
    {
        Database::init();
        
        $message = R::load('messages', $messageId);
        
        if ($message->id && $message->sender_id == $userId) {
            R::trash($message);
            return true;
        }
        
        return false;
    }
}