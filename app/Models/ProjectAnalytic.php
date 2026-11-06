<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['portfolio_id', 'event_type', 'ip_address', 'user_agent', 'referrer'])]
class ProjectAnalytic extends Model
{
    protected $table = 'project_analytics';

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    #[Scope]
    protected function event(Builder $query, string $event): Builder
    {
        return $query->where('event_type', $event);
    }
}
