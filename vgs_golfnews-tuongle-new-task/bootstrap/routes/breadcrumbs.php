<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('index'));
});

Breadcrumbs::for('faq', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Câu hỏi thường gặp', route('index/faq'));
    $trail->push($title);
});

Breadcrumbs::for('pricing', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Thanh toán', route('index/pricing'));
    $trail->push($title);
});

Breadcrumbs::for('contact', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Liên hệ', route('index/contact'));
    $trail->push($title);
});

Breadcrumbs::for('schedule', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Lịch khai giảng', route('index/schedule'));
    $trail->push($title);
});

Breadcrumbs::for('search', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('courses'));
    $trail->push($title, route('index/search'));
});

Breadcrumbs::for('courses_online', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('courses'));
    $trail->push($title);
});

Breadcrumbs::for('courses_offline', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('frontend/coursesOffline'));
    $trail->push($title);
});

Breadcrumbs::for('courses_offline_detail', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('frontend/coursesOffline'));
    $trail->push($title);
});

Breadcrumbs::for('courses_one_to_one', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('courses'));
    $trail->push($title);
});

Breadcrumbs::for('courses_combo', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('frontend/coursesCombo'));
    $trail->push($title);
});

Breadcrumbs::for('cart', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('courses'));
    $trail->push($title, route('courses/cart'));
});

Breadcrumbs::for('post_cart', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Khóa học', route('courses'));
    $trail->push($title);
});

Breadcrumbs::for('blog', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Bài viết', route('blog'));
    $trail->push($title);
});

Breadcrumbs::for('blog_category', function ($trail, $title) {
    $trail->parent('home');
    $trail->push('Bài viết', route('blog'));
    $trail->push($title);
});

Breadcrumbs::for('blog_detail', function ($trail, $title, $categoryName, $categorySlug) {
    $trail->parent('home');
    $trail->push('Bài viết', route('blog'));
    $trail->push($categoryName, route('blog/category', ['slug' => $categorySlug]));
    $trail->push($title);
});