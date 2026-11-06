<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\ProjectAnalytic;
use App\Models\SiteVisit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SampleProjectSeeder extends Seeder
{
    /**
     * Seed categories, portfolio case studies and demo analytics.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Software Engineering', 'slug' => 'software-engineering', 'type' => 'software', 'color' => '#00ff9c', 'description' => 'Product engineering, APIs and resilient application architecture.'],
            ['name' => 'Data & Analytics', 'slug' => 'data-analytics', 'type' => 'data', 'color' => '#22d3ee', 'description' => 'Warehouses, pipelines, dashboards and decision science.'],
            ['name' => 'AI & Automation', 'slug' => 'ai-automation', 'type' => 'hybrid', 'color' => '#a78bfa', 'description' => 'Applied machine learning and workflow automation.'],
            ['name' => 'Platform & DevOps', 'slug' => 'platform-devops', 'type' => 'software', 'color' => '#f472b6', 'description' => 'Infrastructure, observability and delivery systems.'],
            ['name' => 'Business Intelligence', 'slug' => 'business-intelligence', 'type' => 'data', 'color' => '#facc15', 'description' => 'Executive reporting and self-serve metric layers.'],
        ];

        foreach ($categories as $index => $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [...$category, 'sort_order' => $index, 'is_active' => true],
            );
        }

        $categoryIds = Category::query()->pluck('id', 'slug');

        $projects = [
            [
                'title' => 'Orbital API Gateway',
                'slug' => 'orbital-api-gateway',
                'category_slug' => 'platform-devops',
                'tagline' => 'A multi-tenant API gateway that cut p95 latency by 63% and absorbed 4x traffic without new servers.',
                'description' => 'Designed and shipped a Laravel-based gateway with token-aware rate limiting, request signing and tenant isolation for a logistics platform moving 2.4M events a day.',
                'content' => <<<'MD'
## The brief

Northstar's fleet API had become a single point of failure. Every tenant shared the same rate-limit bucket, webhook retries were unbounded, and p95 latency crossed 1.8 seconds during peak dispatch windows.

## What I built

- A Laravel 12 gateway with per-tenant token buckets backed by Redis Lua scripts.
- Signed request middleware, replay protection and structured audit trails.
- Circuit breakers around downstream carrier APIs with exponential backoff.
- A queue-based webhook delivery layer with idempotency keys.
- Grafana dashboards tracking saturation, retry volume and tenant fairness.

## Architecture

The gateway sits between edge load balancers and six internal services. Redis handles distributed rate-limit state; PostgreSQL stores tenant policies and audit records. A small Go sidecar handles request signing for legacy services that cannot be touched.

## Outcome

- p95 latency dropped from **1.84s to 680ms**.
- Traffic grew **4x** with no additional application servers.
- Webhook duplicate deliveries fell to **0.02%**.
- Incident pages related to rate limiting dropped to zero over the following quarter.
MD,
                'thumbnail' => 'images/projects/orbital.svg',
                'tech_stack' => ['Laravel', 'PHP 8.5', 'Redis', 'PostgreSQL', 'Docker', 'Grafana'],
                'project_type' => 'software',
                'live_url' => 'https://example.com/orbital',
                'github_url' => 'https://github.com/princemutomb/orbital-gateway',
                'dashboard_url' => null,
                'client' => 'Northstar Logistics',
                'role' => 'Lead Backend Engineer',
                'duration' => '14 weeks',
                'results' => '63% lower p95 latency · 4x traffic headroom · 99.99% gateway availability',
                'is_featured' => true,
                'sort_order' => 1,
                'completed_at' => '2026-06-18',
            ],
            [
                'title' => 'Signal Revenue Intelligence',
                'slug' => 'signal-revenue-intelligence',
                'category_slug' => 'data-analytics',
                'tagline' => 'A revenue warehouse and executive dashboard that surfaced $1.2M in expansion opportunities.',
                'description' => 'Built a dbt + BigQuery semantic layer unifying billing, CRM and product usage data. Delivered a Looker experience that finance and sales actually use every morning.',
                'content' => <<<'MD'
## The brief

Revenue reporting lived in twelve spreadsheets. Sales and finance disagreed on ARR by 8%, and nobody could answer which product behaviours predicted expansion.

## What I built

- A dbt project with 46 models, 120 tests and a documented semantic layer.
- Ingestion jobs from Stripe, HubSpot, Segment and the product event stream.
- A customer health score combining usage depth, support sentiment and billing signals.
- Executive Looker dashboards for ARR motion, net revenue retention and expansion propensity.
- A data quality monitor that alerts the team in Slack before dashboards drift.

## The interesting part

The hardest problem was identity resolution. Three systems described the same customer in three different ways. I built a deterministic matching spine with a confidence-scored fallback, then exposed the match rate as a first-class metric so the business could see data quality instead of arguing about totals.

## Outcome

- ARR definitions reconciled to a **single source of truth**.
- Expansion pipeline identified **$1.2M** in the first two quarters.
- Weekly reporting time dropped from **9 hours to 20 minutes**.
- 92% of the revenue team adopted the dashboard as their default morning view.
MD,
                'thumbnail' => 'images/projects/signal.svg',
                'tech_stack' => ['Python', 'dbt', 'BigQuery', 'Looker', 'SQL', 'Airflow'],
                'project_type' => 'data',
                'live_url' => null,
                'github_url' => 'https://github.com/princemutomb/signal-revenue',
                'dashboard_url' => 'https://example.com/signal-dashboard',
                'client' => 'Signal SaaS',
                'role' => 'Analytics Engineer',
                'duration' => '10 weeks',
                'results' => '$1.2M expansion pipeline · ARR reconciled · 96% dbt test coverage',
                'is_featured' => true,
                'sort_order' => 2,
                'completed_at' => '2026-04-09',
            ],
            [
                'title' => 'Helix Commerce Engine',
                'slug' => 'helix-commerce-engine',
                'category_slug' => 'software-engineering',
                'tagline' => 'A headless commerce core with a 340ms storefront response and a 41% lift in checkout completion.',
                'description' => 'Rebuilt a monolithic storefront into a modular Laravel commerce engine with Livewire, Stripe and an event-driven inventory service.',
                'content' => <<<'MD'
## The brief

Helix was losing checkout sessions to a 4.2 second storefront and an inventory sync that ran once every fifteen minutes. During launches, overselling was routine.

## What I built

- A modular Laravel domain: catalog, cart, checkout, inventory and fulfilment.
- Livewire + Alpine storefront with optimistic UI and server-driven pricing.
- Stripe Payment Intents with idempotent webhooks and retry-safe order finalisation.
- Event-driven inventory reservations using Redis streams.
- A launch-mode feature flag that shields checkout from catalogue re-indexing.

## Outcome

- Storefront TTFB reduced from **1.9s to 340ms**.
- Checkout completion improved **41%**.
- Oversell incidents went from weekly to **zero** across two launch cycles.
- The team now ships catalogue changes without a deploy.
MD,
                'thumbnail' => 'images/projects/helix.svg',
                'tech_stack' => ['Laravel', 'Livewire', 'Alpine.js', 'Stripe', 'MySQL', 'Redis'],
                'project_type' => 'software',
                'live_url' => 'https://example.com/helix',
                'github_url' => 'https://github.com/princemutomb/helix-commerce',
                'dashboard_url' => null,
                'client' => 'Helix Commerce',
                'role' => 'Full-stack Engineer',
                'duration' => '18 weeks',
                'results' => '41% checkout lift · 340ms TTFB · zero oversells in two launches',
                'is_featured' => true,
                'sort_order' => 3,
                'completed_at' => '2025-11-22',
            ],
            [
                'title' => 'Terra Climate Dashboard',
                'slug' => 'terra-climate-dashboard',
                'category_slug' => 'data-analytics',
                'tagline' => 'An interactive climate risk explorer over 40 years of geospatial data.',
                'description' => 'A public-facing analytics product that turns gridded climate data into county-level risk narratives for planners and journalists.',
                'content' => <<<'MD'
## The brief

Terra had forty years of gridded rainfall and temperature data locked in NetCDF files. Researchers could read it; planners could not.

## What I built

- A Python ingestion pipeline converting NetCDF to partitioned Parquet.
- DuckDB queries for sub-second county aggregation without a warehouse bill.
- A Superset dashboard with anomaly maps, seasonal comparisons and downloadable extracts.
- A plain-language "risk brief" generator for non-technical stakeholders.
- A transparent methodology page documenting every transformation.

## Outcome

- 40 years of data queryable in **under 800ms**.
- Used by **14 county planning teams** and three newsrooms.
- Replaced a manual reporting workflow that took **two weeks per region**.
MD,
                'thumbnail' => 'images/projects/terra.svg',
                'tech_stack' => ['Python', 'DuckDB', 'Apache Superset', 'GeoPandas', 'Parquet', 'Polars'],
                'project_type' => 'data',
                'live_url' => null,
                'github_url' => 'https://github.com/princemutomb/terra-climate',
                'dashboard_url' => 'https://example.com/terra-dashboard',
                'client' => 'Terra Analytics',
                'role' => 'Data Product Engineer',
                'duration' => '12 weeks',
                'results' => '40 years queryable in <800ms · 14 planning teams onboarded',
                'is_featured' => false,
                'sort_order' => 4,
                'completed_at' => '2025-08-14',
            ],
            [
                'title' => 'Churn Radar',
                'slug' => 'churn-radar',
                'category_slug' => 'ai-automation',
                'tagline' => 'A churn early-warning system that gives success teams 21 days of lead time.',
                'description' => 'Feature engineering, model selection and a human-in-the-loop intervention workflow for a B2B subscription platform.',
                'content' => <<<'MD'
## The brief

The success team learned about churn when the cancellation email arrived. Leadership wanted prediction, but the team needed something they could actually act on.

## What I built

- A feature store covering usage depth, seat growth, support sentiment and billing friction.
- A gradient-boosted churn model with calibrated probabilities and SHAP explanations.
- A weekly scoring job writing to PostgreSQL and syncing to the CRM.
- A Metabase playbook dashboard showing at-risk accounts and recommended interventions.
- Model monitoring for drift, calibration and segment-level recall.

## Outcome

- Success team gained **21 days average lead time**.
- Intervention win rate reached **28%** for high-risk accounts.
- Churn among targeted accounts fell **11%** year over year.
MD,
                'thumbnail' => 'images/projects/churn.svg',
                'tech_stack' => ['Python', 'scikit-learn', 'PostgreSQL', 'Metabase', 'pandas', 'SHAP'],
                'project_type' => 'data',
                'live_url' => null,
                'github_url' => 'https://github.com/princemutomb/churn-radar',
                'dashboard_url' => 'https://example.com/churn-dashboard',
                'client' => 'Atlas SaaS',
                'role' => 'Data Scientist',
                'duration' => '9 weeks',
                'results' => '21 days lead time · 28% intervention win rate · 11% churn reduction',
                'is_featured' => false,
                'sort_order' => 5,
                'completed_at' => '2025-05-30',
            ],
            [
                'title' => 'PulseOps Observability',
                'slug' => 'pulseops-observability',
                'category_slug' => 'platform-devops',
                'tagline' => 'One pane of glass for traces, queues and business events across a distributed stack.',
                'description' => 'A Laravel + Vue operations console that correlates deploy events with queue lag, error budgets and customer impact.',
                'content' => <<<'MD'
## The brief

PulseOps had dashboards for infrastructure and dashboards for business metrics, but no way to connect a deploy to a spike in failed payments.

## What I built

- A Laravel ingestion API receiving OpenTelemetry spans, queue metrics and deploy markers.
- ClickHouse storage for high-cardinality trace queries.
- A Vue operations console with live tail, service maps and incident timelines.
- Correlation rules that attach business impact to technical anomalies.
- Alert routing with on-call schedules and escalation policies.

## Outcome

- Mean time to detect dropped from **18 minutes to 3 minutes**.
- Mean time to resolve improved **37%**.
- On-call pages reduced by **44%** through smarter alert grouping.
MD,
                'thumbnail' => 'images/projects/pulse.svg',
                'tech_stack' => ['Laravel', 'Vue', 'ClickHouse', 'OpenTelemetry', 'TypeScript', 'Kubernetes'],
                'project_type' => 'software',
                'live_url' => 'https://example.com/pulseops',
                'github_url' => 'https://github.com/princemutomb/pulseops',
                'dashboard_url' => null,
                'client' => 'PulseOps',
                'role' => 'Platform Engineer',
                'duration' => '16 weeks',
                'results' => 'MTTD 18m → 3m · 37% faster resolution · 44% fewer pages',
                'is_featured' => false,
                'sort_order' => 6,
                'completed_at' => '2025-02-11',
            ],
            [
                'title' => 'Retail Funnel 360',
                'slug' => 'retail-funnel-360',
                'category_slug' => 'business-intelligence',
                'tagline' => 'A self-serve funnel model that replaced 30 manual reports with one trusted metric layer.',
                'description' => 'Unified POS, ecommerce and loyalty data into a governed Snowflake model with Power BI dashboards for regional operators.',
                'content' => <<<'MD'
## The brief

Every region had its own definition of a "conversion". Monthly reviews spent more time reconciling numbers than making decisions.

## What I built

- A Snowflake warehouse with conformed dimensions for customer, store, product and channel.
- dbt models with 180 tests and a documented metric dictionary.
- Power BI dashboards for regional operators and an executive summary layer.
- Row-level security so operators see only their region.
- A certification workflow for metrics before they reach executive reporting.

## Outcome

- 30 recurring reports retired.
- Metric disputes dropped to **near zero**.
- Regional operators self-serve **87%** of questions without analyst support.
MD,
                'thumbnail' => 'images/projects/retail.svg',
                'tech_stack' => ['SQL', 'dbt', 'Snowflake', 'Power BI', 'Python', 'Fivetran'],
                'project_type' => 'data',
                'live_url' => null,
                'github_url' => 'https://github.com/princemutomb/retail-funnel',
                'dashboard_url' => 'https://example.com/retail-dashboard',
                'client' => 'Meridian Retail Group',
                'role' => 'BI Lead',
                'duration' => '11 weeks',
                'results' => '30 reports retired · 87% self-serve adoption · governed metric layer',
                'is_featured' => false,
                'sort_order' => 7,
                'completed_at' => '2024-10-04',
            ],
            [
                'title' => 'Atlas Auth Mesh',
                'slug' => 'atlas-auth-mesh',
                'category_slug' => 'software-engineering',
                'tagline' => 'Passwordless authentication for 1.1M users with a 72% passkey adoption rate.',
                'description' => 'A passkey-first identity layer with OAuth2, device trust and a migration path that did not break existing sessions.',
                'content' => <<<'MD'
## The brief

Atlas wanted passwordless login without a risky flag day. The identity layer served web, mobile and partner integrations, and every session mattered.

## What I built

- A Laravel identity service supporting passkeys, magic links and OAuth2.
- Progressive enrolment: passkey prompts after successful legacy logins.
- Device trust scoring with step-up authentication for sensitive actions.
- A transparent migration console showing enrolment by cohort.
- Security event streaming into the existing SIEM.

## Outcome

- **72%** of active users adopted passkeys within five months.
- Account takeover attempts fell **83%**.
- Login support tickets dropped **46%**.
MD,
                'thumbnail' => 'images/projects/atlas.svg',
                'tech_stack' => ['Laravel', 'Passkeys', 'OAuth2', 'Redis', 'MySQL', 'TypeScript'],
                'project_type' => 'software',
                'live_url' => 'https://example.com/atlas-auth',
                'github_url' => 'https://github.com/princemutomb/atlas-auth',
                'dashboard_url' => null,
                'client' => 'Atlas Financial',
                'role' => 'Security Engineer',
                'duration' => '13 weeks',
                'results' => '72% passkey adoption · 83% fewer takeover attempts · 46% fewer tickets',
                'is_featured' => false,
                'sort_order' => 8,
                'completed_at' => '2024-07-19',
            ],
        ];

        foreach ($projects as $project) {
            $categorySlug = $project['category_slug'];
            unset($project['category_slug']);

            Portfolio::query()->updateOrCreate(
                ['slug' => $project['slug']],
                [
                    ...$project,
                    'category_id' => $categoryIds[$categorySlug] ?? null,
                    'is_published' => true,
                ],
            );
        }

        $this->seedAnalytics();
        $this->seedVisits();
    }

    private function seedAnalytics(): void
    {
        if (ProjectAnalytic::query()->exists()) {
            return;
        }

        $projects = Portfolio::query()->get(['id', 'live_url', 'github_url', 'dashboard_url']);
        $rows = [];

        foreach ($projects as $project) {
            $eventCounts = ['view' => random_int(70, 210), 'case_study' => random_int(8, 32)];

            if ($project->live_url) {
                $eventCounts['live'] = random_int(18, 65);
            }

            if ($project->github_url) {
                $eventCounts['github'] = random_int(10, 48);
            }

            if ($project->dashboard_url) {
                $eventCounts['dashboard'] = random_int(22, 80);
            }

            foreach ($eventCounts as $eventType => $count) {
                for ($i = 0; $i < $count; $i++) {
                    $createdAt = Carbon::now()
                        ->subDays(random_int(0, 27))
                        ->subMinutes(random_int(0, 1439));

                    $rows[] = [
                        'portfolio_id' => $project->id,
                        'event_type' => $eventType,
                        'ip_address' => fake()->ipv4(),
                        'user_agent' => fake()->userAgent(),
                        'referrer' => fake()->boolean(35) ? fake()->url() : null,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ];
                }
            }
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('project_analytics')->insert($chunk);
        }
    }

    private function seedVisits(): void
    {
        if (SiteVisit::query()->exists()) {
            return;
        }

        $paths = ['/', '/', '/', '/projects/orbital-api-gateway', '/projects/signal-revenue-intelligence', '/projects/helix-commerce-engine', '/projects/terra-climate-dashboard', '/projects/churn-radar'];
        $rows = [];

        for ($i = 0; $i < 640; $i++) {
            $visitedAt = Carbon::now()
                ->subDays(random_int(0, 13))
                ->subMinutes(random_int(0, 1439));

            $rows[] = [
                'path' => fake()->randomElement($paths),
                'ip_address' => fake()->ipv4(),
                'user_agent' => fake()->userAgent(),
                'referrer' => fake()->boolean(30) ? fake()->randomElement(['https://google.com', 'https://linkedin.com', 'https://github.com', 'https://x.com']) : null,
                'session_id' => fake()->uuid(),
                'created_at' => $visitedAt,
                'updated_at' => $visitedAt,
            ];
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('site_visits')->insert($chunk);
        }
    }
}
