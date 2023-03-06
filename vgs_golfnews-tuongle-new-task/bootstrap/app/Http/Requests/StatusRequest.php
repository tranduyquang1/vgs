<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    private $table = 'status';

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
            'name' => 'bail|required|between:1,255',
            'status' => 'bail|in:active,inactive',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
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
