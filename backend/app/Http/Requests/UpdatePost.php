<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePost extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'tags' => array_map(function($tag_name) {
                return str_replace('　', ' ', $tag_name);
            }, $this->input('tags'))
        ]);
    }

    public function rules()
    {
        return [
            'title' => 'required|filled|string|max:100',
            'body' => 'required|filled|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png',
            'delete_images' => 'nullable|array',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|max:255|regex:/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。_-]+$/'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルを入力してください',
            'title.max' => 'タイトルは100文字以下にしてください',
            'body.required' => '本文を入力してください',
            'thumnbail.image' => 'jpegかpngの画像を選択してください',
            'thumnbail.mimes' => 'jpegかpngの画像を選択してください',
            'images.*.image' => 'jpegかpngの画像を選択してください',
            'images.*.mimes' => 'jpegかpngの画像を選択してください',
            'tags.*.max' => 'タグは255文字以下にしてください',
            'tags.*.regex' => '記号は「-」と「_」のみ利用できます',
        ];
    }
}
