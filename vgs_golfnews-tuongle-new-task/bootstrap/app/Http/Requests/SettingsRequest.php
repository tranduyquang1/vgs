<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    private $table = 'settings';

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
        $key_value = $this->request->all()['key_value'];
        $arr_rules = [];
        if ($key_value == 'setting-email') {
            $arr_rules = [
                'email' => 'bail|required|email',

            ];
        }
        if ($key_value == 'setting-bcc') {
            $arr_rules = [
                'bcc' => 'bail|required|between:5,3000',
            ];
        }
        if ($key_value == 'setting-hotline') {
            $arr_rules = [
                'hotline' => 'bail|required|regex:/[0-9]{9}/',
            ];
        }
        return $arr_rules;
    }

    public function attributes()
    {
        return [
            'email' => "Email",
            'bcc' => 'bcc',
            'hotline' => 'hotline'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được rỗng',
            'between' => ':attribute giá trị :input không nằm trong khoảng :min - :max.',
            'in' => ':attribute: phải khác giá trị mặc định',
            'email' => ':attribute không là email',
            'regex' => ':attribute số điện thoại không hợp lệ',
        ];
    }
}
