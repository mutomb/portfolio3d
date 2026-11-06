# Portfolio3d 🛰️

**A spatial portfolio and private control center for software and data work.**

Portfolio3d is a personal site and admin platform for professionals (software developer/data analyst) who builds production systems and the analytics layers that make them measurable. The public side is a terminal-flavoured, dark-neon portfolio: typewriter hero, interactive stack matrix, filterable case studies and a contact terminal. The private side is a full control center: content CRUD, visit and click analytics, an inquiry inbox with replies, and site-wide settings.

No page builder. No third-party analytics. No starter-kit bloat. Just a small Laravel monolith that measures itself honestly.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=flat-square&logo=alpinedotjs&logoColor=white)
![Pest](https://img.shields.io/badge/Pest-5-22C55E?style=flat-square)

---
## Features Overview
 Public Side (Terminal-Style Portfolio)

• Theme: Dark-neon, terminal-inspired design.
• Hero: Typewriter animation effect.
• Stack: Interactive technology matrix.
• Projects: Filterable professional case studies.
• Contact: Embedded terminal-style communications form.

🔐 Private Side (Admin Control Center)

• Content: Full CRUD management system.
• Analytics: Real-time visitor and click tracking.
• Inbox: Inquiry management portal with reply functionality.
• Settings: Comprehensive, site-wide configuration panel.

### Features Details

- **Terminal-First Public Site:** Typewriter hero, availability signal, quick actions and reveal-on-scroll sections. A `Ctrl/Cmd + K` command palette handles section jumps and utility commands like `help`, `whoami`, `resume` and `admin`.
- **Interactive Stack Matrix:** 28 tools across 6 disciplines with category filters, proficiency bars, years-of-use metadata and live depth statistics.
- **Case Study Engine:** Filterable showcase (all, featured, software, data) backed by categories, featured ordering and Markdown case studies rendered with `Str::markdown`. Related projects are scoped by discipline.
- **Privacy-First Signal Tracking:** Case-study views are recorded once per session, and outbound live/GitHub/dashboard clicks are captured with a CSRF-protected `fetch` keepalive. No cookies, advertising pixels or third parties — admin traffic is excluded automatically.
- **Contact Terminal:** Alpine inline validation paired with server-side FormRequest rules, a hidden honeypot field, a 5-requests-per-minute throttle, IP/user-agent capture and a queued notification email.
- **Admin Control Center:** Custom session authentication (no starter kit) with an `is_admin` flag, a dedicated `admin` middleware, 6-attempts-per-minute login throttling and session regeneration. The dashboard shows 14-day visit and inquiry charts, a click-through leaderboard, recent visits and the latest inbox.
- **Live Metrics:** Dashboard totals refresh every 20 seconds from a JSON endpoint, with graceful fallbacks if the request fails.
- **Full Content CRUD:** Projects, categories, skills, qualifications, services and reviews are all editable. Settings and the admin profile are managed from the same control center.
- **Inquiry Workflow:** Read/unread states, status filters, queued email replies, status changes, deletion and an unread badge in the admin navigation.
- **Media Uploads:** Project thumbnails, resume files and avatars are validated by MIME type and size, then stored on a dedicated `uploads` disk rooted at `public/uploads` — no storage symlink required on Windows.
- **Cached Settings Layer:** Settings are typed, grouped and cached forever, with automatic cache flushing on write. A Blade view composer exposes them as `$site` with safe defaults if the database is unavailable.
- **Cohesive Design System:** Dark glassmorphism with matrix green, electric cyan and deep slate. Space Grotesk for prose, JetBrains Mono for code, custom Tailwind v4 theme tokens and reduced-motion support.

---

## Main Technologies

- **Framework:** Laravel 13 (monolith structure)
- **Language:** PHP 8.3+ (typed models, attribute-based fillable rules and dedicated form requests)
- **Frontend:** Blade components, Tailwind CSS v4, Alpine.js 3, Vite 8
- **Database:** SQLite (local development default), MySQL/PostgreSQL compatible
- **Queue & Cache:** Database drivers; mail is written to the log locally
- **Testing Suite:** Pest 5 with 12 feature tests and 88 assertions
- **Media Storage:** Local `uploads` disk at `public/uploads`

---

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer
- Node.js 20+ & npm

### Installation Option A: Using Laravel Herd (Recommended)

1. **Clone the repository into your Herd directory:**
   ```bash
   cd %USERPROFILE%\Herd
   git clone <your-repository-url> portfolio3d
   cd portfolio3d
   ```

2. **Install project dependencies:**
   ```bash
   herd composer install
   npm install
   ```

3. **Configure environment settings:**
   ```bash
   copy .env.example .env
   herd php artisan key:generate
   ```
   On macOS/Linux, use `cp .env.example .env` instead.

4. **Prepare the local database:**
   ```bash
   if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite }
   herd php artisan migrate --seed
   ```
   On macOS/Linux, use `touch database/database.sqlite`.

5. **Compile project assets:**
   ```bash
   npm run build
   ```
   In Windows PowerShell, use `npm.cmd run build` if script execution is blocked.

6. **Access the application:**
   The site is automatically served locally via Herd at:  
   `http://portfolio3d.test`

---

### Installation Option B: Using the Standard Artisan Server

1. **Clone the repository:**
   ```bash
   git clone <your-repository-url> portfolio3d
   cd portfolio3d
   ```

2. **Install project dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment settings:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Prepare the local database:**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Compile project assets:**
   ```bash
   npm run build
   ```

6. **Serve the application:**
   ```bash
   php artisan serve
   ```
   Open the application interface environment locally at:  
   `http://localhost:8000`

---

### Local Development

Run the full development stack (HTTP server, queue worker and Vite) with:

```bash
composer dev
```

Or run the pieces separately:

```bash
php artisan serve
php artisan queue:work
npm run dev
```

Queued mail uses the `log` driver by default, so inquiry notifications are written to `storage/logs/laravel.log` until a real mail transport is configured in `.env`.

---

## Demo Account

The local seeder configures the site owner and a working admin account so the control center is immediately usable:

- **URL:** `http://portfolio3d.test/login`
- **Email:** `admin@portfolio3d.test`
- **Password:** `password`

The seeders also populate a realistic preview: 8 case studies, 5 categories, 28 skills, 6 qualifications, 4 services, 5 client reviews, 7 inquiries, 21 settings and demo visit/click analytics.

---

## Running Tests

Automated feature coverage validates public pages, click tracking, contact validation, admin authentication, CRUD for every resource, settings and profile updates, inquiry replies and media uploads:

```bash
php artisan test
```

Or via Composer:

```bash
composer test
```

---

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/        Public site, auth and admin controllers
│   ├── Middleware/         Admin guard and site-visit tracking
│   └── Requests/           Form validation for every resource
├── Mail/                   Queued inquiry and reply mailables
└── Models/                 Portfolios, skills, inquiries, settings, analytics

database/
├── migrations/             Full schema, including site visits and analytics
└── seeders/                Demo owner, content, inquiries and settings

resources/
├── css/app.css             Tailwind v4 theme tokens and component classes
├── js/app.js               Alpine components, tracking and reveal animations
└── views/                  Public sections, case studies, auth and admin panel

routes/web.php              Public, auth and admin route definitions
tests/Feature/              End-to-end Pest coverage
```

---

## Security & Privacy

- **Manual, Minimal Authentication:** No starter kit or hidden auth package. Login uses Laravel's core guards, regenerates the session on success and fully invalidates it on logout. Non-admin accounts are rejected even with valid credentials.
- **Server-Side Authorization:** Every admin route is protected by the `auth` and `admin` middleware, and form requests re-check `isAdmin()` instead of trusting hidden UI controls.
- **Abuse Controls:** Login is limited to 6 attempts per minute, contact submissions to 5 per minute and click tracking to 60 per minute. The contact form also includes a hidden honeypot field.
- **Data Minimization:** Analytics store only the path, IP address, user agent, referrer and session identifier needed for aggregate reporting. There are no tracking cookies, fingerprinting scripts or third-party pixels, and admin traffic is never counted.
- **Fail-Safe Instrumentation:** Analytics writes are wrapped in `try/catch` so a tracking failure can never interrupt a visitor's request.
- **Upload Validation:** Media is restricted by MIME type and size before being written to the public `uploads` disk.
- **CSRF & XSS Hygiene:** Laravel's CSRF protection covers all state-changing requests, Blade escapes output by default and Markdown case studies are rendered through the framework's sanitized Markdown pipeline.
