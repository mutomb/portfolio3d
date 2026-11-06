<?php

use App\Models\Category;
use App\Models\ContactInquiry;
use App\Models\Portfolio;
use App\Models\Qualification;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

function admin(): User
{
    return User::factory()->create(['is_admin' => true]);
}

function portfolio(): Portfolio
{
    $category = Category::create([
        'name' => 'Engineering',
        'slug' => 'engineering',
        'type' => 'software',
        'color' => '#22d3ee',
        'is_active' => true,
    ]);

    return Portfolio::create([
        'category_id' => $category->id,
        'title' => 'Test Project',
        'slug' => 'test-project',
        'tagline' => 'A test project',
        'description' => 'Description',
        'content' => '## Case study',
        'tech_stack' => ['Laravel'],
        'project_type' => 'software',
        'is_published' => true,
    ]);
}

it('renders the public homepage and case study', function () {
    $project = portfolio();

    $this->get('/')->assertOk()->assertSee('Test Project');
    $this->get('/projects/'.$project->slug)->assertOk()->assertSee('Case study');
});

it('tracks project clicks', function () {
    $project = portfolio();

    $this->postJson('/projects/'.$project->slug.'/track', ['event_type' => 'live'])
        ->assertOk()
        ->assertJson(['tracked' => true]);

    expect($project->analytics()->where('event_type', 'live')->exists())->toBeTrue();
});

it('validates and stores contact inquiries', function () {
    $this->post('/contact', [])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

    $this->post('/contact', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'Project inquiry',
        'message' => 'I would like to discuss a new project with you.',
    ])->assertRedirect();

    expect(ContactInquiry::where('email', 'jane@example.com')->exists())->toBeTrue();
});

it('guests cannot access admin routes', function () {
    $this->get('/admin')->assertRedirect('/login');
});

it('admin can view every admin page', function () {
    $user = admin();
    $project = portfolio();
    $inquiry = ContactInquiry::create([
        'name' => 'Jane', 'email' => 'jane@example.com', 'subject' => 'Hi', 'message' => 'Hello there',
    ]);

    $paths = [
        '/admin',
        '/admin/portfolios',
        '/admin/portfolios/create',
        '/admin/portfolios/'.$project->slug.'/edit',
        '/admin/categories',
        '/admin/categories/create',
        '/admin/skills',
        '/admin/skills/create',
        '/admin/qualifications',
        '/admin/qualifications/create',
        '/admin/services',
        '/admin/services/create',
        '/admin/reviews',
        '/admin/reviews/create',
        '/admin/inquiries',
        '/admin/inquiries/'.$inquiry->id,
        '/admin/settings',
        '/admin/profile',
    ];

    foreach ($paths as $path) {
        $this->actingAs($user)->get($path)->assertOk();
    }
});

it('admin can create update and delete a project', function () {
    $user = admin();
    $category = Category::create([
        'name' => 'Data', 'slug' => 'data', 'type' => 'data', 'color' => '#a3e635', 'is_active' => true,
    ]);

    $payload = [
        'category_id' => $category->id,
        'title' => 'New Project',
        'slug' => 'new-project',
        'tagline' => 'Tagline',
        'description' => 'Description',
        'content' => 'Content',
        'tech_stack' => 'Laravel, Vue',
        'project_type' => 'data',
        'is_featured' => '1',
        'is_published' => '1',
        'sort_order' => 1,
    ];

    $this->actingAs($user)->post('/admin/portfolios', $payload)->assertRedirect('/admin/portfolios');
    $project = Portfolio::where('slug', 'new-project')->firstOrFail();
    expect($project->tech_stack)->toBe(['Laravel', 'Vue']);

    $payload['title'] = 'Updated Project';
    $this->actingAs($user)->put('/admin/portfolios/'.$project->slug, $payload)->assertRedirect('/admin/portfolios');
    expect($project->fresh()->title)->toBe('Updated Project');

    $this->actingAs($user)->delete('/admin/portfolios/'.$project->slug)->assertRedirect('/admin/portfolios');
    expect(Portfolio::find($project->id))->toBeNull();
});

