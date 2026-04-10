<?php

namespace Azuriom\Plugin\Blog\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Http\Requests\AttachmentRequest;
use Azuriom\Plugin\Blog\Models\Post;

class PostAttachmentController extends Controller
{
    public function store(AttachmentRequest $request, Post $post)
    {
        $imageUrl = $post->storeAttachment($request->file('file'));

        return response()->json(['location' => $imageUrl]);
    }

    public function pending(AttachmentRequest $request, string $pendingId)
    {
        $imageUrl = Post::storePendingAttachment($pendingId, $request->file('file'));

        return response()->json(['location' => $imageUrl]);
    }
}
