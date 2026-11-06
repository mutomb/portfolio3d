<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'client_name', 'client_role', 'company', 'content', 'rating', 'avatar',
    'project_url', 'is_featured', 'is_active', 'sort_order',
])]
class Review extends Model
{
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function avatarUrl(): string
    {
        if (! $this->avatar) {
            return asset('images/avatar.svg');
        }

        if (Str::startsWith($this->avatar, ['http://', 'https://', 'images/'])) {
            return Str::startsWith($this->avatar, 'http')
                ? $this->avatar
                : asset($this->avatar);
        }

        return Storage::disk('uploads')->url($this->avatar);
    }

    public function initials(): string
    {
        return Str::of($this->client_name)
            ->explode(' ')
            ->take(2)
            ->map(fn (string $word): string => Str::upper(Str::substr($word, 0, 1)))
            ->implode('');
    }
}
