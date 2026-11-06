<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@portfolio3d.test'],
            [
                'name' => 'Jeanluc Mutomb',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'title' => 'Software Developer & Data Analyst',
                'bio' => 'I build software that produces trustworthy data, and data products that change decisions. Currently focused on Laravel platforms, analytics engineering and applied machine learning.',
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );

        $this->call([
            SettingSeeder::class,
            SampleProjectSeeder::class,
            ContentSeeder::class,
            InquirySeeder::class,
        ]);
    }
}
