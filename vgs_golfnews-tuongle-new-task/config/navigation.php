<?php

return [
    'admin' => [
        [
            'name' => 'Người dùng',
            'icon' => 'fa fa-user',
            'link' => 'admin.user.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin']
        ],
        [
            'name' => 'Danh mục',
            'icon' => 'fa fa-folder',
            'link' => 'admin.category.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin', 'admin']
        ],
        [
            'name' => 'Bài viết',
            'icon' => 'fa fa-newspaper-o',
            'link' => 'admin.post.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin', 'admin', 'user','user_tournament']
        ],
        [
            'name' => 'Menu',
            'icon' => 'fa fa-bars',
            'link' => 'admin.menu.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin']
        ],
        [
            'name' => 'Chuyên trang giải đấu',
            'icon' => 'fa fa-bars',
            'params' => [],
            'child' => [
                [
                    'name' => 'Danh sách chuyên trang',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.tournament-categories.index',

                    'child' => [],

                ],
                [
                    'name' => 'Link THTT',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.tournament-live.index',

                    'child' => [],

                ],
                [
                    'name' => 'Lịch thi đấu',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.tournament-live-scheldule.index',

                    'child' => [],

                ],
                
            ],
            'arr_controller' => ['tournament'],

            'user_level' => ['super_admin','user_tournament']
        ],
        [
            'name' => 'Banner PC',
            'icon' => 'fa fa-sliders',
            'link' => 'admin.banner.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin', 'admin', 'user_ads']
        ],
        [
            'name' => 'Banner Mobile',
            'icon' => 'fa fa-sliders',
            'link' => 'admin.banner_mobile.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin', 'admin', 'user_ads']
        ],
        [
            'name' => 'Banner Chuyên trang',
            'icon' => 'fa fa-sliders',
            'params' => [],
            'child' => [
                [
                    'name' => 'Danh mục banner',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.banner-category.index',

                    'child' => [],

                ],
                [
                    'name' => 'Banner PC',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.banner-categories-pc.index',

                    'child' => [],

                ],
                [
                    'name' => 'Banner Mobile',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.banner-categories-mobile.index',

                    'child' => [],

                ],
            ],
            'arr_controller' => ['bannersss'],

            'user_level' => ['super_admin','user_tournament']

        ],
        [
            'name' => 'Cấu hình',
            'icon' => 'fa fa-cogs',
            'link' => '',
            'params' => [],
            'child' => [
                [
                    'name' => 'Cấu hình chung',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.setting.index',
                    'params' => ['key_value' => 'setting-main'],
                    'child' => []
                ],
                [
                    'name' => 'Email',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.setting.index',
                    'params' => ['key_value' => 'setting-email'],
                    'child' => []
                ],
                [
                    'name' => 'Social',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.setting.index',
                    'params' => ['key_value' => 'setting-social'],
                    'child' => []
                ],
                [
                    'name' => 'SEO',
                    'icon' => 'fa fa-circle-o',
                    'link' => 'admin.setting.index',
                    'params' => ['key_value' => 'setting-seo'],
                    'child' => []
                ],
            ],
            'arr_controller' => ['settings'],
            'user_level' => ['super_admin']
        ],
        [
            'name' => 'Thông tin cá nhân',
            'icon' => 'fa fa-cog',
            'link' => 'admin.me.index',
            'params' => [],
            'child' => [],
            'user_level' => ['super_admin', 'admin', 'user', 'user_ads','user_tournament']
        ],
    ]
];