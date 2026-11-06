<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InquirySeeder extends Seeder
{
    /**
     * Seed realistic inbound inquiries for the lead manager.
     */
    public function run(): void
    {
        $inquiries = [
            [
                'name' => 'Maya Chen',
                'email' => 'maya.chen@northwind.io',
                'subject' => 'Data warehouse migration — Q1 timeline',
                'message' => "Hi Jeanluc,\n\nWe are moving from a legacy MySQL reporting stack to BigQuery and need help designing the transformation layer. We have roughly 40 source tables and a small internal team. Are you available for a scoping call next week?\n\nThanks,\nMaya",
                'budget' => '$10k–$25k',
                'status' => 'new',
                'created_at' => Carbon::now()->subHours(3),
            ],
            [
                'name' => 'Tunde Adeyemi',
                'email' => 'tunde@fleetline.africa',
                'subject' => 'Laravel API performance review',
                'message' => "Our Laravel API slows down badly around 200 concurrent requests. We have tried adding servers but the database is still the bottleneck. Looking for a short audit and a fix plan before our funding round.",
                'budget' => '$5k–$10k',
                'status' => 'new',
                'created_at' => Carbon::now()->subHours(9),
            ],
            [
                'name' => 'Hannah Brooks',
                'email' => 'hannah.brooks@meridian.co',
                'subject' => 'Executive dashboard redesign',
                'message' => "We have a Power BI estate that leadership does not use. The numbers are probably right but the story is not. Would love to talk about a decision-first redesign and a metric dictionary.",
                'budget' => '$5k–$10k',
                'status' => 'read',
                'read_at' => Carbon::now()->subHours(20),
                'created_at' => Carbon::now()->subDay(),
            ],
            [
                'name' => 'Luis Ortega',
                'email' => 'luis@orbitalpay.com',
                'subject' => 'Passkey rollout for a fintech product',
                'message' => "We saw your Atlas Auth case study. We are a fintech with 300k users and want to add passkeys without disrupting existing sessions. Do you take on implementation work, or advisory only?",
                'budget' => '$25k+',
                'status' => 'replied',
                'read_at' => Carbon::now()->subDays(3),
                'replied_at' => Carbon::now()->subDays(2),
                'reply_message' => "Hi Luis,\n\nThanks for reaching out. I do both implementation and advisory work. For a 300k-user migration the safest path is progressive enrolment: passkeys as an upgrade after successful legacy login, with step-up authentication for sensitive actions.\n\nI have capacity for a discovery call next Tuesday or Thursday. Would either work for you?\n\nBest,\nJeanluc",
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'name' => 'Priya Nair',
                'email' => 'priya@lumenhealth.org',
                'subject' => 'Churn model for a healthcare subscription',
                'message' => "We have 18 months of product usage data and a success team of four. Leadership wants churn prediction, but the team needs something actionable rather than another score. Could we discuss a small pilot?",
                'budget' => '$10k–$25k',
                'status' => 'replied',
                'read_at' => Carbon::now()->subDays(6),
                'replied_at' => Carbon::now()->subDays(5),
                'reply_message' => "Hi Priya,\n\nA pilot makes sense. I would start with a two-week discovery: define the churn event, audit the usage data, and build a baseline model with explanations. The deliverable would include an intervention playbook the success team can run without an analyst in the loop.\n\nHappy to send a short scope document.\n\nBest,\nJeanluc",
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Noah Williams',
                'email' => 'noah@stackforge.dev',
                'subject' => 'Podcast: building analytics products',
                'message' => "I host a small podcast for technical founders. Would you be open to a 45-minute conversation about building analytics products that people actually use? No pitch, just a good conversation.",
                'budget' => null,
                'status' => 'read',
                'read_at' => Carbon::now()->subDays(8),
                'created_at' => Carbon::now()->subDays(9),
            ],
            [
                'name' => 'Aisha Rahman',
                'email' => 'aisha@civicdata.org',
                'subject' => 'Pro bono dashboard for a civic dataset',
                'message' => "We are a small civic tech nonprofit with a public transport dataset and no budget for a full engagement. If you ever have capacity for a small pro bono project, we would love to talk.",
                'budget' => 'Pro bono',
                'status' => 'archived',
                'read_at' => Carbon::now()->subDays(20),
                'created_at' => Carbon::now()->subDays(22),
            ],
        ];

        foreach ($inquiries as $inquiry) {
            ContactInquiry::query()->updateOrCreate(
                ['email' => $inquiry['email'], 'subject' => $inquiry['subject']],
                [
                    ...$inquiry,
                    'ip_address' => fake()->ipv4(),
                    'user_agent' => fake()->userAgent(),
                ],
            );
        }
    }
}
