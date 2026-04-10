@extends('admin.layouts.admin')

@section('title', trans('blog::admin.posts.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('blog.admin.posts.store') }}" method="POST">
                <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                @include('admin.elements.editor', ['imagesUploadUrl' => route('blog.admin.posts.attachments.pending', $pendingId)])

                @include('blog::admin.posts._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
