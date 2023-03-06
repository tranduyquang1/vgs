<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $pathViewController = 'admin.pages.dashboard.';
    private $controllerName = 'dashboard';

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index()
    {
        return view($this->pathViewController . 'index', [
            'cateNews' => DB::table('cate_news')->count() - 1,
            'post' => DB::table('post')->count(),
            'slider' => DB::table('slider')->count(),
            'emailSubscribe' => DB::table('email_subscribe')->count(),
        ]);
    }
}

