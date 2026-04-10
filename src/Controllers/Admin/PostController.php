<?php

namespace Azuriom\Plugin\Blog\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Image;
use Azuriom\Plugin\Blog\Models\Post;
use Azuriom\Plugin\Blog\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author')->latest()->get();

        return view('blog::admin.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        $images = Image::latest()->get();
        $pendingId = old('pending_id', Str::uuid());

        return view('blog::admin.posts.create', [
            'images' => $images,
            'pendingId' => $pendingId,
        ]);
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = Auth::id();

        $post = Post::create($data);
        $post->persistPendingAttachments($request->input('pending_id'));

        return to_route('blog.admin.posts.index')
            ->with('success', trans('messages.status.success'));
    }

    public function edit(Post $post)
    {
        $images = Image::latest()->get();

        return view('blog::admin.posts.edit', [
            'post' => $post,
            'images' => $images,
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return to_route('blog.admin.posts.index')
            ->with('success', trans('messages.status.success'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('blog.admin.posts.index')
            ->with('success', trans('messages.status.success'));
    }

    public function searchImages(Request $request)
    {
        $query = $request->input('q', '');

        $images = Image::where('name', 'like', "%{$query}%")
            ->latest()
            ->take(20)
            ->get()
            ->map(fn (Image $image) => [
                'file' => $image->file,
                'name' => $image->name,
                'url' => $image->url(),
            ]);

        return response()->json($images);
    }
}
