<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ManagesMedia
{
    protected function storeUpload(?UploadedFile $file, string $folder): ?string
    {
        return $file?->store($folder, 'uploads');
    }

    protected function deleteUpload(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['images/', 'files/', 'http://', 'https://'])) {
            return;
        }

        Storage::disk('uploads')->delete($path);
    }

    /**
     * @return array<int, string>
     */
    protected function parseCommaList(?string $value): array
    {
        return collect(explode(',', (string) $value))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return array<int, string>
     */
    protected function parseLines(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value) ?: [])
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     */
    protected function uniqueSlug(string $title, ?string $requested, string $modelClass, ?int $ignoreId = null): string
    {
        $base = Str::slug($requested ?: $title) ?: Str::random(8);
        $slug = $base;
        $counter = 2;

        while ($modelClass::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
