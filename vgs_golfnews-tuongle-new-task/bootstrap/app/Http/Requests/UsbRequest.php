<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsbRequest extends FormRequest
{
    private $table = 'usb';

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
            'name' => 'bail|required|between:5,255',
            'status' => 'bail|in:active,inactive',
            'size' => 'bail|required',
            'total' => 'bail|required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'size' => 'Dung lượng',
            'total' => 'Tổng số video',
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
