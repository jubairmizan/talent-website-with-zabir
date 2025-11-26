<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactSubmission;

class ContactSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactSubmissions = [
            [
                'name' => 'Jennifer Smith',
                'email' => 'jennifer.smith@email.com',
                'subject' => 'Inquiry about graphic design services',
                'message' => 'Hi there! I\'m looking for a talented graphic designer to help with my startup\'s branding. We need a logo, business cards, and some marketing materials. Could you please provide more information about your services and pricing? I\'d love to schedule a consultation to discuss our project in detail.',
                'status' => 'replied',
                'admin_notes' => 'Responded with portfolio and pricing information. Scheduled follow-up call for next week.',
                'replied_at' => now()->subDays(2),
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'David Johnson',
                'email' => 'david.johnson@company.com',
                'subject' => 'Website development project',
                'message' => 'We are a medium-sized company looking to redesign our website. We need a modern, responsive design with e-commerce functionality. Our current site is outdated and not mobile-friendly. We\'d like to know about your web development services, timeline, and cost estimates for a complete website overhaul.',
                'status' => 'read',
                'admin_notes' => 'Potential high-value client. Need to prepare detailed proposal.',
                'replied_at' => null,
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@gmail.com',
                'subject' => 'Photography services for wedding',
                'message' => 'Hello! My fiancé and I are getting married in June and we\'re looking for a photographer to capture our special day. We love your portfolio and would like to know more about your wedding photography packages. Do you offer engagement sessions as well? We\'d appreciate any information you can provide.',
                'status' => 'unread',
                'admin_notes' => null,
                'replied_at' => null,
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Robert Chen',
                'email' => 'robert.chen@startup.io',
                'subject' => 'Video production for product launch',
                'message' => 'We\'re launching a new tech product next month and need a promotional video. We\'re looking for someone who can handle everything from concept development to final production. The video will be used for our website, social media, and investor presentations. Could you share your video production portfolio and pricing?',
                'status' => 'replied',
                'admin_notes' => 'Sent portfolio and initial quote. Waiting for their feedback on the concept.',
                'replied_at' => now()->subDays(1),
                'created_at' => now()->subDays(4),
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.thompson@nonprofit.org',
                'subject' => 'Content writing for nonprofit',
                'message' => 'Our nonprofit organization needs help with content writing for our website and grant applications. We\'re looking for someone who understands the nonprofit sector and can help us communicate our mission effectively. Do you have experience writing for nonprofits? We\'d love to discuss our needs with you.',
                'status' => 'read',
                'admin_notes' => 'Interested in pro bono work. Schedule call to discuss scope.',
                'replied_at' => null,
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@email.com',
                'subject' => 'General inquiry',
                'message' => 'I came across your work online and I\'m really impressed with your portfolio. I don\'t have a specific project in mind right now, but I wanted to reach out and introduce myself. I run a small business and may need creative services in the future. I\'d love to stay connected.',
                'status' => 'unread',
                'admin_notes' => null,
                'replied_at' => null,
                'created_at' => now()->subHours(12),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@agency.com',
                'subject' => 'Collaboration opportunity',
                'message' => 'Hi! I work at a marketing agency and we often need freelance creatives for our client projects. Your work caught our attention and we\'d like to discuss potential collaboration opportunities. We have several upcoming projects that might be a good fit for your skills. Would you be interested in a partnership?',
                'status' => 'replied',
                'admin_notes' => 'Great opportunity for ongoing work. Sent capabilities deck and rates.',
                'replied_at' => now()->subHours(6),
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'James Miller',
                'email' => 'james.miller@restaurant.com',
                'subject' => 'Menu design and branding',
                'message' => 'We\'re opening a new restaurant and need help with menu design and overall branding. We want something that reflects our farm-to-table concept and appeals to our target demographic. Could you provide examples of restaurant branding work you\'ve done? We\'d also like to know about your process and timeline.',
                'status' => 'unread',
                'admin_notes' => null,
                'replied_at' => null,
                'created_at' => now()->subHours(8),
            ],
        ];

        foreach ($contactSubmissions as $submission) {
            ContactSubmission::create($submission);
        }

        $this->command->info('Contact submissions seeded successfully!');
    }
}