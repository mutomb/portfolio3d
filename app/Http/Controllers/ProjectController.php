<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\ProjectAnalytic;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function show(Request $request, Portfolio $portfolio): View
    {
        abort_unless($portfolio->is_published || $request->user()?->isAdmin(), 404);

        $portfolio->load('category');

        $viewedKey = 'portfolio.viewed.'.$portfolio->id;

        if (! $request->session()->has($viewedKey)) {
            ProjectAnalytic::create([
                'portfolio_id' => $portfolio->id,
                'event_type' => 'view',
                'ip_address' => $request->ip(),
                'user_agent' => Str::limit((string) $request->userAgent(), 500),
                'referrer' => Str::limit((string) $request->headers->get('referer'), 500) ?: null,
            ]);

            $request->session()->put($viewedKey, true);
        }

        $portfolio->loadCount([
            'analytics as views_count' => fn (Builder $query) => $query->where('event_type', 'view'),
            'analytics as clicks_count' => fn (Builder $query) => $query->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study']),
        ]);

        $relatedProjects = Portfolio::query()
            ->published()
            ->whereKeyNot($portfolio->getKey())
            ->where('project_type', $portfolio->project_type)
            ->with('category')
            ->withCount([
                'analytics as views_count' => fn (Builder $query) => $query->where('event_type', 'view'),
                'analytics as clicks_count' => fn (Builder $query) => $query->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study']),
            ])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('projects.show', compact('portfolio', 'relatedProjects'));
    }

    public function click(Request $request, Portfolio $portfolio): JsonResponse
    {
        abort_unless($portfolio->is_published, 404);

        $validated = $request->validate([
            'event_type' => ['required', 'in:live,github,dashboard,case_study'],
        ]);

        ProjectAnalytic::create([
            'portfolio_id' => $portfolio->id,
            'event_type' => $validated['event_type'],
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 500),
            'referrer' => Str::limit((string) $request->headers->get('referer'), 500) ?: null,
        ]);

        return response()->json(['tracked' => true]);
    }
}
