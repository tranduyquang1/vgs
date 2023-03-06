<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentCategoriesSaveRequest extends FormRequest
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
        $pages = implode(',', array_keys(config('zvn.banner.page')));
        $positions = implode(',', array_keys(config('zvn.banner.position')));
        $condThumb = 'bail|required|image';

        if ($this->id) {
            $condThumb = 'bail|image';
        }

        return [
            'name' => 'bail|required|between:2,255',
            'status' => 'bail|required|in:0,1',
            'amount_slider_posts' => 'bail|gt:0',
            'logo_web_icon' => $condThumb,
            'logo_menu' => $condThumb,
            'logo_home' => $condThumb,
        ];
    }
}
