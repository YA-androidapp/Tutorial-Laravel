<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ItemRequest extends FormRequest
{
    private $titleMaxLength = 64;

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
        Log::debug(sprintf('rules() method:%s', $this->method()));
        // return [
        // 	'title' => 'required'
        // ];
        if ($this->isMethod('post') || $this->isMethod('put')) {
            // 新規投稿/レコード全項目更新
            return [
                'title' => "required|max:{$this->titleMaxLength}",
            ];
        } elseif ($this->isMethod('put')) {
            // 部分更新
            return [
                'title' => "max:{$this->titleMaxLength}",
            ];
        } else {
            return [];
        }
    }

    /**
    * @return array
    */
    public function messages()
    {
        if ($this->isMethod('post') || $this->isMethod('put')) {
            return [
                'title.required' => 'タイトルは必須です。',
                'title.max' => 'タイトルには64文字まで入力できます。',
            ];
        } elseif ($this->isMethod('put')) {
            // 部分更新
            return [
                'title.max' => 'タイトルには64文字まで入力できます。',
            ];
        } else {
            return [];
        }
    }
}
