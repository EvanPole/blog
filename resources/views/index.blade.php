@extends('layouts.app')

@section('title', trans('blog::messages.title'))

@section('content')
    <div class="text-center mb-5">
        <h1>{{ trans('blog::messages.title') }}</h1>
        <p class="text-muted">{{ trans('blog::messages.subtitle') }}</p>
    </div>

    @if($posts->isEmpty())
        <div class="alert alert-info text-center">
            {{ trans('blog::messages.empty') }}
        </div>
    @else
        @php $featured = $posts->firstWhere('published_at', $posts->max('published_at')); @endphp

        @if($posts->onFirstPage() && $featured)
            <div class="card mb-4 border-0 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6">
                        @if($featured->imageUrl())
                            <img src="{{ $featured->imageUrl() }}" class="w-100 h-100 object-fit-cover" alt="{{ $featured->title }}">
                        @endif
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card-body p-4">
                            <span class="badge bg-primary mb-2">{{ trans('blog::messages.featured') }}</span>
                            <h2 class="card-title">
                                <a href="{{ $featured->url() }}" class="text-decoration-none text-body">{{ $featured->title }}</a>
                            </h2>
                            <p class="card-text text-muted">{{ Str::limit($featured->description, 160) }}</p>
                            <div class="d-flex align-items-center text-muted small">
                                <span>{{ $featured->author->name }}</span>
                                <span class="mx-2">&bull;</span>
                                <span>{{ format_date($featured->published_at) }}</span>
                                <span class="mx-2">&bull;</span>
                                <span>{{ trans('blog::messages.read_time', ['minutes' => $featured->readTime()]) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @foreach($posts as $post)
                @if(!$posts->onFirstPage() || $post->id !== $featured?->id)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            @if($post->imageUrl())
                                <a href="{{ $post->url() }}">
                                    <img src="{{ $post->imageUrl() }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                </a>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ $post->url() }}" class="text-decoration-none text-body">{{ $post->title }}</a>
                                </h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($post->description, 120) }}</p>
                                <div class="d-flex align-items-center text-muted small mt-auto">
                                    <span>{{ $post->author->name }}</span>
                                    <span class="mx-2">&bull;</span>
                                    <span>{{ format_date($post->published_at) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
