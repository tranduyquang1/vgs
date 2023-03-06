<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeChangePasswordRequest;
use App\Http\Requests\MeSaveInfoRequest;
use App\Models\User;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public $controllerName = 'me';
    public $pathViewController = 'admin.pages.me.';
    protected $model;
    protected $params = [];

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        view()->share('controllerName', $this->controllerName);
    }

    public function index()
    {
        $item = $this->user;
        return view($this->pathViewController . 'index', compact('item'));
    }

    public function saveInfo(MeSaveInfoRequest $request)
    {
        $this->user->name = $request->name;
        $this->user->save();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Cập nhật thông tin thành công!');
    }

    public function changePassword(MeChangePasswordRequest $request)
    {
        $this->user->password = $request->password_new;
        $this->user->save();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Cập nhật mật khẩu thành công!');
    }
}
