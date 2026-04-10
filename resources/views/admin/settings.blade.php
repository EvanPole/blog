@extends('admin.layouts.admin')

@section('title', trans('blog::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('blog.admin.settings.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="openaiKeyInput">{{ trans('blog::admin.settings.openai_key') }}</label>
                    <input type="password" class="form-control @error('openai_key') is-invalid @enderror" id="openaiKeyInput" name="openai_key" value="{{ old('openai_key', $apiKey) }}" placeholder="sk-...">
                    @error('openai_key')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <small class="form-text text-muted">{{ trans('blog::admin.settings.openai_key_info') }}</small>
                </div>

                <div class="mb-3">
                    <label for="openaiModelInput">{{ trans('blog::admin.settings.openai_model') }}</label>
                    <select class="form-select @error('openai_model') is-invalid @enderror" id="openaiModelInput" name="openai_model">
                        @foreach(['gpt-4o-mini', 'gpt-4o', 'gpt-4.1-mini', 'gpt-4.1', 'gpt-4.1-nano'] as $m)
                            <option value="{{ $m }}" @selected(old('openai_model', $model) === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                    @error('openai_model')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
