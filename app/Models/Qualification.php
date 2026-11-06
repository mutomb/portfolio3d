<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title', 'institution', 'type', 'description', 'started_at', 'completed_at',
    'is_current', 'sort_order', 'is_active',
])]
class Qualification extends Model
{
    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'completed_at' => 'date',
            'is_current' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    protected function periodLabel(): Attribute
    {
        return Attribute::get(function (): string {
            $start = $this->started_at?->format('Y');
            $end = $this->is_current ? 'Present' : $this->completed_at?->format('Y');

            return collect([$start, $end])->filter()->implode(' — ');
        });
    }
}
