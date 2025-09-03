<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class Conversation 
{
    public static function create($participantOneId, $participantTwoId) 
    {
        Database::init();
        
        // Check if conversation already exists
        $existingConversation = R::findOne('conversations', 
            '(participant_one = ? AND participant_two = ?) OR (participant_one = ? AND participant_two = ?)', 
            [$participantOneId, $participantTwoId, $participantTwoId, $participantOneId]
        );
        
        if ($existingConversation) {
            return $existingConversation;
        }
        
        $conversation = R::dispense('conversations');
        $conversation->participant_one = $participantOneId;
        $conversation->participant_two = $participantTwoId;
        $conversation->created_at = date('Y-m-d H:i:s');
        $conversation->updated_at = date('Y-m-d H:i:s');
        
        $id = R::store($conversation);
        return R::load('conversations', $id);
    }
    
    public static function getUserConversations($userId) 
    {
        Database::init();
        
        $conversations = R::find('conversations', 
            'participant_one = ? OR participant_two = ? ORDER BY updated_at DESC', 
            [$userId, $userId]
        );
        
        $result = [];
        foreach ($conversations as $conversation) {
            $otherUserId = ($conversation->participant_one == $userId) 
                ? $conversation->participant_two 
                : $conversation->participant_one;
            
            $otherUser = R::load('users', $otherUserId);
            $lastMessage = R::findOne('messages', 'conversation_id = ? ORDER BY created_at DESC', [$conversation->id]);
            $unreadCount = R::count('messages', 'conversation_id = ? AND sender_id != ? AND is_read = 0', [$conversation->id, $userId]);
            
            $result[] = [
                'conversation' => $conversation,
                'other_user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount
            ];
        }
        
        return $result;
    }
    
    public static function findById($id) 
    {
        Database::init();
        return R::load('conversations', $id);
    }
    
    public static function findBetweenUsers($userId1, $userId2) 
    {
        Database::init();
        return R::findOne('conversations', 
            '(participant_one = ? AND participant_two = ?) OR (participant_one = ? AND participant_two = ?)', 
            [$userId1, $userId2, $userId2, $userId1]
        );
    }
    
    public static function updateLastActivity($conversationId) 
    {
        Database::init();
        $conversation = R::load('conversations', $conversationId);
        if ($conversation->id) {
            $conversation->updated_at = date('Y-m-d H:i:s');
            R::store($conversation);
        }
    }
}