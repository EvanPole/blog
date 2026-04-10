<?php

namespace Azuriom\Plugin\Blog\Requests;

use Azuriom\Plugin\Blog\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', Rule::unique(Post::class)->ignore($post)],
            'description' => ['required', 'string', 'max:300'],
            'content' => ['required', 'string'],
            'image' => [$post ? 'nullable' : 'required', 'string', 'max:255'],
            'is_published' => ['filled', 'boolean'],
            'published_at' => ['required', 'date'],
        ];
    }
}
