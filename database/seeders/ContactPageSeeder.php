<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactPageSettings;
use App\Models\ContactPageFaq;

class ContactPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update contact page settings
        ContactPageSettings::updateOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'Contact Ons',
                'hero_subtitle' => 'Heb je vragen, suggesties of wil je meer weten over Curaçao Talents? We horen graag van je!',
                'form_section_title' => 'Stuur Ons Een Bericht',
                'form_section_subtitle' => 'Vul het formulier in en we nemen zo snel mogelijk contact met je op.',
                'form_button_text' => 'Verstuur Bericht',
                'success_title' => 'Bericht Verzonden!',
                'success_message' => 'Bedankt voor je bericht. We nemen binnen 24 uur contact met je op.',
                'success_button_text' => 'Nieuw Bericht Versturen',
                'contact_info_title' => 'Contact Informatie',
                'contact_address' => 'Willemstad, Curaçao',
                'contact_email' => 'info@brugkreativo.com',
                'contact_phone' => '+59995109456',
                'contact_hours' => "Maandag - Vrijdag: 9:00 - 17:00\nWeekend: 10:00 - 14:00",
                'faq_section_title' => 'Veelgestelde Vragen',
                'is_active' => true,
            ]
        );

        // Create default FAQs
        $faqs = [
            [
                'question' => 'Hoe kan ik lid worden van Curaçao Talents?',
                'answer' => 'Klik op "Registreren" en kies of je je wilt aanmelden als gebruiker of creator. Het aanmelden is gratis!',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Zijn er kosten verbonden aan het platform?',
                'answer' => 'Registreren is gratis. We hanteren alleen een kleine commissie op voltooide projecten.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Hoe word ik geverifieerd als creator?',
                'answer' => 'Na registratie controleren we je profiel en portfolio. Dit proces duurt meestal 1-2 werkdagen.',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            ContactPageFaq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }

        $this->command->info('Contact page data seeded successfully!');
    }
}
