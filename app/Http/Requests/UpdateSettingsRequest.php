<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:80'],
            'site_tagline' => ['required', 'string', 'max:160'],
            'site_description' => ['required', 'string', 'max:500'],
            'owner_name' => ['required', 'string', 'max:120'],
            'owner_title' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:120'],
            'availability_status' => ['required', 'in:available,limited,unavailable'],
            'availability_text' => ['required', 'string', 'max:160'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'dribbble_url' => ['nullable', 'url', 'max:255'],
            'years_experience' => ['required', 'integer', 'min:0', 'max:60'],
            'projects_completed' => ['required', 'integer', 'min:0', 'max:10000'],
            'clients_served' => ['required', 'integer', 'min:0', 'max:10000'],
            'satisfaction_rate' => ['required', 'integer', 'min:0', 'max:100'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
