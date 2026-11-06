<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'category_id', 'user_id', 'title', 'slug', 'tagline', 'description', 'content',
    'thumbnail', 'tech_stack', 'project_type', 'live_url', 'github_url', 'dashboard_url',
    'client', 'role', 'duration', 'results', 'is_featured', 'is_published', 'sort_order',
    'completed_at',
])]
class Portfolio extends Model
{
    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'completed_at' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(ProjectAnalytic::class);
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    #[Scope]
    protected function featured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    #[Scope]
    protected function ofType(Builder $query, string $type): Builder
    {
        return $query->where('project_type', $type);
    }

    public function thumbnailUrl(): string
    {
        if (! $this->thumbnail) {
            return asset('images/projects/placeholder.svg');
        }

        if (Str::startsWith($this->thumbnail, ['http://', 'https://'])) {
            return $this->thumbnail;
        }

        if (Str::startsWith($this->thumbnail, 'images/')) {
            return asset($this->thumbnail);
        }

        return Storage::disk('uploads')->url($this->thumbnail);
    }

    public function typeLabel(): string
    {
        return $this->project_type === 'data' ? 'Data & Analytics' : 'Software Engineering';
    }

    protected function techStackList(): Attribute
    {
        return Attribute::get(fn (): array => $this->tech_stack ?? []);
    }
}
