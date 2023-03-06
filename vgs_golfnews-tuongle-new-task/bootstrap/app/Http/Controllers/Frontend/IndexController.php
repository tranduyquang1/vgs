<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\old\EmailSubscribeModel;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $pathViewController = 'frontend.pages.index.';
    private $controllerName = 'index';

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        return redirect()->route('auth/login');
    }

    public function emailSubscribe(Request $request)
    {
        $email = $request->email;
        $status = false;
        try {
            $model = new EmailSubscribeModel();
            $model->saveItem(['email' => $email], ['task' => 'add-item']);
            $status = true;
            $message = 'Success';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function notfound(Request $request)
    {
        return view($this->pathViewController . 'not-found');
    }
}