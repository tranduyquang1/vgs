<?php

return [
    'url' => [
        'prefix_admin' => 'adminstrator',
        'prefix_login' => 'login',
        'prefix_frontend' => '',
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
        'form_label_edit' => [
            'class' => 'control-label col-md-4 col-sm-3 col-xs-12'
        ],
        'form_ckeditor' => [
            'class' => 'form-control col-md-6 col-xs-12 ckeditor'
        ],
        'form_datepicker' => [
            'class' => 'form-control col-md-6 col-xs-12 datepicker'
        ],
        'form_datepicker_modal' => [
            'class' => 'form-control col-md-6 col-xs-12 datepicker-modal'
        ],
        'status' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
            'block' => ['name' => 'Bị khóa', 'class' => 'btn-danger'],
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success'],
        ],
        'recall' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Đã liên hệ', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa liên hệ', 'class' => 'btn-info'],
        ],
        'order' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Đã xử lí', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa xử lí', 'class' => 'btn-info'],
        ],
        'is_home' => [
            'yes' => ['name' => 'Hiển thị', 'class' => 'btn-primary'],
            'no' => ['name' => 'Không hiển thị', 'class' => 'btn-warning']
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
        'rating' => [
            1 => '★',
            2 => '★ ★',
            3 => '★ ★ ★',
            4 => '★ ★ ★ ★',
            5 => '★ ★ ★ ★ ★',
        ],
        'display' => [
            'list' => ['name' => 'Danh sách'],
            'grid' => ['name' => 'Lưới'],
        ],
        'type' => [
            'featured' => ['name' => 'Nổi bật'],
            'normal' => ['name' => 'Bình thường'],
        ],
        'level' => [
            1 => ['name' => 'Admin'],
            2 => ['name' => 'Phòng kế hoạch'],
            3 => ['name' => 'QA/QC kiểm hàng'],
            4 => ['name' => 'Viewer'],
        ],
        'times_check' => [
            1 => 1,
            2 => 2,
            3 => 3
        ],
        'target' => [
            '_self' => 'Bình thường',
            '_blank' => 'Mở tab mới',
        ],
        'search' => [
            'all' => ['name' => 'Tìm kiếm tất cả'],
            'id' => ['name' => 'Tìm kiếm theo ID'],
            'name' => ['name' => 'Tìm kiếm theo Tên'],
            'username' => ['name' => 'Tìm kiếm theo Tài khoản'],
            'fullname' => ['name' => 'Tìm kiếm theo Tên đầy đủ'],
            'email' => ['name' => 'Tìm kiếm theo Email'],
            'description' => ['name' => 'Tìm kiếm theo Mô tả'],
            'link' => ['name' => 'Tìm kiếm theo Đường dẫn'],
            'content' => ['name' => 'Tìm kiếm theo Nội dung'],
        ],
        'button' => [
            'edit' => ['class' => 'btn-success', 'title' => 'Edit', 'icon' => 'fa-pencil', 'route-name' => '/form'],
            'delete' => ['class' => 'btn-danger btn-delete', 'title' => 'Delete', 'icon' => 'fa-trash', 'route-name' => '/delete'],
            'info' => ['class' => 'btn-info', 'title' => 'View', 'icon' => 'fa-pencil', 'route-name' => '/delete'],
            'view' => ['class' => 'btn-warning text-white', 'title' => 'View', 'icon' => 'fa-search', 'route-name' => '/view'],
        ],
        'header' => [
            'dashboard' => 'Thống kê',
            'cateNews' => 'Danh mục bài viết',
            'post' => 'Bài viết',
            'cateProduct' => 'Danh mục sản phẩm',
            'product' => 'Sản phẩm',
            'menuHeader' => 'Menu ở đầu trang',
            'menuMain' => 'Menu chính',
            'menuFooter' => 'Menu ở cuối trang',
            'slider' => 'Slider',
            'files' => 'Tập tin',
            'agencies' => 'Chi nhánh',
            'recall' => 'Yêu cầu gọi lại',
            'cateFaq' => 'Danh mục',
            'faq' => 'Câu hỏi',
            'setting' => 'Thiết lập',
            'user' => 'Người dùng',
            'comments' => 'Nhận xét',
            'category' => 'Thể loại',
            'contact' => 'Liên hệ',
            'order' => 'Đơn hàng',
            'customer' => 'Khách hàng',
            'emailSubscribe' => 'Email subscribe',
            'menuLanding' => 'Landing',
            'teams' => 'Thành viên',
            'banner' => 'Banner',
            'usb' => 'USB',
            'suggestions' => 'Giợi ý',
            'status' => 'Trạng thái',
            'company' => 'Tìm kiếm',
        ]
    ],
    'config' => [
        'search' => [
            'default' => ['all', 'id', 'name'],
            'slider' => ['all', 'id', 'name', 'description', 'link'],
            'cateNews' => ['all', 'name'],
            'cateProduct' => ['all', 'name'],
            'post' => ['all', 'name', 'content'],
        ],
        'button' => [
            'default' => ['edit', 'delete'],
            'slider' => ['edit', 'delete'],
            'category' => ['edit', 'delete'],
            'post' => ['edit', 'delete'],
            'comments' => ['edit', 'delete'],
            'agencies' => ['edit', 'delete'],
            'menuHeader' => ['edit', 'delete'],
            'menuFooter' => ['edit', 'delete'],
            'menuMain' => ['edit', 'delete'],
            'cateNews' => ['edit', 'delete'],
            'cateProduct' => ['edit', 'delete'],
            'product' => ['edit', 'delete'],
            'recall' => ['delete'],
            'emailSubscribe' => ['delete'],
            'cateFaq' => ['edit', 'delete'],
            'faq' => ['edit', 'delete'],
            'customer' => ['edit', 'delete'],
            'teams' => ['edit', 'delete'],
            'portfolio' => ['edit', 'delete'],
            'usb' => ['edit', 'delete'],
            'menuLanding' => ['edit', 'delete'],
            'menuLandingSection' => ['edit', 'delete'],
            'banner' => ['edit', 'delete'],
            'suggestions' => ['edit', 'delete'],
            'emailBcc' => ['delete'],
            'emailTemplate' => ['delete'],
            'user' => ['edit', 'delete'],
            'contact' => ['delete'],
            'order' => ['delete'],
            'register' => ['delete'],
            'files' => ['view', 'delete'],
            'status' => ['edit', 'delete'],
        ]
    ],
    'excel_field' => [
        'ngay_xuat_hang' => 'Ngày xuất hàng',
        'tuan_xuat_hang' => 'Tuần xuất hàng',
        'art' => 'ART',
        'art_theo_kieu_moi' => 'ART theo kiểu mới',
        'ten_ma_hang' => 'Tên mã hàng',
        'revision' => 'Revision',
        'revision_theo_kieu_moi' => 'Revision theo kiểu mới',
        'code_nm' => 'Code NM',
        'so_luong' => 'Số lượng',
        'nhan_tuan' => 'Nhãn tuần',
        'deviation' => 'Deviation',
        'chu_cai_cont_noi_bo' => 'Chữ cái Cont nội bộ',
        'qc_kiem' => 'QC kiểm hàng',
        'cont_no' => 'Cont no',
        'cont_no_block' => 'Khóa Cont No',
        'message' => 'Ghi chú',
        'status' => 'Trạng thái',
        'times_check' => 'Lần kiểm',
        'note' => 'Ghi chú kiểm hàng'
    ]
];