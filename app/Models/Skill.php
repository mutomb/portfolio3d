<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'category', 'proficiency', 'icon', 'color', 'years_experience',
    'description', 'sort_order', 'is_active',
])]
class Skill extends Model
{
    public const CATEGORIES = [
        'backend' => 'Backend',
        'frontend' => 'Frontend',
        'data' => 'Data & Analytics',
        'database' => 'SQL & Databases',
        'devops' => 'DevOps & Cloud',
        'tools' => 'Tools & Platforms',
    ];

    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
            'years_experience' => 'decimal:1',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }
}
