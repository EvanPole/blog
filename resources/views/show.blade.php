@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('blog.index') }}" class="text-decoration-none mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> {{ trans('blog::messages.back') }}
            </a>

            <article>
                <h1 class="mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center text-muted mb-4">
                    <span>{{ $post->author->name }}</span>
                    <span class="mx-2">&bull;</span>
                    <span>{{ format_date($post->published_at) }}</span>
                    <span class="mx-2">&bull;</span>
                    <span>{{ trans('blog::messages.read_time', ['minutes' => $post->readTime()]) }}</span>
                </div>

                @if($post->imageUrl())
                    <img src="{{ $post->imageUrl() }}" class="img-fluid rounded mb-4 w-100" alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                @endif

                <div class="content">
                    {!! $post->content !!}
                </div>
            </article>

            @if($recent->isNotEmpty())
                <hr class="my-5">
                <h4 class="mb-4">{{ trans('blog::messages.related') }}</h4>
                <div class="row g-4">
                    @foreach($recent as $related)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                @if($related->imageUrl())
                                    <a href="{{ $related->url() }}">
                                        <img src="{{ $related->imageUrl() }}" class="card-img-top" alt="{{ $related->title }}" style="height: 140px; object-fit: cover;">
                                    </a>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ $related->url() }}" class="text-decoration-none text-body">{{ $related->title }}</a>
                                    </h6>
                                    <small class="text-muted">{{ format_date($related->published_at) }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
