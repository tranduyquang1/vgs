<?php
return [
    'url' => [
        'prefix_admin' => 'administrator',
        'prefix_teacher' => 'teacher',
        'prefix_support' => 'support',
        'prefix_frontend' => '',
        'prefix_api' => 'api',
        'prefix_login' => 'login123',
    ],
    'format' => [
        'long_time' => 'H:m:s d/m/Y',
        'short_time' => 'd/m/Y',
    ],
    'template' => [
        'form_input' => [
            'class' => 'form-control col-md-6 col-xs-12'
        ],
        'form_label' => [
            'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
        ],
        'form_input_tagify' => [
            'class' => 'form-control col-md-6 col-xs-12 zvn-tagify'
        ],
        'form_ckeditor' => [
            'class' => 'form-control col-md-6 col-xs-12 ckeditor'
        ],
        'form_datepicker' => [
            'class' => 'form-control col-md-6 col-xs-12 datepicker'
        ],
        'form_multi' => [
            'class' => 'form-control col-md-6 col-xs-12 select-multi',
            'multiple' => true
        ],
        'form_price' => [
            'class' => 'form-control col-md-6 col-xs-12 currency',
        ],
        'status_tiny_int' => [
            1 => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            0 => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
        ],
        'status_tiny_int_with_all' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            1 => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            0 => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
        ],
        'status_of_post' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'pending' => ['name' => 'Chờ duyệt', 'class' => 'btn-success'],
            'approved' => ['name' => 'Đã duyệt', 'class' => 'btn-success'],
            'published' => ['name' => 'Đã đăng', 'class' => 'btn-success']
        ],
        'status' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
            'block' => ['name' => 'Bị khóa', 'class' => 'btn-danger'],
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success'],
        ],
        'status_course' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            1 => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            0 => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success'],
        ],
        'status_is_register' => [
            1 => ['name' => 'Còn', 'class' => 'btn-success'],
            0 => ['name' => 'Hết lượt', 'class' => 'btn-info'],
        ],
        'user_status' => [
            1 => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            0 => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
        ],
        'user_unlock' => [
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success'],
            'active' => ['name' => 'Chưa phản hồi', 'class' => 'btn-danger'],
            'inactive' => ['name' => 'Đã phản hồi', 'class' => 'btn-success'],
        ],
        'lock' => [
            1 => ['name' => 'Đã khóa', 'class' => 'btn-danger'],
            0 => ['name' => 'Không khóa', 'class' => 'btn-info'],
        ],
        'special' => [
            1 => ['name' => 'Có', 'class' => 'btn-success'],
            0 => ['name' => 'Không', 'class' => 'btn-info'],
        ],
        'tuition_status' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Ưu đãi', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Không ưu đãi', 'class' => 'btn-info'],
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success'],
        ],
        'is_home' => [
            'yes' => ['name' => 'Hiển thị', 'class' => 'btn-primary'],
            'no' => ['name' => 'Không hiển thị', 'class' => 'btn-warning']
        ],
        'show_frontend' => [
            1 => ['name' => 'Hiển thị', 'class' => 'btn-primary'],
            0 => ['name' => 'Không hiển thị', 'class' => 'btn-warning']
        ],
        'show_is_home' => [
            'yes' => 'Hiển thị',
            'no' => 'Không hiển thị'
        ],
        'status_question' => [
            'yes' => 'Đã trả lời',
            'no' => 'Chưa trả lời'
        ],
        'question_send_type' => [
            '' => '-- Chọn giá trị ---',
            'teacher' => 'Giảng viên',
            'supporter' => 'Người hổ trợ',
        ],
        'level' => [
            'admin' => ['name' => 'Quản trị hệ thống'],
            'member' => ['name' => 'Người dùng bình thường'],
        ],
        'post_format' => [
            'article' => 'Bài viết',
            'video' => 'Video',
        ],
        'post_status' => [
            'pending' => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'published' => 'Đã đăng'
        ],
        'post_status_button' => [
            'pending' => ['name' => 'Chờ duyệt', 'class' => 'btn-warning'],
            'approved' => ['name' => 'Đã duyệt', 'class' => 'btn-info'],
            'published' => ['name' => 'Đã đăng', 'class' => 'btn-success'],
        ],
        'format_video_type' => [
            1 => 'MP4',
            2 => 'SWF',
        ],
        'contact' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Đã liên hệ', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa liên hệ', 'class' => 'btn-info'],
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success'],
        ],
        'bcc_contact' => [
            'active' => ['name' => 'Bật', 'class' => 'btn-primary'],
            'inactive' => ['name' => 'Tắt', 'class' => 'btn-warning']
        ],
        'bcc_order' => [
            'active' => ['name' => 'Bật', 'class' => 'btn-primary'],
            'inactive' => ['name' => 'Tắt', 'class' => 'btn-warning']
        ],
        'setting_position' => [
            'right' => 'Bên phải',
            'left' => 'Bên trái'
        ],
        'search' => [
            'all' => ['name' => 'Search by All'],
            'id' => ['name' => 'Search by ID'],
            'name' => ['name' => 'Search by Name'],
            'username' => ['name' => 'Search by Username'],
            'fullname' => ['name' => 'Search by Fullname'],
            'email' => ['name' => 'Search by Email'],
            'description' => ['name' => 'Search by Description'],
            'link' => ['name' => 'Search by Link'],
            'content' => ['name' => 'Search by Content'],
            'comment' => ['name' => 'Search by Comment'],
            'request' => ['name' => 'Search by Request'],
            'feedback' => ['name' => 'Search by Feedback'],
            'url' => ['name' => 'Search by URL'],
            'title' => ['name' => 'Search by Title'],
            'excerpt' => ['name' => 'Search by Excerpt'],
        ],
        'button' => [
            'edit' => ['class' => 'btn-success', 'title' => 'Edit', 'icon' => 'fa-pencil', 'route-name' => 'form'],
            'delete' => ['class' => 'btn-danger btn-delete', 'title' => 'Xóa', 'icon' => 'fa-trash', 'route-name' => 'delete'],
            'reply' => ['class' => 'btn-primary btn-reply', 'title' => 'Trả lời', 'icon' => 'fa-reply', 'route-name' => ''],
            'mail' => ['class' => 'btn-warning', 'title' => 'Mail', 'icon' => 'fa-envelope-o', 'route-name' => '/mail'],
            'view' => ['class' => 'btn-warning', 'title' => 'View', 'icon' => 'fa-eye', 'route-name' => '/view'],
            'update' => ['class' => 'btn-primary', 'title' => 'Update', 'icon' => 'fa-refresh', 'route-name' => '/update'],
        ],
        'button-email' => [
            'teacher' => ['class' => 'btn-info send-mail', 'title' => 'Giáo viên', 'icon' => 'fa-send'],
            'support' => ['class' => 'btn-info send-mail', 'title' => 'Người hỗ trợ', 'icon' => 'fa-send'],
            'student' => ['class' => 'btn-info send-mail', 'title' => 'Học viên', 'icon' => 'fa-send'],
        ],
        'box' => [
            'default' => ['name' => 'Không tìm thấy'],
            'slider' => ['name' => 'Tổng số phần của Slider'],
            'post' => ['name' => 'Tổng số phần của Article'],
            'category' => ['name' => 'Tổng số phần của Category'],
            'user' => ['name' => 'Tổng số phần của User'],
            'menu' => ['name' => 'Tổng số phần của Menu'],
        ],
        'answer' => [
            'all' => ['name' => '-- Chọn trạng thái câu trả lời --'],
            'yes' => ['name' => 'Đã trả lời'],
            'no' => ['name' => 'Chưa trả lời'],
        ],
        'header' => [
            'dashboard' => 'Thống kê',
            'category' => 'Danh mục',
            'menu' => 'Menu',
            'banner' => 'Banner PC',
            'banner_mobile' => 'Banner Mobile',
            'banner-category' => 'Danh mục chuyên trang',
            'banner-categories' => 'Danh sách banner chuyên trang',
            'banner-categories-pc' => 'Danh sách banner chuyên trang PC',
            'banner-categories-mobile' => 'Danh sách banner chuyên trang Mobile',
            'tournament-categories' => 'Danh sách chuyên trang',
            'tournament-live' => 'Thông tin LiveStream + LiveScore',
            'tournament-live-scheldule' => 'Lịch thi đấu chuyên trang',
            'post' => 'Bài viết',
            'user' => 'Người dùng',
            'me' => 'Thông tin',
        ],
    ],
    'config' => [
        'search' => [
            'default' => ['all', 'id', 'name'],
            'banner' => ['all', 'name', 'url'],
            'post' => ['all', 'title', 'excerpt'],
        ],
        'button' => [
            'default' => ['edit', 'delete'],
            'category' => ['edit', 'delete'],
            'menu' => ['edit', 'delete'],
            'banner' => ['edit', 'delete'],
            'post' => ['edit', 'delete'],
            'user' => ['edit', 'delete'],
            'banner_mobile' => ['edit', 'delete'],
            'banner-category' => ['edit', 'delete'],
            'banner-categories' => ['edit', 'delete'],
            'banner-categories-pc' => ['edit', 'delete'],
            'banner-categories-mobile' => ['edit', 'delete'],
            'tournament-categories' => ['edit', 'delete'],
            'tournament-live' => ['edit', 'delete'],
            'tournament-live-scheldule' => ['edit', 'delete'],
        ],
        'button-email' => [
            'default' => ['teacher', 'support'],
            'question' => ['teacher', 'support', 'student'],
        ],
        'user_profile_errors' => [
            1 => [
                'name' => 'Lỗi thông tin',
                'key' => 'NOTIFY_HO_SO_LOI_THONG_TIN'
            ],
            2 => [
                'name' => 'Lỗi ảnh CMND',
                'key' => 'NOTIFY_HO_SO_LOI_CMND'
            ],
            3 => [
                'name' => 'Lỗi ảnh Sinh viên',
                'key' => 'NOTIFY_HO_SO_LOI_ANH_SINH_VIEN'
            ],
        ]
    ],
    'menu_type' => [
        'link' => 'Link',
        'category' => 'Danh mục'
    ],
    'banner' => [
        'page' => [
            'home' => 'Trang chủ',
            'category' => 'Trang chuyên mục',
            'post' => 'Trang chi tiết bài viết'
        ],
        'position' => [
            'sidebar1' => 'Ad Left 1(300x600)',
            'sidebar2' => 'Ad Left 2(300x600)',
            'sidebar3' => 'Ad Right 1(300x600)',
            'sidebar4' => 'Ad Right 2(300x600)',
            'center1' => 'Billboard 1( 1600x200)',
            'center2' => 'Billboard 2( 1600x200)'
            // 'sidebar1' => 'Sidebar Left 01',
            // 'sidebar2' => 'Sidebar Left 02',
            // 'sidebar3' => 'Sidebar Right 01',
            // 'sidebar4' => 'Sidebar Right 02',
            // 'center1' => 'Trung tâm 01',
            // 'center2' => 'Trung tâm 02'
        ]
    ],
    'user_level' => [
        'user_tournament' => 'User Tournament',
        'user_ads' => 'User Ads',
        'user' => 'User',
        'admin' => 'Admin',
        'super_admin' => 'Super Admin'
    ],
    'category_home_position' => [
        'col_left_top' => 'Col Left Top',
        'col_left_posts_carousel' => 'Col Left Posts Carousel',
        'col_left_before_ads_center' => 'Col Left Before ADS Center',
        'col_left_after_feature_post' => 'Col Left After Feature Post',
        'col_left_bottom_left' => 'Col Left Bottom Left',
        'col_left_bottom_right' => 'Col Left Bottom Right',
        'col_right_top' => 'Col Right Top',
        'col_right_latest_posts' => 'Col Right Latest Posts',
        'col_right_bottom' => 'Col Right Bottom',

    ],
    'post_status' => [
        'pending' => 'Chờ duyệt',
        'approved' => 'Đã duyệt',
        'published' => 'Đã đăng'
    ],
    'banner_type' => [
        'mobile_emagazine_1' => 'Breakpage(414x345)',
        'mobile_emagazine_2' => 'Large 1(300x250)',
        'mobile_emagazine_3' => 'Large 2(300x250)',
        'mobile_emagazine_4' => 'Footer (300x250)',
        'inpage_fullscreen' => 'Inpage(600x300)',
        'top_banner' => 'Masthead(414x207)'
        // 'mobile_emagazine_1' => 'Mobile EMagazine 1',
        // 'mobile_emagazine_2' => 'Mobile EMagazine 2',
        // 'mobile_emagazine_3' => 'Mobile EMagazine 3',
        // 'mobile_emagazine_4' => 'Mobile EMagazine 4',
        // 'inpage_fullscreen' => 'Inpage Fullscreen',
        // 'top_banner' => 'Top Banner'
    ],
    'banner_categories_pc_position' => [
        '0' => 'Không chọn',
        '1' => 'Banner Top (1522x300)',
        '2' => 'Banner Background(1609x900)',
        '3' => 'Banner Horizontal (1600x200)',
        '4' => 'Banner in post(1600x900)',
    ],
    'banner_categories_mobile_position' => [
        '0' => 'Không chọn',
        '1' => 'Banner Top (414x207)',
        // '2' => 'Banner Background(1609x900)',
        '3' => 'Banner Horizontal (300x250)',
        '5' => 'Banner in post in page(600x300)',
        '4' => 'Banner in post footer(300x250)',

        
    ],
    'tournament_live_type' => [
        '1' => 'Live Stream',
        '2' => 'Live Score',

    ],
    'tournament_scheldule_language' => [
        '0' => 'Tiếng Việt',
        '1' => 'English',

    ],
    'banner_categories_device' => [
        '10' => 'Không chọn',
        '0' => 'PC',
        '1' => 'Mobile',
    ]
];
