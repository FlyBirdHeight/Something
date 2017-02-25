<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
        return [
            'title'=> 'required|between:6,196',
            'content' => 'required|min:26'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空！',
            'title.between' =>'标题在6-196个字符之间！',
            'content.required'=>'问题内容不能为空',
            'content.min' => '问题内容要大于26个字符'
        ];
    }
}
