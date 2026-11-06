<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQualificationRequest;
use App\Http\Requests\UpdateQualificationRequest;
use App\Models\Qualification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');

        $qualifications = Qualification::query()
            ->when($type, fn ($query) => $query->where('type', $type))
            ->orderBy('sort_order')
            ->orderByDesc('started_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.qualifications.index', compact('qualifications', 'type'));
    }

    public function create(): View
    {
        return view('admin.qualifications.create');
    }

    public function store(StoreQualificationRequest $request): RedirectResponse
    {
        Qualification::create($request->validated());

        return redirect()->route('admin.qualifications.index')->with('success', 'Qualification added.');
    }

    public function edit(Qualification $qualification): View
    {
        return view('admin.qualifications.edit', compact('qualification'));
    }

    public function update(UpdateQualificationRequest $request, Qualification $qualification): RedirectResponse
    {
        $qualification->update($request->validated());

        return redirect()->route('admin.qualifications.index')->with('success', 'Qualification updated.');
    }

    public function destroy(Qualification $qualification): RedirectResponse
    {
        $qualification->delete();

        return redirect()->route('admin.qualifications.index')->with('success', 'Qualification removed.');
    }
}
