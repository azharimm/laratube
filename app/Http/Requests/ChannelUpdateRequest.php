<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ChannelUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $channelId = Auth::user()->channels->first()->id;
        return [
            'name'=>'required|max:255|unique:channels,name,'.$channelId,
            'slug'=>'required|max:255|alpha_num|unique:channels,slug,'.$channelId,
            'description'=>'max:1000'
        ];
    }

    public function messages()
    {
        return[
            'slug.unique'=>'That unique url has been taken.',
        ];
    }
}
