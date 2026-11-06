<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed the global site settings.
     */
    public function run(): void
    {
        $settings = [
            ['site_name', 'Portfolio3d', 'text', 'identity'],
            ['site_tagline', 'Software systems. Data stories. Real outcomes.', 'text', 'identity'],
            ['site_description', 'I design and build production-grade software, then turn the data it produces into decisions. A portfolio for teams who care about both craft and evidence.', 'text', 'identity'],
            ['owner_name', 'Jeanluc Mutomb', 'text', 'identity'],
            ['owner_title', 'Software Developer & Data Analyst', 'text', 'identity'],
            ['meta_keywords', 'Laravel developer, data analyst, analytics engineer, portfolio, dashboards, SQL, Python', 'text', 'identity'],
            ['email', 'hello@portfolio3d.test', 'text', 'contact'],
            ['phone', '+254 712 345 678', 'text', 'contact'],
            ['location', 'Nairobi, Kenya · Remote worldwide', 'text', 'contact'],
            ['availability_status', 'available', 'text', 'contact'],
            ['availability_text', 'Available for select projects — Q1 2027', 'text', 'contact'],
            ['github_url', 'https://github.com/jeanlucmutomb', 'text', 'social'],
            ['linkedin_url', 'https://linkedin.com/in/jeanlucmutomb', 'text', 'social'],
            ['twitter_url', 'https://x.com/jeanlucmutomb', 'text', 'social'],
            ['dribbble_url', '', 'text', 'social'],
            ['years_experience', '7', 'integer', 'stats'],
            ['projects_completed', '48', 'integer', 'stats'],
            ['clients_served', '32', 'integer', 'stats'],
            ['satisfaction_rate', '98', 'integer', 'stats'],
            ['resume_path', 'files/resume.pdf', 'text', 'media'],
            ['avatar_path', 'images/avatar.svg', 'text', 'media'],
        ];

        foreach ($settings as [$key, $value, $type, $group]) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => $type, 'group' => $group],
            );
        }

        Setting::flushCache();
    }
}
