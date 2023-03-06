<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
{
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
        $level = implode(',', array_keys(config('zvn.user_level')));
        $condPass = 'bail|required|between:5,32';
        $condEmail = 'bail|required|email|unique:users,email';

        if ($this->id) {
            $condPass = '';
            $condEmail .= ",$this->id";
        }

        return [
            'email' => $condEmail,
            'password' => $condPass,
            'level' => "bail|required|in:$level",
            'status' => 'bail|required|in:0,1',
        ];
    }
}
