<?php

return [
    'name' => 'Tewiiq',
    'url' => 'http://localhost:5000',
    'env' => 'development',
    'debug' => true,
    'timezone' => 'Asia/Riyadh',
    'locale' => 'ar',
    
    // Security
    'session_name' => 'tewiiq_session',
    'csrf_token_name' => '_token',
    
    // File Upload
    'max_file_size' => 10485760, // 10MB
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    'upload_path' => __DIR__ . '/../public/uploads/',
];