<?php

namespace App\Providers;

use App\Models\ContactInquiry;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.*', function ($view): void {
            $view->with('site', $this->siteSettings());
        });

        View::composer('layouts.admin', function ($view): void {
            try {
                $view->with('adminUnreadCount', ContactInquiry::query()->unread()->count());
            } catch (Throwable) {
                $view->with('adminUnreadCount', 0);
            }
        });
    }

    /**
     * @return array<string, mixed>
     */
    private function siteSettings(): array
    {
        $defaults = [
            'site_name' => 'Portfolio3d',
            'site_tagline' => 'Software systems. Data stories. Real outcomes.',
            'site_description' => 'A portfolio for software engineering and data analytics work.',
            'owner_name' => 'Jeanluc Mutomb',
            'owner_title' => 'Software Developer & Data Analyst',
            'email' => 'hello@portfolio3d.test',
            'phone' => null,
            'location' => 'Nairobi, Kenya · Remote worldwide',
            'availability_status' => 'available',
            'availability_text' => 'Available for select projects',
            'github_url' => null,
            'linkedin_url' => null,
            'twitter_url' => null,
            'dribbble_url' => null,
            'years_experience' => 7,
            'projects_completed' => 48,
            'clients_served' => 32,
            'satisfaction_rate' => 98,
            'meta_keywords' => 'software developer, data analyst, portfolio',
            'resume_path' => null,
            'avatar_path' => 'images/avatar.svg',
        ];

        try {
            return [...$defaults, ...Setting::allCached()];
        } catch (Throwable) {
            return $defaults;
        }
    }
}
