<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use ManagesMedia;

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $type = $request->query('type');
        $status = $request->query('status');
        $categoryId = $request->query('category');

        $portfolios = Portfolio::query()
            ->with('category')
            ->withCount([
                'analytics as views_count' => fn ($query) => $query->where('event_type', 'view'),
                'analytics as clicks_count' => fn ($query) => $query->whereIn('event_type', ['live', 'github', 'dashboard', 'case_study']),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('tagline', 'like', "%{$search}%")
                        ->orWhere('client', 'like', "%{$search}%");
                });
            })
            ->when(in_array($type, ['software', 'data'], true), fn ($query) => $query->where('project_type', $type))
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('admin.portfolios.index', compact('portfolios', 'categories', 'search', 'type', 'status', 'categoryId'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['title'], $data['slug'] ?? null, Portfolio::class);
        $data['tech_stack'] = $this->parseCommaList($data['tech_stack'] ?? null);
        $data['user_id'] = $request->user()->id;

        unset($data['thumbnail']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->storeUpload($request->file('thumbnail'), 'portfolios');
        }

        Portfolio::create($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Project created and added to the showcase.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['title'], $data['slug'] ?? null, Portfolio::class, $portfolio->id);
        $data['tech_stack'] = $this->parseCommaList($data['tech_stack'] ?? null);

        unset($data['thumbnail']);

        if ($request->hasFile('thumbnail')) {
            $oldThumbnail = $portfolio->thumbnail;
            $data['thumbnail'] = $this->storeUpload($request->file('thumbnail'), 'portfolios');
            $this->deleteUpload($oldThumbnail);
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Project updated.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->deleteUpload($portfolio->thumbnail);
        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Project deleted.');
    }
}
