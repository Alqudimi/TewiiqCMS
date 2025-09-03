<?php

require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/User.php';

class EventController 
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
        
        $filter = $_GET['filter'] ?? 'all';
        
        // Get live events
        $liveEvents = Event::getLiveEvents();
        
        // Get events based on filter
        switch ($filter) {
            case 'live':
                $events = $liveEvents;
                break;
            case 'upcoming':
                $events = Event::getUpcomingEvents(50, 0);
                break;
            case 'sports':
                $events = Event::getEventsByType('sports', 50, 0);
                break;
            case 'news':
                $events = Event::getEventsByType('news', 50, 0);
                break;
            case 'entertainment':
                $events = Event::getEventsByType('entertainment', 50, 0);
                break;
            default:
                $events = array_merge($liveEvents, Event::getUpcomingEvents(30, 0));
                break;
        }
        
        echo $this->templates->render('pages/events', [
            'events' => $events,
            'liveEvents' => $liveEvents,
            'filter' => $filter,
            'title' => 'الفعاليات الحية'
        ]);
    }
    
    public function show($eventId) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $event = Event::findById($eventId);
        if (!$event->id) {
            http_response_code(404);
            echo $this->templates->render('errors/404');
            return;
        }
        
        // Get event host
        $host = User::findById($event->user_id);
        
        // Get participants
        $participants = Event::getParticipants($eventId, 20);
        
        // Check if current user is participating
        $isParticipating = Event::isParticipant($eventId, $_SESSION['user_id']);
        
        echo $this->templates->render('pages/event-detail', [
            'event' => $event,
            'host' => $host,
            'participants' => $participants,
            'isParticipating' => $isParticipating,
            'isHost' => $event->user_id == $_SESSION['user_id'],
            'title' => $event->title
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
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'event_type' => $_POST['event_type'] ?? 'general',
            'start_time' => $_POST['start_time'] ?? null,
            'end_time' => $_POST['end_time'] ?? null,
            'location' => trim($_POST['location'] ?? ''),
            'hashtags' => trim($_POST['hashtags'] ?? ''),
            'is_live' => isset($_POST['is_live']) ? 1 : 0,
            'image_url' => null // TODO: Handle image uploads
        ];
        
        // Validate required fields
        if (empty($data['title']) || empty($data['start_time'])) {
            $_SESSION['error'] = 'عنوان الفعالية ووقت البداية مطلوبان';
            header('Location: /events');
            exit;
        }
        
        // Validate datetime
        if (!strtotime($data['start_time'])) {
            $_SESSION['error'] = 'وقت البداية غير صحيح';
            header('Location: /events');
            exit;
        }
        
        if ($data['end_time'] && !strtotime($data['end_time'])) {
            $_SESSION['error'] = 'وقت النهاية غير صحيح';
            header('Location: /events');
            exit;
        }
        
        try {
            $eventId = Event::create($data);
            $_SESSION['success'] = 'تم إنشاء الفعالية بنجاح';
            header('Location: /events/' . $eventId);
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء إنشاء الفعالية';
            header('Location: /events');
        }
        
        exit;
    }
    
    public function join($eventId) 
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
            $success = Event::joinEvent($eventId, $_SESSION['user_id']);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'تم الانضمام للفعالية']);
            } else {
                echo json_encode(['success' => false, 'message' => 'أنت مشارك بالفعل']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function leave($eventId) 
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
            $success = Event::leaveEvent($eventId, $_SESSION['user_id']);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'تم مغادرة الفعالية']);
            } else {
                echo json_encode(['success' => false, 'message' => 'لست مشاركاً في هذه الفعالية']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function updateLiveStatus($eventId) 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'غير مسجل الدخول']);
            return;
        }
        
        $event = Event::findById($eventId);
        if (!$event->id || $event->user_id != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'غير مصرح']);
            return;
        }
        
        $isLive = $_POST['is_live'] ?? false;
        $isLive = $isLive ? 1 : 0;
        
        try {
            $success = Event::updateLiveStatus($eventId, $isLive);
            
            if ($success) {
                $message = $isLive ? 'تم تفعيل البث المباشر' : 'تم إيقاف البث المباشر';
                echo json_encode(['success' => true, 'message' => $message]);
            } else {
                echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function getLiveEvents() 
    {
        try {
            $liveEvents = Event::getLiveEvents();
            echo json_encode(['success' => true, 'events' => $liveEvents]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
    
    public function search() 
    {
        $query = $_GET['q'] ?? '';
        $type = $_GET['type'] ?? null;
        
        if (empty($query)) {
            echo json_encode([]);
            return;
        }
        
        try {
            $results = Event::search($query, $type, 20, 0);
            echo json_encode($results);
        } catch (Exception $e) {
            echo json_encode([]);
        }
    }
}