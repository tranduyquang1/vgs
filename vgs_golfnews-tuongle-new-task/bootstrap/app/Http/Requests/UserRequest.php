<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->id;
        $task = $this->task;

        $condAvatar = '';
        $condUserName = '';
        $condEmail = '';
        $condPass = '';
        $condLevel = '';
        $condStatus = '';
        $condFullname = '';


        switch ($task) {
            case 'add':
                $condUserName = "bail|required|between:3,100|unique:$this->table,username";
                $condEmail = "bail|required|email|unique:$this->table,email";
                $condFullname = 'bail|required|min:3';
                $condPass = 'bail|required|between:5,100|confirmed';
                $condStatus = 'bail|in:active,inactive';
                $condLevel = 'bail|not_in:default';
                $condAvatar = 'bail|image|max:500';
                break;
            case 'edit-info':
                $condUserName = "bail|required|between:3,100|unique:$this->table,username,$id";
                $condFullname = 'bail|required|min:3';
                $condAvatar = 'bail|image|max:500';
                $condStatus = 'bail|in:active,inactive';
                $condEmail = "bail|required|email|unique:$this->table,email,$id";
                break;
            case 'change-password':
                $condPass = 'bail|required|between:3,100|confirmed';
                break;
            case 'change-level':
                $condLevel = 'bail|not_in:default';
                break;
            default:
                break;
        }


        return [
            'username' => $condUserName,
            'email' => $condEmail,
            'fullname' => $condFullname,
            'status' => $condStatus,
            'password' => $condPass,
            'level' => $condLevel,
            'avatar' => $condAvatar
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'T??i kho???n',
            'email' => 'Email',
            'fullname' => 'H??? v?? t??n',
            'password' => 'M???t kh???u',
            'position_id' => 'Ch???c v???',
            'group_id' => 'Ph??n quy???n',
            'avatar' => '???nh ?????i di???n',
            'status' => 'Tr???ng th??i',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute kh??ng ???????c r???ng',
            'between' => ':attribute c?? gi?? tr??? kh??ng n???m trong kho???ng :min - :max.',
            'in' => ':attribute ph???i kh??c gi?? tr??? m???c ?????nh',
            'not_in' => ':attribute ph???i kh??c gi?? tr??? m???c ?????nh',
            'confirmed' => ':attribute gi?? tr??? n??y kh??ng tr??ng kh???p',
        ];
    }
}
