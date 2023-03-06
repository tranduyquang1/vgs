<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\old\AuthLoginRequest as MainRequest;
use App\Models\old\UserModel;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $pathViewController = 'frontend.pages.auth.';
    private $controllerName = 'auth';

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function login(Request $request)
    {
        return view($this->pathViewController . 'login');
    }

    public function postLogin(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();

            $userModel = new UserModel();
            $userInfo = $userModel->getItem($params, ['task' => 'auth-login']);

            if (!$userInfo)
                return redirect()->route($this->controllerName . '/login')->with('news_notify', 'Tài khoản hoặc mật khẩu không chính xác!');

            $request->session()->put('userInfo', $userInfo);

            return redirect()->route('files');
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('userInfo'))
            $request->session()->pull('userInfo');

        return redirect()->route('index');
    }


}