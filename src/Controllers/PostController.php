<?php

namespace Azuriom\Plugin\Blog\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Blog\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with('author')
            ->latest('published_at')
            ->paginate(9);

        return view('blog::index', ['posts' => $posts]);
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        $recent = Post::published()
            ->with('author')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog::show', [
            'post' => $post,
            'recent' => $recent,
        ]);
    }
}
