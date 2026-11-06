<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    use ManagesMedia;

    /**
     * @var array<string, array{0: string, 1: string}>
     */
    private const FIELDS = [
        'site_name' => ['identity', 'text'],
        'site_tagline' => ['identity', 'text'],
        'site_description' => ['identity', 'text'],
        'owner_name' => ['identity', 'text'],
        'owner_title' => ['identity', 'text'],
        'email' => ['contact', 'text'],
        'phone' => ['contact', 'text'],
        'location' => ['contact', 'text'],
        'availability_status' => ['contact', 'text'],
        'availability_text' => ['contact', 'text'],
        'github_url' => ['social', 'text'],
        'linkedin_url' => ['social', 'text'],
        'twitter_url' => ['social', 'text'],
        'dribbble_url' => ['social', 'text'],
        'years_experience' => ['stats', 'integer'],
        'projects_completed' => ['stats', 'integer'],
        'clients_served' => ['stats', 'integer'],
        'satisfaction_rate' => ['stats', 'integer'],
        'meta_keywords' => ['identity', 'text'],
    ];

    public function index(): View
    {
        $values = Setting::allCached();
        $groups = [
            'identity' => 'Identity',
            'contact' => 'Contact & Availability',
            'social' => 'Social Links',
            'stats' => 'Hero Statistics',
            'media' => 'Media & Assets',
        ];

        return view('admin.settings.index', compact('values', 'groups'));
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach (self::FIELDS as $key => [$group, $type]) {
            Setting::put($key, $data[$key] ?? null, $type, $group);
        }

        if ($request->hasFile('resume')) {
            $oldResume = Setting::get('resume_path');
            $resumePath = $this->storeUpload($request->file('resume'), 'resume');
            Setting::put('resume_path', $resumePath, 'text', 'media');
            $this->deleteUpload(is_string($oldResume) ? $oldResume : null);
        }

        if ($request->hasFile('avatar')) {
            $oldAvatar = Setting::get('avatar_path');
            $avatarPath = $this->storeUpload($request->file('avatar'), 'avatar');
            Setting::put('avatar_path', $avatarPath, 'text', 'media');
            $this->deleteUpload(is_string($oldAvatar) ? $oldAvatar : null);
        }

        Setting::flushCache();

        return redirect()->route('admin.settings.index')->with('success', 'Site settings saved.');
    }
}
