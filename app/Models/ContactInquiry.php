<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'email', 'subject', 'message', 'budget', 'status', 'reply_message',
    'read_at', 'replied_at', 'ip_address', 'user_agent',
])]
class ContactInquiry extends Model
{
    public const STATUSES = [
        'new' => 'New',
        'read' => 'Read',
        'replied' => 'Replied',
        'archived' => 'Archived',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'replied_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function unread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead(): void
    {
        if (! $this->read_at) {
            $this->forceFill([
                'read_at' => now(),
                'status' => $this->status === 'new' ? 'read' : $this->status,
            ])->save();
        }
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'new' => 'text-matrix border-matrix/40 bg-matrix/10',
            'read' => 'text-cyber border-cyber/40 bg-cyber/10',
            'replied' => 'text-violet-300 border-violet-400/40 bg-violet-400/10',
            'archived' => 'text-slate-400 border-slate-500/40 bg-slate-500/10',
            default => 'text-slate-300 border-white/10 bg-white/5',
        };
    }
}
