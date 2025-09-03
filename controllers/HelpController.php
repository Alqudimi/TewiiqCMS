<?php

class HelpController {
    private $templates;

    public function __construct($templates) {
        $this->templates = $templates;
    }

    public function index() {
        // إعداد البيانات للصفحة
        $pageData = [
            'title' => 'المركز المساعد - تويق',
            'activeTab' => 'help',
            'currentPage' => 'help'
        ];

        // عرض صفحة المساعدة
        echo $this->templates->render('pages/help', $pageData);
    }

    public function article($articleId = null) {
        // إذا كان هناك مقال محدد، يمكن عرضه هنا
        if ($articleId) {
            // منطق عرض مقال المساعدة المحدد
            $pageData = [
                'title' => 'مقال المساعدة - تويق',
                'activeTab' => 'help',
                'currentPage' => 'help',
                'articleId' => $articleId
            ];

            // يمكن إنشاء قالب منفصل للمقالات لاحقاً
            echo $this->templates->render('pages/help', $pageData);
        } else {
            // إعادة توجيه إلى صفحة المساعدة الرئيسية
            header('Location: /help');
            exit;
        }
    }
}