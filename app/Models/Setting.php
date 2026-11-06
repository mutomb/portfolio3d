<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value', 'type', 'group'])]
class Setting extends Model
{
    public const CACHE_KEY = 'settings.all';

    /**
     * @return array<string, mixed>
     */
    public static function allCached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return self::query()
                ->get()
                ->mapWithKeys(fn (self $setting): array => [$setting->key => $setting->typedValue()])
                ->all();
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::allCached()[$key] ?? $default;
    }

    public static function put(string $key, mixed $value, string $type = 'text', string $group = 'general'): void
    {
        self::query()->updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'type' => $type, 'group' => $group],
        );

        Cache::forget(self::CACHE_KEY);
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function typedValue(): mixed
    {
        return match ($this->type) {
            'boolean' => (bool) $this->value,
            'integer' => (int) $this->value,
            'json' => json_decode((string) $this->value, true) ?? [],
            default => $this->value,
        };
    }
}
