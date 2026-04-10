@extends('admin.layouts.admin')

@section('title', trans('blog::admin.posts.edit'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('blog.admin.posts.update', $post) }}" method="POST">
                @method('PUT')

                @include('admin.elements.editor', ['imagesUploadUrl' => route('blog.admin.posts.attachments.store', $post)])

                @include('blog::admin.posts._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
