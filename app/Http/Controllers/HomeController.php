<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\ProjectAnalytic;
use App\Models\Qualification;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function index(): View
    {
        $projects = Portfolio::query()
            ->published()
            ->with('category')
            ->withCount([
                'analytics as views_count' => fn (Builder $query) => $query->where('event_type', 'view'),
                'analytics as clicks_count' => fn (Builder $query) => $query->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study']),
            ])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('completed_at')
            ->get();

        $skills = Skill::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->active()
            ->withCount(['portfolios' => fn (Builder $query) => $query->where('is_published', true)])
            ->orderBy('sort_order')
            ->get();

        $qualifications = Qualification::query()
            ->active()
            ->orderBy('sort_order')
            ->orderByDesc('started_at')
            ->get();

        $services = Service::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        $reviews = Review::query()
            ->active()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $analytics = [
            'views' => ProjectAnalytic::query()->event('view')->count(),
            'clicks' => ProjectAnalytic::query()->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study'])->count(),
            'top_project' => Portfolio::query()
                ->published()
                ->withCount([
                    'analytics as views_count' => fn (Builder $query) => $query->where('event_type', 'view'),
                    'analytics as clicks_count' => fn (Builder $query) => $query->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study']),
                ])
                ->orderByDesc('clicks_count')
                ->first(),
        ];

        return view('home', compact(
            'projects',
            'skills',
            'categories',
            'qualifications',
            'services',
            'reviews',
            'analytics',
        ));
    }

    public function resume(): Response|RedirectResponse
    {
        $path = Setting::get('resume_path');

        if (! is_string($path) || $path === '') {
            return back()->with('error', 'The resume is being updated. Reach out by email and I will send a copy.');
        }

        if (Str::startsWith($path, ['images/', 'files/'])) {
            $absolutePath = public_path($path);

            abort_unless(is_file($absolutePath), 404);

            return response()->download($absolutePath, basename($absolutePath));
        }

        abort_unless(Storage::disk('uploads')->exists($path), 404);

        return Storage::disk('uploads')->download($path);
    }
}
