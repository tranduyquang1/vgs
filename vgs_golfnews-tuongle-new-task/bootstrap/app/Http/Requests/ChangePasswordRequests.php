<?php

namespace App\Http\Requests;

use App\Models\old\UserModel as Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChangePasswordRequests extends FormRequest
{
    private $table = 'user';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userInfo = $this->session()->get('userInfo');
        $id = $userInfo['id'];
        $email = $userInfo['email'];
        $rules = [];

        Validator::extend('check_password', function ($parameters, $value, $attribute) use ($id, $email) {
            $user = Model::where('email', $email)->first();

            if (md5($value) == $user->password) {
                return true;
            }
            return false;
        });
        $rules_general = [
            'password_old' => "required|check_password",
            'password_new' => 'min:5|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => "min:5",
        ];

        return array_merge($rules, $rules_general);
    }

    public function attributes()
    {
        return [
            'password_old' => 'Mật khẩu cũ',
            'password_new' => 'Mật khẩu mới',
            'password_confirmation' => 'Nhập lại mật khẩu',

        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được rỗng',
            'required_with' => ':attribute không hợp lệ.',
            'same' => ':attribute không khớp với nhập lại mật khẩu.',
            'min' => ':attribute giá trị :input lớn hơn :min.',
            'check_password' => ':attribute không chính xác.',
        ];
    }
}
