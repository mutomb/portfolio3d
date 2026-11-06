<?php

namespace Database\Seeders;

use App\Models\Qualification;
use App\Models\Review;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Seed skills, qualifications, services and client reviews.
     */
    public function run(): void
    {
        $skills = [
            ['PHP 8.5', 'backend', 97, '#00ff9c', 7, 'Modern PHP, strict types and framework internals.'],
            ['Laravel', 'backend', 98, '#00ff9c', 7, 'Production applications, queues, events and testing.'],
            ['Python', 'backend', 92, '#22d3ee', 6, 'Pipelines, analysis and applied machine learning.'],
            ['Node.js', 'backend', 86, '#84cc16', 5, 'APIs, tooling and event-driven services.'],
            ['Go', 'backend', 74, '#38bdf8', 3, 'High-throughput sidecars and CLI tooling.'],
            ['TypeScript', 'frontend', 90, '#22d3ee', 6, 'Typed product interfaces and design systems.'],
            ['Alpine.js', 'frontend', 94, '#00ff9c', 5, 'Lightweight interactivity without framework overhead.'],
            ['Tailwind CSS', 'frontend', 96, '#38bdf8', 6, 'Design systems, responsive layouts and theming.'],
            ['Vue', 'frontend', 82, '#4ade80', 4, 'Composable dashboards and operations consoles.'],
            ['SQL', 'database', 98, '#facc15', 8, 'Window functions, query tuning and modelling.'],
            ['PostgreSQL', 'database', 93, '#38bdf8', 6, 'Indexing, extensions and transactional design.'],
            ['MySQL', 'database', 90, '#f97316', 7, 'Schema design and production performance.'],
            ['BigQuery', 'database', 88, '#22d3ee', 4, 'Partitioning, cost control and analytical SQL.'],
            ['Snowflake', 'database', 80, '#60a5fa', 3, 'Warehouse modelling and access governance.'],
            ['Redis', 'database', 88, '#ef4444', 6, 'Caching, queues, streams and distributed locks.'],
            ['dbt', 'data', 91, '#f97316', 4, 'Semantic layers, tests and documentation.'],
            ['pandas', 'data', 94, '#a78bfa', 6, 'Exploratory analysis and feature engineering.'],
            ['scikit-learn', 'data', 88, '#f472b6', 4, 'Model selection, calibration and evaluation.'],
            ['Looker', 'data', 86, '#a78bfa', 4, 'LookML, explores and executive reporting.'],
            ['Power BI', 'data', 85, '#facc15', 5, 'DAX, star schemas and row-level security.'],
            ['Metabase', 'data', 84, '#22d3ee', 4, 'Self-serve analytics and embedded questions.'],
            ['Docker', 'devops', 90, '#38bdf8', 6, 'Multi-stage builds and local parity.'],
            ['AWS', 'devops', 84, '#f59e0b', 5, 'ECS, RDS, S3, Lambda and cost tuning.'],
            ['GitHub Actions', 'devops', 88, '#94a3b8', 4, 'CI/CD, matrix builds and release automation.'],
            ['Terraform', 'devops', 76, '#a78bfa', 3, 'Reproducible infrastructure and modules.'],
            ['Git', 'tools', 96, '#f97316', 8, 'Branch strategy, history hygiene and recovery.'],
            ['Figma', 'tools', 72, '#f472b6', 4, 'Design handoff and interface prototyping.'],
            ['Looker Studio', 'tools', 86, '#22d3ee', 4, 'Fast client dashboards and data blending.'],
        ];

        foreach ($skills as $index => [$name, $category, $proficiency, $color, $years, $description]) {
            Skill::query()->updateOrCreate(
                ['name' => $name],
                [
                    'category' => $category,
                    'proficiency' => $proficiency,
                    'color' => $color,
                    'years_experience' => $years,
                    'description' => $description,
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }

        $qualifications = [
            [
                'title' => 'MSc Data Science',
                'institution' => 'Carnegie Mellon University Africa',
                'type' => 'education',
                'description' => 'Focused on applied machine learning, distributed systems and decision science. Thesis on calibrated churn prediction for subscription businesses.',
                'started_at' => '2019-08-01',
                'completed_at' => '2021-06-30',
                'is_current' => false,
                'sort_order' => 1,
            ],
            [
                'title' => 'BSc Computer Science',
                'institution' => 'University of Nairobi',
                'type' => 'education',
                'description' => 'First class honours. Led the student engineering society and built the department\'s first lab booking system.',
                'started_at' => '2014-09-01',
                'completed_at' => '2018-06-30',
                'is_current' => false,
                'sort_order' => 2,
            ],
            [
                'title' => 'AWS Certified Solutions Architect — Professional',
                'institution' => 'Amazon Web Services',
                'type' => 'certification',
                'description' => 'Advanced architecture, migration and cost optimisation across multi-account AWS estates.',
                'started_at' => '2023-03-01',
                'completed_at' => '2023-03-01',
                'is_current' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'dbt Analytics Engineering Certification',
                'institution' => 'dbt Labs',
                'type' => 'certification',
                'description' => 'Dimensional modelling, testing strategy and semantic layer design in dbt.',
                'started_at' => '2024-02-01',
                'completed_at' => '2024-02-01',
                'is_current' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'Google Advanced Data Analytics',
                'institution' => 'Google · Coursera',
                'type' => 'certification',
                'description' => 'Statistical inference, regression, machine learning and storytelling with data.',
                'started_at' => '2022-01-01',
                'completed_at' => '2022-05-01',
                'is_current' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'Data Product of the Year',
                'institution' => 'East Africa Data Summit',
                'type' => 'award',
                'description' => 'Awarded for the Terra Climate Dashboard and its use by county planning teams.',
                'started_at' => '2025-10-01',
                'completed_at' => '2025-10-01',
                'is_current' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($qualifications as $qualification) {
            Qualification::query()->updateOrCreate(
                [
                    'title' => $qualification['title'],
                    'institution' => $qualification['institution'],
                ],
                [...$qualification, 'is_active' => true],
            );
        }

        $services = [
            [
                'title' => 'Full-Stack Product Engineering',
                'slug' => 'full-stack-product-engineering',
                'description' => 'End-to-end product delivery in Laravel, Livewire and Tailwind. From schema design to the last interaction, built to survive real traffic.',
                'icon' => 'code',
                'features' => ['Product discovery and scoping', 'Laravel architecture and APIs', 'Interactive Tailwind interfaces', 'Automated testing and CI/CD', 'Launch support and handover'],
                'price_from' => 4500,
                'delivery_time' => '4–12 weeks',
                'sort_order' => 1,
            ],
            [
                'title' => 'Data Pipeline & Warehouse Architecture',
                'slug' => 'data-pipeline-warehouse-architecture',
                'description' => 'Reliable ingestion, modelling and governance. I build the boring infrastructure that makes analytics trustworthy.',
                'icon' => 'database',
                'features' => ['Source system audits', 'dbt or SQL transformation layers', 'Warehouse cost optimisation', 'Data quality tests and alerts', 'Documentation and metric dictionary'],
                'price_from' => 3800,
                'delivery_time' => '3–10 weeks',
                'sort_order' => 2,
            ],
            [
                'title' => 'Analytics Dashboards & BI',
                'slug' => 'analytics-dashboards-bi',
                'description' => 'Decision-first dashboards for executives and operators. Fewer charts, sharper questions, measurable adoption.',
                'icon' => 'chart',
                'features' => ['Stakeholder interviews', 'Metric definition workshops', 'Looker, Power BI or Metabase builds', 'Self-serve enablement', 'Adoption tracking'],
                'price_from' => 2800,
                'delivery_time' => '2–6 weeks',
                'sort_order' => 3,
            ],
            [
                'title' => 'Technical Audit & Performance Rescue',
                'slug' => 'technical-audit-performance-rescue',
                'description' => 'A focused diagnosis of the bottleneck, followed by a prioritised plan and hands-on fixes. Ideal before a launch or funding round.',
                'icon' => 'shield',
                'features' => ['Application and query profiling', 'Architecture risk review', 'Prioritised remediation plan', 'Hands-on critical fixes', 'Executive-ready summary'],
                'price_from' => 1800,
                'delivery_time' => '1–3 weeks',
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                [...$service, 'is_active' => true],
            );
        }

        $reviews = [
            [
                'client_name' => 'Amara Okafor',
                'client_role' => 'VP Engineering',
                'company' => 'Northstar Logistics',
                'content' => 'Jeanluc found the failure mode our team had been chasing for months. The gateway redesign was delivered ahead of schedule and the observability work means we now see problems before customers do.',
                'rating' => 5,
                'project_url' => 'https://example.com/orbital',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Daniel Mwangi',
                'client_role' => 'Head of Data',
                'company' => 'Terra Analytics',
                'content' => 'Rare combination: writes production Python, models the warehouse properly, and can explain the output to a county planner. The climate dashboard changed how our partners make decisions.',
                'rating' => 5,
                'project_url' => 'https://example.com/terra-dashboard',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Sofia Reyes',
                'client_role' => 'Product Lead',
                'company' => 'Helix Commerce',
                'content' => 'Our checkout conversion moved 41% in one quarter. What impressed me most was the calm, evidence-led approach during launch week — no heroics, just a system that held.',
                'rating' => 5,
                'project_url' => 'https://example.com/helix',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'James Kariuki',
                'client_role' => 'Chief Technology Officer',
                'company' => 'Atlas Financial',
                'content' => 'Security work is usually invisible until it goes wrong. Jeanluc made the migration visible, measurable and safe. Passkey adoption beat our internal target by 22 points.',
                'rating' => 5,
                'project_url' => 'https://example.com/atlas-auth',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'client_name' => 'Elena Petrova',
                'client_role' => 'Founder',
                'company' => 'PulseOps',
                'content' => 'We went from four dashboards and a prayer to a single operational picture. The on-call load dropped immediately, and the team finally trusts the alerts.',
                'rating' => 5,
                'project_url' => 'https://example.com/pulseops',
                'is_featured' => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($reviews as $review) {
            Review::query()->updateOrCreate(
                [
                    'client_name' => $review['client_name'],
                    'company' => $review['company'],
                ],
                [...$review, 'is_active' => true],
            );
        }
    }
}
