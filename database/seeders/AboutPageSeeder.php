<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutPageSettings;
use App\Models\AboutPageValue;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update about page settings
        AboutPageSettings::updateOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'Over Brug Kreativo',
                'hero_subtitle' => 'Wij verbinden de meest getalenteerde creatievelingen van Curaçao met klanten die op zoek zijn naar unieke en kwalitatieve diensten.',
                'hero_button_text' => 'Word Lid van Onze Community',
                'mission_title' => 'Onze Missie',
                'mission_description_1' => 'Curaçao Talents is ontstaan uit de behoefte om lokale creativiteit te vieren en te ondersteunen. Ons platform biedt een veilige en betrouwbare omgeving waar getalenteerde professionals hun werk kunnen showcasen en waar klanten gemakkelijk de perfecte match kunnen vinden voor hun projecten.',
                'mission_description_2' => 'Van fotografie tot schilderkunst, van muziek tot design - wij geloven dat Curaçao vol zit met ongelooflijk talent dat de erkenning verdient die het verdient.',
                'mission_image_url' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=600&h=400&fit=crop',
                'stat_talents_count' => '500+',
                'stat_talents_label' => 'Geregistreerde Talenten',
                'stat_projects_count' => '1,200+',
                'stat_projects_label' => 'Voltooide Projecten',
                'values_section_title' => 'Onze Waarden',
                'values_section_subtitle' => 'Deze principes vormen de basis van alles wat we doen',
                'is_active' => true,
            ]
        );

        // Create default values
        $values = [
            [
                'icon' => 'users',
                'title' => 'Community First',
                'description' => 'We believe in the power of local community and supporting each other\'s growth.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'target',
                'title' => 'Quality Focus',
                'description' => 'We maintain high standards to ensure the best experience for both creators and clients.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'heart',
                'title' => 'Passion Driven',
                'description' => 'We\'re passionate about showcasing the incredible talent that Curaçao has to offer.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'icon' => 'award',
                'title' => 'Excellence',
                'description' => 'We strive for excellence in everything we do, from our platform to our service.',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($values as $value) {
            AboutPageValue::updateOrCreate(
                ['title' => $value['title']],
                $value
            );
        }

        $this->command->info('About page data seeded successfully!');
    }
}