it('admin can manage every other resource', function () {
    $user = admin();

    $this->actingAs($user)->post('/admin/categories', [
        'name' => 'QA', 'slug' => 'qa', 'type' => 'hybrid', 'color' => '#22d3ee',
    ])->assertRedirect('/admin/categories');
    $category = Category::where('slug', 'qa')->firstOrFail();

    $this->actingAs($user)->put('/admin/categories/'.$category->id, [
        'name' => 'QA Updated', 'slug' => 'qa', 'type' => 'hybrid', 'color' => '#22d3ee',
    ])->assertRedirect('/admin/categories');

    $this->actingAs($user)->post('/admin/skills', [
        'name' => 'Laravel', 'category' => array_key_first(Skill::CATEGORIES), 'proficiency' => 90, 'color' => '#22d3ee',
    ])->assertRedirect('/admin/skills');
    $skill = Skill::where('name', 'Laravel')->firstOrFail();

    $this->actingAs($user)->post('/admin/qualifications', [
        'title' => 'BSc Computer Science', 'institution' => 'University', 'type' => 'education',
        'started_at' => '2018-01-01', 'completed_at' => '2022-01-01',
    ])->assertRedirect('/admin/qualifications');
    $qualification = Qualification::firstOrFail();

    $this->actingAs($user)->post('/admin/services', [
        'title' => 'Web Development', 'description' => 'Building web apps', 'icon' => 'code',
        'price_from' => 1000, 'delivery_time' => '2 weeks',
    ])->assertRedirect('/admin/services');
    $service = Service::firstOrFail();

    $this->actingAs($user)->post('/admin/reviews', [
        'client_name' => 'Jane', 'client_role' => 'CEO', 'company' => 'Acme',
        'rating' => 5, 'content' => 'Excellent work', 'is_featured' => '1',
    ])->assertRedirect('/admin/reviews');
    $review = Review::firstOrFail();

    $this->actingAs($user)->delete('/admin/skills/'.$skill->id)->assertRedirect('/admin/skills');
    $this->actingAs($user)->delete('/admin/qualifications/'.$qualification->id)->assertRedirect('/admin/qualifications');
    $this->actingAs($user)->delete('/admin/services/'.$service->id)->assertRedirect('/admin/services');
    $this->actingAs($user)->delete('/admin/reviews/'.$review->id)->assertRedirect('/admin/reviews');
    $this->actingAs($user)->delete('/admin/categories/'.$category->id)->assertRedirect('/admin/categories');
});

it('admin can update settings and profile', function () {
    $user = admin();

    $this->actingAs($user)->put('/admin/settings', [
        'site_name' => 'Portfolio3d',
        'site_tagline' => 'Spatial engineering',
        'site_description' => 'A portfolio',
        'owner_name' => 'Jeanluc',
        'owner_title' => 'Engineer',
        'email' => 'hello@example.com',
        'availability_status' => 'available',
        'availability_text' => 'Open for work',
        'years_experience' => 5,
        'projects_completed' => 40,
        'clients_served' => 20,
        'satisfaction_rate' => 98,
    ])->assertRedirect('/admin/settings');

    expect(Setting::get('site_name'))->toBe('Portfolio3d');

    $this->actingAs($user)->put('/admin/profile', [
        'name' => 'Jeanluc Updated',
        'email' => 'jeanluc@example.com',
    ])->assertRedirect('/admin/profile');

    expect($user->fresh()->name)->toBe('Jeanluc Updated');
});

it('admin can upload project, settings and profile media', function () {
    Storage::fake('uploads');

    $user = admin();
    $category = Category::create([
        'name' => 'Media', 'slug' => 'media', 'type' => 'software', 'color' => '#22d3ee', 'is_active' => true,
    ]);

    $this->actingAs($user)->post('/admin/portfolios', [
        'category_id' => $category->id,
        'title' => 'Media Project',
        'slug' => 'media-project',
        'tagline' => 'Tagline',
        'description' => 'Description',
        'project_type' => 'software',
        'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
        'is_published' => '1',
    ])->assertRedirect('/admin/portfolios');

    $project = Portfolio::where('slug', 'media-project')->firstOrFail();
    expect($project->thumbnail)->not->toBeNull();
    Storage::disk('uploads')->assertExists($project->thumbnail);

    $this->actingAs($user)->put('/admin/settings', [
        'site_name' => 'Portfolio3d',
        'site_tagline' => 'Spatial engineering',
        'site_description' => 'A portfolio',
        'owner_name' => 'Jeanluc',
        'owner_title' => 'Engineer',
        'email' => 'hello@example.com',
        'availability_status' => 'available',
        'availability_text' => 'Open for work',
        'years_experience' => 5,
        'projects_completed' => 40,
        'clients_served' => 20,
        'satisfaction_rate' => 98,
        'resume' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ])->assertRedirect('/admin/settings');

    Storage::disk('uploads')->assertExists(Setting::get('resume_path'));
    Storage::disk('uploads')->assertExists(Setting::get('avatar_path'));

    $this->actingAs($user)->put('/admin/profile', [
        'name' => 'Jeanluc',
        'email' => 'jeanluc@example.com',
        'avatar' => UploadedFile::fake()->image('profile.jpg'),
    ])->assertRedirect('/admin/profile');

    Storage::disk('uploads')->assertExists($user->fresh()->avatar);
});

it('admin can reply to and update an inquiry', function () {
    $user = admin();
    $inquiry = ContactInquiry::create([
        'name' => 'Jane', 'email' => 'jane@example.com', 'subject' => 'Hi', 'message' => 'Hello there',
    ]);

    $this->actingAs($user)->post('/admin/inquiries/'.$inquiry->id.'/reply', [
        'reply_message' => 'Thanks for reaching out, I will follow up shortly.',
    ])->assertRedirect();

    expect($inquiry->fresh()->replied_at)->not->toBeNull();

    $this->actingAs($user)->patch('/admin/inquiries/'.$inquiry->id.'/status', [
        'status' => 'read',
    ])->assertRedirect();

    expect($inquiry->fresh()->status)->toBe('read');
});
