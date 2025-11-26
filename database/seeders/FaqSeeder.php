<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I create an account as a creator?',
                'answer' => 'To create a creator account, click on the "Sign Up" button and select "Join as Creator". Fill out the registration form with your personal information, upload a profile picture, and complete your creator profile with your portfolio, skills, and experience. Once submitted, our team will review your application and activate your account within 24-48 hours.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'What types of services can I offer as a creator?',
                'answer' => 'Our platform supports a wide range of creative services including graphic design, web development, photography, video production, content writing, digital marketing, illustration, animation, UI/UX design, and many more. You can showcase multiple skills and services in your profile to attract diverse clients.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'How does the payment system work?',
                'answer' => 'We use a secure escrow payment system. When a client hires you, they deposit the project payment into escrow. You receive the payment once the project is completed and approved by the client. We charge a small service fee from each transaction. Payments are processed weekly and can be withdrawn to your bank account or PayPal.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'How can I improve my profile visibility?',
                'answer' => 'To improve your profile visibility: 1) Complete your profile 100% with detailed descriptions, portfolio samples, and skills. 2) Upload high-quality work samples. 3) Maintain a high rating by delivering quality work on time. 4) Be active on the platform and respond quickly to messages. 5) Consider upgrading to a premium membership for enhanced visibility.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'What should I include in my portfolio?',
                'answer' => 'Your portfolio should showcase your best work that represents your skills and style. Include 5-10 high-quality samples that demonstrate variety in your work. For each piece, provide context about the project, your role, and the results achieved. Make sure images are high-resolution and properly formatted. Update your portfolio regularly with new work.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'How do I communicate with potential clients?',
                'answer' => 'Our platform provides a built-in messaging system for secure communication with clients. You can discuss project details, share files, and negotiate terms directly through our platform. We recommend keeping all communication on-platform for security and dispute resolution purposes. Response time affects your profile rating, so try to respond within 24 hours.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'What happens if there\'s a dispute with a client?',
                'answer' => 'If you encounter a dispute with a client, first try to resolve it through direct communication. If that doesn\'t work, you can escalate the issue to our support team. We have a fair dispute resolution process that reviews all communication and project details. Our team will mediate and make a decision based on the evidence provided by both parties.',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Can I set my own prices for services?',
                'answer' => 'Yes, you have full control over your pricing. You can set different rates for different types of projects, offer package deals, or quote custom prices based on project complexity. We recommend researching market rates and positioning your prices competitively based on your experience level and the value you provide.',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'How do I get my first client on the platform?',
                'answer' => 'To get your first client: 1) Complete your profile thoroughly with compelling descriptions and portfolio samples. 2) Set competitive introductory rates. 3) Apply to relevant job postings quickly and with personalized proposals. 4) Consider offering a small discount for your first few projects to build reviews. 5) Be professional and responsive in all communications.',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'question' => 'What are the platform fees and charges?',
                'answer' => 'We charge a service fee of 10% on all completed transactions for basic members and 5% for premium members. This fee covers payment processing, platform maintenance, customer support, and dispute resolution services. There are no upfront costs or monthly fees for basic membership. Premium membership is available for enhanced features and lower transaction fees.',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'question' => 'How can I build long-term relationships with clients?',
                'answer' => 'Building long-term client relationships requires: 1) Consistently delivering high-quality work on time. 2) Maintaining clear and professional communication. 3) Being proactive about project updates and potential issues. 4) Going above and beyond client expectations when possible. 5) Following up after project completion to ensure satisfaction. 6) Offering ongoing support and maintenance services.',
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'question' => 'Is there customer support available?',
                'answer' => 'Yes, we provide comprehensive customer support through multiple channels. You can reach our support team via email, live chat, or through the help center. Our support hours are Monday to Friday, 9 AM to 6 PM EST. We also have an extensive knowledge base with tutorials, guides, and frequently asked questions to help you navigate the platform successfully.',
                'sort_order' => 12,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('FAQs seeded successfully!');
    }
}