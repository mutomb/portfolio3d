<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\Portfolio;
use App\Models\ProjectAnalytic;
use App\Models\SiteVisit;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();
        $visitSeries = $this->dailySeries(SiteVisit::query(), $today, 13);
        $inquirySeries = $this->dailySeries(ContactInquiry::query(), $today, 13);

        $topProjects = Portfolio::query()
            ->with('category')
            ->withCount([
                'analytics as views_count' => fn (Builder $query) => $query->where('event_type', 'view'),
                'analytics as clicks_count' => fn (Builder $query) => $query->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study']),
                'analytics as demo_clicks_count' => fn (Builder $query) => $query->where('event_type', 'live'),
                'analytics as source_clicks_count' => fn (Builder $query) => $query->where('event_type', 'github'),
                'analytics as dashboard_clicks_count' => fn (Builder $query) => $query->where('event_type', 'dashboard'),
            ])
            ->orderByDesc('clicks_count')
            ->orderByDesc('views_count')
            ->limit(8)
            ->get();

        $typeBreakdown = ProjectAnalytic::query()
            ->join('portfolios', 'portfolios.id', '=', 'project_analytics.portfolio_id')
            ->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study'])
            ->selectRaw('portfolios.project_type as type, count(*) as total')
            ->groupBy('portfolios.project_type')
            ->pluck('total', 'type');

        $metrics = [
            'total_visits' => SiteVisit::query()->count(),
            'visits_today' => SiteVisit::query()->where('created_at', '>=', $today)->count(),
            'visits_7d' => SiteVisit::query()->where('created_at', '>=', $today->copy()->subDays(6))->count(),
            'unique_visitors' => SiteVisit::query()->distinct()->count('ip_address'),
            'total_views' => ProjectAnalytic::query()->event('view')->count(),
            'total_clicks' => ProjectAnalytic::query()->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study'])->count(),
            'inquiries_total' => ContactInquiry::query()->count(),
            'inquiries_new' => ContactInquiry::query()->unread()->count(),
            'software_clicks' => (int) ($typeBreakdown['software'] ?? 0),
            'data_clicks' => (int) ($typeBreakdown['data'] ?? 0),
        ];

        $metrics['click_through_rate'] = $metrics['total_views'] > 0
            ? round(($metrics['total_clicks'] / $metrics['total_views']) * 100, 1)
            : 0;

        $recentInquiries = ContactInquiry::query()
            ->latest()
            ->limit(5)
            ->get();

        $latestVisits = SiteVisit::query()
            ->latest()
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact(
            'metrics',
            'visitSeries',
            'inquirySeries',
            'topProjects',
            'recentInquiries',
            'latestVisits',
        ));
    }

    public function metrics(): JsonResponse
    {
        $today = now()->startOfDay();

        return response()->json([
            'total_visits' => SiteVisit::query()->count(),
            'visits_today' => SiteVisit::query()->where('created_at', '>=', $today)->count(),
            'total_clicks' => ProjectAnalytic::query()->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study'])->count(),
            'total_views' => ProjectAnalytic::query()->event('view')->count(),
            'unread_inquiries' => ContactInquiry::query()->unread()->count(),
            'updated_at' => now()->format('H:i:s'),
        ]);
    }

    /**
     * @return Collection<int, array{date: string, total: int}>
     */
    private function dailySeries(Builder $query, \DateTimeInterface $today, int $days): Collection
    {
        $rows = $query
            ->selectRaw('date(created_at) as day, count(*) as total')
            ->where('created_at', '>=', now()->subDays($days)->startOfDay())
            ->groupBy('day')
            ->pluck('total', 'day');

        return collect(range($days, 0))
            ->map(function (int $offset) use ($rows): array {
                $date = now()->subDays($offset);

                return [
                    'date' => $date->format('M j'),
                    'total' => (int) ($rows[$date->toDateString()] ?? 0),
                ];
            });
    }
}
