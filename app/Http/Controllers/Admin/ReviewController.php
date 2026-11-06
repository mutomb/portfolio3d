<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ManagesMedia;

    public function index(Request $request): View
    {
        $rating = $request->query('rating');

        $reviews = Review::query()
            ->when($rating, fn ($query) => $query->where('rating', $rating))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'rating'));
    }

    public function create(): View
    {
        return view('admin.reviews.create');
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['avatar']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->storeUpload($request->file('avatar'), 'reviews');
        }

        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Client review added.');
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        $data = $request->validated();
        unset($data['avatar']);

        if ($request->hasFile('avatar')) {
            $oldAvatar = $review->avatar;
            $data['avatar'] = $this->storeUpload($request->file('avatar'), 'reviews');
            $this->deleteUpload($oldAvatar);
        }

        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Client review updated.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $this->deleteUpload($review->avatar);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Client review deleted.');
    }
}
