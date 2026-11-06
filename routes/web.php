<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactInquiryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects/{portfolio}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/projects/{portfolio}/track', [ProjectController::class, 'click'])
    ->middleware('throttle:60,1')
    ->name('projects.click');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
Route::get('/resume', [HomeController::class, 'resume'])->name('resume');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/metrics', [DashboardController::class, 'metrics'])->name('metrics');

        Route::resource('portfolios', PortfolioController::class)->except('show');
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('skills', SkillController::class)->except('show');
        Route::resource('qualifications', QualificationController::class)->except('show');
        Route::resource('services', ServiceController::class)->except('show');
        Route::resource('reviews', ReviewController::class)->except('show');

        Route::get('/inquiries', [ContactInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}', [ContactInquiryController::class, 'show'])->name('inquiries.show');
        Route::post('/inquiries/{inquiry}/reply', [ContactInquiryController::class, 'reply'])->name('inquiries.reply');
        Route::patch('/inquiries/{inquiry}/status', [ContactInquiryController::class, 'updateStatus'])->name('inquiries.status');
        Route::delete('/inquiries/{inquiry}', [ContactInquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
