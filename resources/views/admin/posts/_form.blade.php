@csrf

<div class="mb-3 text-end">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#aiModal">
        <i class="bi bi-stars"></i> {{ trans('blog::admin.ai.generate') }}
    </button>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="titleInput">{{ trans('messages.fields.title') }}</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ old('title', $post->title ?? '') }}" required>
            @error('title')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slugInput">{{ trans('blog::admin.fields.slug') }}</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput" name="slug" value="{{ old('slug', $post->slug ?? '') }}" required>
            @error('slug')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descriptionInput">{{ trans('messages.fields.description') }}</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" rows="3" required>{{ old('description', $post->description ?? '') }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contentInput">{{ trans('messages.fields.content') }}</label>
            <textarea class="form-control html-editor @error('content') is-invalid @enderror" id="contentInput" name="content" rows="10">{{ old('content', $post->content ?? '') }}</textarea>
            @error('content')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="imageSearch">
                {{ trans('messages.fields.image') }}
                <a href="{{ route('admin.images.create') }}" target="_blank" class="ms-1" title="{{ trans('blog::admin.fields.upload_image') }}" data-bs-toggle="tooltip">
                    <i class="bi bi-question-circle text-primary"></i>
                </a>
            </label>
            <div class="position-relative" id="imagePickerWrapper">
                <input type="text" class="form-control" id="imageSearch" placeholder="{{ trans('blog::admin.fields.search_image') }}" autocomplete="off">
                <input type="hidden" name="image" id="imageInput" value="{{ old('image', $post->image ?? '') }}">
                <div class="list-group position-absolute w-100 shadow-sm d-none" id="imageResults" style="z-index: 1050; max-height: 300px; overflow-y: auto;"></div>
            </div>
            @error('image')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror

            <div id="imagePreview" class="mt-2">
                @if(isset($post) && $post->image)
                    <img src="{{ $post->imageUrl() }}" class="img-fluid rounded" alt="{{ $post->title }}">
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="publishedAtInput">{{ trans('blog::admin.fields.published_at') }}</label>
            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="publishedAtInput" name="published_at" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
            @error('published_at')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" class="form-check-input" id="publishedSwitch" name="is_published" value="1" @checked(old('is_published', $post->is_published ?? false))>
                <label class="form-check-label" for="publishedSwitch">{{ trans('blog::admin.fields.is_published') }}</label>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('imageSearch');
    const hiddenInput = document.getElementById('imageInput');
    const resultsDiv = document.getElementById('imageResults');
    const previewDiv = document.getElementById('imagePreview');
    const searchUrl = '{{ route("blog.admin.images.search") }}';
    let debounceTimer;

    function loadImages(query) {
        axios.get(searchUrl, { params: { q: query } }).then(function (response) {
            resultsDiv.innerHTML = '';
            resultsDiv.classList.remove('d-none');

            if (response.data.length === 0) {
                resultsDiv.innerHTML = '<div class="list-group-item text-muted">{{ trans("blog::admin.fields.no_image") }}</div>';
                return;
            }

            response.data.forEach(function (image) {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action d-flex align-items-center gap-2';
                item.innerHTML = '<img src="' + image.url + '" style="width:40px;height:40px;object-fit:cover;" class="rounded">' +
                    '<span>' + image.name + '</span>';
                item.addEventListener('click', function () {
                    hiddenInput.value = image.file;
                    searchInput.value = image.name;
                    previewDiv.innerHTML = '<img src="' + image.url + '" class="img-fluid rounded" alt="' + image.name + '">';
                    resultsDiv.classList.add('d-none');
                });
                resultsDiv.appendChild(item);
            });
        });
    }

    searchInput.addEventListener('focus', function () {
        loadImages(searchInput.value);
    });

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            loadImages(searchInput.value);
        }, 250);
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('imagePickerWrapper').contains(e.target)) {
            resultsDiv.classList.add('d-none');
        }
    });

    @if(isset($post) && $post->image)
        searchInput.value = '{{ $post->image }}';
    @endif
});
</script>
@endpush

<div class="modal fade" id="aiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-stars"></i> {{ trans('blog::admin.ai.title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="aiTopic">{{ trans('blog::admin.ai.topic') }}</label>
                    <textarea class="form-control" id="aiTopic" rows="3" placeholder="{{ trans('blog::admin.ai.topic_placeholder') }}"></textarea>
                </div>
                <div class="mb-3">
                    <label for="aiLang">{{ trans('blog::admin.ai.language') }}</label>
                    <select class="form-select" id="aiLang">
                        <option value="english">English</option>
                        <option value="français">Français</option>
                        <option value="español">Español</option>
                        <option value="deutsch">Deutsch</option>
                    </select>
                </div>
                <div id="aiError" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="aiGenerateBtn">
                    <i class="bi bi-stars"></i> {{ trans('blog::admin.ai.generate') }}
                    <span class="spinner-border spinner-border-sm d-none" id="aiSpinner" role="status"></span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('aiGenerateBtn');
    const spinner = document.getElementById('aiSpinner');
    const errorDiv = document.getElementById('aiError');

    generateBtn.addEventListener('click', function () {
        const topic = document.getElementById('aiTopic').value.trim();
        if (!topic) return;

        generateBtn.disabled = true;
        spinner.classList.remove('d-none');
        errorDiv.classList.add('d-none');

        axios.post('{{ route("blog.admin.generate") }}', {
            topic: topic,
            lang: document.getElementById('aiLang').value,
        }).then(function (response) {
            const data = response.data;

            document.getElementById('titleInput').value = data.title || '';
            document.getElementById('slugInput').value = data.slug || '';
            document.getElementById('descriptionInput').value = data.description || '';

            if (typeof tinymce !== 'undefined' && tinymce.get('contentInput')) {
                tinymce.get('contentInput').setContent(data.content || '');
            } else {
                document.getElementById('contentInput').value = data.content || '';
            }

            bootstrap.Modal.getInstance(document.getElementById('aiModal')).hide();
        }).catch(function (error) {
            const msg = error.response?.data?.error || '{{ trans("blog::admin.ai.api_error") }}';
            errorDiv.textContent = msg;
            errorDiv.classList.remove('d-none');
        }).finally(function () {
            generateBtn.disabled = false;
            spinner.classList.add('d-none');
        });
    });
});
</script>
@endpush
