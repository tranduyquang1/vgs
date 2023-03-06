<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthPostLoginRequest;
use App\Models\old\SupportersModel;
use App\Models\old\TeachersModel;
use App\Models\old\UserModel;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $pathViewController = 'frontend.pages.auth.';
    public $controllerName = 'auth';
    protected $model;
    protected $params = [];

    public function __construct(User $model)
    {
        $this->model = $model;
        view()->share('controllerName', $this->controllerName);
    }

    public function login(Request $request)
    {
        return view($this->pathViewController . 'login');
    }

    public function postLogin(AuthPostLoginRequest $request)
    {

        $params = $request->all();

        $userInfo = $this->model->getAuthItem($request->all());

        if (!$userInfo) return redirect()->route($this->controllerName . '.index')->with('news_notify', 'Tài khoản hoặc mật khẩu không chính xác!');

        if (!$userInfo['status']) return redirect()->route($this->controllerName . '.index')->with('news_notify', 'Bạn không có quyền truy cập!');

        session(['userInfo' => $userInfo]);

        if ($userInfo['level'] == 'super_admin') return redirect()->route('admin.user.index');
        if ($userInfo['level'] == 'admin') return redirect()->route('admin.post.index');
        if ($userInfo['level'] == 'user') return redirect()->route('admin.post.index');
        if ($userInfo['level'] == 'user_ads') return redirect()->route('admin.banner.index');
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('userInfo'))
            $request->session()->pull('userInfo');

        return redirect()->route('auth.index');
    }


}