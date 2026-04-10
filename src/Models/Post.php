<?php

namespace Azuriom\Plugin\Blog\Models;

use Azuriom\Models\Traits\Attachable;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use Attachable;
    use HasTablePrefix;

    protected string $prefix = 'blog_';

    protected $fillable = [
        'title', 'slug', 'description', 'content', 'image',
        'author_id', 'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function imageUrl(): ?string
    {
        return $this->image ? image_url($this->image) : null;
    }

    public function readTime(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    public function url(): string
    {
        return route('blog.show', $this->slug);
    }

    public function getAttachmentsKey(): string
    {
        return 'content';
    }

    public function getAttachmentsPath(): string
    {
        return 'blog/posts/attachments';
    }

    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', $slug.'%')->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
