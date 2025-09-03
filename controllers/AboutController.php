<?php

class AboutController {
    private $templates;

    public function __construct($templates) {
        $this->templates = $templates;
    }

    public function index() {
        // إعداد البيانات للصفحة
        $pageData = [
            'title' => 'من نحن - تويق',
            'activeTab' => 'about',
            'currentPage' => 'about'
        ];

        // عرض صفحة من نحن
        echo $this->templates->render('pages/about', $pageData);
    }
}