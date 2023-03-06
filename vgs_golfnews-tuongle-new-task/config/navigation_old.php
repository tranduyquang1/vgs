<?php

return [
    'admin' => [
        [
            'name' => 'Thống kê',
            'icon' => 'fa fa-home',
            'link' => 'dashboard',
            'params' => [],
            'child' => []
        ],
        [
            'name' => 'Truy cập nhanh',
            'icon' => 'fa fa-life-saver',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Người dùng',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'user',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Học viên đăng ký',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'coursesCart',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Đánh giá',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'rating',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Hỏi đáp',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'question',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'CV học viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersCV',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['user', 'coursesCart', 'rating', 'question', 'usersCV'],
        ],
        [
            'name' => ' Quản lý người dùng',
            'icon' => 'fa fa-users',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Nhóm',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'group',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Người dùng',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'user',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Whitelist',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersWhiteList',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Yêu cầu mở khóa',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersUnlock',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Giảng viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'teachers',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Người hổ trợ',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'supporters',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'CV học viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersCV',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['group', 'user', 'teachers', 'supporters', 'usersCV', 'usersWhiteList', 'usersUnlock']
        ],
        [
            'name' => 'Quản lý học viên ',
            'icon' => 'fa fa-bars',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Danh sách học viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'student',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Thống kê học viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'studentStatistics',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Học viên đăng ký',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'coursesCart',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Đánh giá',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'rating',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Hỏi đáp',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'question',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Tập học viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersFilter',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Gửi mail HV',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersFilterSendMail',
                    'params' => [],
                    'child' => [],
                ],
            ],
            'arr_controller' => ['student', 'coursesCart', 'rating', 'question', 'usersFilter', 'usersFilterSendMail', 'studentStatistics']
        ],
        [
            'name' => 'Quản lý khóa học',
            'icon' => 'fa fa-bars',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Thể loại',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'categoryCourses',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Tag',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'tagCourses',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Khóa học',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'courses',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Nâng cấp',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'coursesUpgrade',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Lớp học',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'classes',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Dàn bài',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'outline',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['categoryCourses', 'tagCourses', 'courses', 'outline']
        ],
        [
            'name' => 'Quản lý hồ sơ ',
            'icon' => 'fa fa-file',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Hồ sơ học viên',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersRegisterAccount',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Hồ sơ cần duyệt',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'usersRegisterAccount/process',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['usersRegisterAccount']
        ],
        [
            'name' => 'Cấu hình khóa học',
            'icon' => 'fa fa-folder',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Học phí',
                    'icon' => 'fa fa-hdd-o',
                    'link' => 'tuition',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Lơi nhuận',
                    'icon' => 'fa fa-money',
                    'link' => 'profit',
                    'params' => [],
                    'child' => [],
                ],
            ],
            'arr_controller' => ['tuition', 'profit']
        ],
        [
            'name' => 'Lịch sử học tập',
            'icon' => 'fa fa-history',
            'link' => 'historyStudy',
            'params' => [],
            'child' => []
        ],
        [
            'name' => 'Thông báo',
            'icon' => 'fa fa-comment',
            'link' => 'notify',
            'params' => [],
            'child' => []
        ],
        [
            'name' => 'Cấu hình',
            'icon' => 'fa fa-gears',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Cấu hình chung',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'settings/form',
                    'params' => ['key_value' => 'setting-main'],
                    'child' => []
                ],
                [
                    'name' => 'Email',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'settings/form',
                    'params' => ['key_value' => 'setting-email'],
                    'child' => []
                ],
                [
                    'name' => 'Social',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'settings/form',
                    'params' => ['key_value' => 'setting-social'],
                    'child' => []
                ],
                [
                    'name' => 'Script',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'settings/form',
                    'params' => ['key_value' => 'setting-script'],
                    'child' => []
                ],
                [
                    'name' => 'Chat',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'settings/form',
                    'params' => ['key_value' => 'setting-chat'],
                    'child' => []
                ],
                [
                    'name' => 'SEO',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'settings/form',
                    'params' => ['key_value' => 'setting-seo'],
                    'child' => []
                ],
                [
                    'name' => 'Custom field',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'customField',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['settings', 'customField']
        ],
    ],
    'teacher' => [
        [
            'name' => 'Thống kê',
            'icon' => 'fa fa-home',
            'link' => 'teacher/dashboard',
            'params' => [],
            'child' => []
        ],
        [
            'name' => 'Khóa học Online',
            'icon' => 'fa fa-folder-o',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Thu nhập',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'teacher/revenue',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Câu hỏi',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'teacher/question',
                    'params' => [],
                    'child' => []
                ],
                [
                    'name' => 'Đánh giá',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'teacher/rating',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['teacher/revenue', 'teacher/question', 'teacher/rating']
        ],
        [
            'name' => 'Khóa học Offline',
            'icon' => 'fa fa-list',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Lịch dạy',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'teacher/historyCoursesOffline',
                    'params' => [],
                    'child' => []
                ],
            ],
            'arr_controller' => ['teacher/historyCoursesOffline']
        ],
    ],
    'support' => [
        [
            'name' => 'Câu hỏi',
            'icon' => 'fa fa-question',
            'link' => 'support/question',
            'params' => [],
            'child' => []
        ],
    ]
];