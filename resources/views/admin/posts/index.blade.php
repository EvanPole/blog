@extends('admin.layouts.admin')

@section('title', trans('blog::admin.posts.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('messages.fields.title') }}</th>
                        <th scope="col">{{ trans('messages.fields.author') }}</th>
                        <th scope="col">{{ trans('messages.fields.date') }}</th>
                        <th scope="col">{{ trans('messages.fields.status') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->author->name }}</td>
                            <td>{{ format_date($post->published_at) }}</td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge bg-success">{{ trans('blog::admin.status.published') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ trans('blog::admin.status.draft') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('blog.admin.posts.edit', $post) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('blog.admin.posts.destroy', $post) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="{{ route('blog.admin.posts.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
            <a class="btn btn-secondary" href="{{ route('blog.admin.settings') }}">
                <i class="bi bi-gear"></i> {{ trans('blog::admin.settings.title') }}
            </a>
        </div>
    </div>
@endsection
