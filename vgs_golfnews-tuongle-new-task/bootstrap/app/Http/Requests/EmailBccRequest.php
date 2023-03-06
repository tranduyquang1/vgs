<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailBccRequest extends FormRequest
{
    private $table = 'email_bcc';

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
        return [
            'email' => 'bail|required|between:5,255',
            'status' => 'bail|in:active,inactive',
            'order' => 'bail|in:active,inactive',
            'contact' => 'bail|in:active,inactive',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'status' => 'Trạng thái',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được rỗng',
            'between' => ':attribute giá trị :input không nằm trong khoảng :min - :max.',
            'in' => ':attribute: phải khác giá trị mặc định'
        ];
    }

}
