<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create blog categories first
        $categories = [
            [
                'name' => 'Lokale Kunst',
                'slug' => 'lokale-kunst',
                'description' => 'Ontdek de rijke kunsttraditie van Curaçao en haar talentvolle kunstenaars',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Muziek & Dans',
                'slug' => 'muziek-dans',
                'description' => 'Van traditionele tambú tot moderne salsa en latin jazz',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Culturele Evenementen',
                'slug' => 'culturele-evenementen',
                'description' => 'Festivals, exposities en culturele gebeurtenissen op het eiland',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Fotografie',
                'slug' => 'fotografie',
                'description' => 'De schoonheid van Curaçao vastgelegd door lokale fotografen',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Ambachten',
                'slug' => 'ambachten',
                'description' => 'Traditionele en moderne ambachten van het eiland',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Mode & Design',
                'slug' => 'mode-design',
                'description' => 'Creatieve mode en design inspiratie uit Curaçao',
                'is_active' => true,
                'sort_order' => 6,
            ]
        ];

        foreach ($categories as $categoryData) {
            BlogCategory::create($categoryData);
        }

        // Get the first user as the author (or create one if none exists)
        $author = User::first();
        if (!$author) {
            $author = User::create([
                'name' => 'Maria Rodriguez',
                'email' => 'maria@curacaotalents.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ]);
        }

        // Get categories for posts
        $lokalKunst = BlogCategory::where('slug', 'lokale-kunst')->first();
        $muziekDans = BlogCategory::where('slug', 'muziek-dans')->first();
        $cultureel = BlogCategory::where('slug', 'culturele-evenementen')->first();
        $fotografie = BlogCategory::where('slug', 'fotografie')->first();
        $ambachten = BlogCategory::where('slug', 'ambachten')->first();
        $mode = BlogCategory::where('slug', 'mode-design')->first();

        // Create blog posts with realistic content
        $posts = [
            [
                'title' => 'De Renaissance van Curaçaose Schilderkunst',
                'slug' => 'renaissance-curacaose-schilderkunst',
                'excerpt' => 'Een nieuwe generatie kunstenaars brengt frisse wind in de traditionele schilderkunst van Curaçao, waarbij lokale cultuur en moderne technieken samensmelten.',
                'content' => '<p>De schilderkunst op Curaçao beleeft momenteel een ware renaissance. Jonge, getalenteerde kunstenaars zoals <strong>Antonio Willems</strong> en <strong>Carmen Statia</strong> combineren traditionele Caribische motieven met moderne abstracte technieken.</p>

<h2>Een Nieuwe Artistieke Beweging</h2>
<p>Deze kunstenaars laten zich inspireren door de rijke geschiedenis van het eiland, van de koloniale architectuur van Willemstad tot de natuurlijke schoonheid van de noordkust. Hun werk kenmerkt zich door levendige kleuren die de Caribische zee en zonsondergangen weerspiegelen.</p>

<h3>Lokale Galeries Ondersteunen Talent</h3>
<p>Galeries zoals <em>Arte Caribe</em> in Punda en <em>Galería Luna</em> in Scharloo spelen een cruciale rol in het ondersteunen van deze nieuwe kunstenaarsbeweging. Ze bieden niet alleen tentoonstellingsruimte, maar ook workshops en masterclasses.</p>

<blockquote>
"Onze kunst vertelt het verhaal van Curaçao - van ons verleden, heden en toekomst. We eren onze roots terwijl we nieuwe wegen inslaan." - Antonio Willems
</blockquote>

<h2>Internationale Erkenning</h2>
<p>Verschillende werken van lokale schilders hebben internationale aandacht gekregen en worden tentoongesteld in galeries in Miami, Amsterdam en Aruba. Dit brengt niet alleen erkenning voor de kunstenaars, maar ook voor Curaçao als cultureel centrum in de Caribische regio.</p>',
                'featured_image' => 'blog/curacaose-schilderkunst.jpg',
                'category_id' => $lokalKunst->id,
                'status' => 'published',
                'featured' => true,
                'published_at' => Carbon::now()->subDays(2),
                'views_count' => 1247,
                'tags' => ['schilderkunst', 'lokale kunstenaars', 'galeries', 'Willemstad'],
                'reading_time' => 6,
            ],
            [
                'title' => 'Salsa Curaçao: Waar Passie en Ritme Samenkomen',
                'slug' => 'salsa-curacao-passie-ritme',
                'excerpt' => 'De salsa scene op Curaçao is levendiger dan ooit. Van intieme danslessen tot spectaculaire shows, ontdek hoe deze dansvorm het eiland heeft veroverd.',
                'content' => '<p>Elke vrijdagavond transformeert het <strong>Plaza Biú</strong> in het centrum van Willemstad tot een bruisende salsa hotspot. Dansers van alle leeftijden en niveaus komen samen om hun passie voor deze sensationele dansvorm te delen.</p>

<h2>De Groei van Salsa op Curaçao</h2>
<p>Wat begon als een kleine groep enthousiaste dansers is uitgegroeid tot een ware beweging. Dansscholen zoals <em>Salsa Azul</em> en <em>Ritmo Caribeño</em> trekken zowel locals als toeristen aan.</p>

<h3>Internationale Invloeden</h3>
<p>De salsa op Curaçao heeft unieke kenmerken ontwikkeld door de mix van:</p>
<ul>
<li>Cubaanse salsa tradities</li>
<li>Colombiaanse cali-style bewegingen</li>
<li>Lokale tambú ritmes</li>
<li>Nederlandse precisie in choreografie</li>
</ul>

<h2>Bekende Dansers en Instructeurs</h2>
<p><strong>Carlos Mendoza</strong>, een van de meest gerespecteerde salsa instructeurs van het eiland, heeft meer dan 500 studenten opgeleid. Zijn studio in Punda is een begrip geworden voor iedereen die serieus salsa wil leren.</p>

<blockquote>
"Salsa is meer dan dans - het is een manier van leven, een uitdrukking van vreugde en gemeenschap." - Carlos Mendoza
</blockquote>',
                'featured_image' => 'blog/salsa-curacao.jpg',
                'category_id' => $muziekDans->id,
                'status' => 'published',
                'featured' => true,
                'published_at' => Carbon::now()->subDays(5),
                'views_count' => 892,
                'tags' => ['salsa', 'dans', 'Plaza Biú', 'dansscholen'],
                'reading_time' => 5,
            ],
            [
                'title' => 'Curaçao North Sea Jazz: Een Muzikaal Hoogtepunt',
                'slug' => 'curacao-north-sea-jazz-muzikaal-hoogtepunt',
                'excerpt' => 'Het Curaçao North Sea Jazz Festival brengt wereldsterren naar het eiland en biedt een platform voor lokaal muziektalent. Een kijkje achter de schermen van dit iconische evenement.',
                'content' => '<p>Het <strong>Curaçao North Sea Jazz Festival</strong> is uitgegroeid tot een van de meest prestigieuze muziekfestivals in de Caribische regio. Dit jaar verwelkomde het festival meer dan 15.000 bezoekers uit meer dan 30 landen.</p>

<h2>Lokaal Talent in de Spotlight</h2>
<p>Naast internationale sterren krijgen lokale muzikanten een unieke kans om hun talent te tonen op de grote podia. Dit jaar openden lokale acts zoals <em>Grupo Banda</em> en <em>Izaline Calister</em> voor internationale headliners.</p>

<h3>De Impact op de Lokale Scene</h3>
<p>Het festival heeft een enorme impact gehad op de lokale muziekscene:</p>
<ul>
<li>Meer dan 50 lokale muzikanten kregen de kans om op te treden</li>
<li>Workshops door internationale artiesten</li>
<li>Netwerkmogelijkheden voor lokale producers</li>
<li>Inspiratie voor jonge muzikanten</li>
</ul>

<h2>Behind the Scenes</h2>
<p>De organisatie van zo\'n grootschalig evenement vereist maanden van voorbereiding. <strong>Festival director Paul Broek</strong> deelt: "We willen niet alleen entertainment bieden, maar ook de lokale cultuur en muzikanten promoten."</p>

<blockquote>
"Dit festival is een brug tussen lokale traditie en internationale excellentie." - Paul Broek
</blockquote>',
                'featured_image' => 'blog/north-sea-jazz.jpg',
                'category_id' => $cultureel->id,
                'status' => 'published',
                'featured' => false,
                'published_at' => Carbon::now()->subDays(8),
                'views_count' => 2156,
                'tags' => ['North Sea Jazz', 'festival', 'muziek', 'evenement'],
                'reading_time' => 7,
            ],
            [
                'title' => 'Door de Lens: Curaçaose Fotografen Vastleggen Eilandleven',
                'slug' => 'curacaose-fotografen-eilandleven',
                'excerpt' => 'Van straatfotografie in Otrobanda tot natuurfotografie op de Christoffel, lokale fotografen documenteren het unieke leven op Curaçao met een artistiek oog.',
                'content' => '<p>Fotografie op Curaçao gaat veel verder dan vakantiekiekjes en ansichtkaarten. Een groeiende gemeenschap van professionele en amateur fotografen documenteert het authentieke eilandleven met een artistiek en journalistiek oog.</p>

<h2>Straatfotografie in Willemstad</h2>
<p><strong>Roberto Fleming</strong> is een van de meest gerespecteerde straatfotografen van het eiland. Zijn zwart-wit foto\'s van het dagelijkse leven in Otrobanda en Punda vertellen verhalen van gewone mensen in buitengewone settings.</p>

<h3>Natuurfotografie: Het Wilde Curaçao</h3>
<p>Fotografe <strong>Diana Kock</strong> specialiseert zich in natuurfotografie en heeft de afgelopen vijf jaar gewerkt aan een uitgebreid project om de biodiversiteit van Curaçao te documenteren. Haar werk toont een kant van het eiland die weinig mensen kennen.</p>

<h2>Fotografie Collectives en Workshops</h2>
<p>De <em>Curaçao Photography Society</em> organiseert maandelijkse bijeenkomsten waar fotografen hun werk delen en van elkaar leren. Ze organiseren ook workshops voor beginners en gevorderde fotografen.</p>

<blockquote>
"Elke hoek van Curaçao heeft een verhaal te vertellen. Als fotografen zijn wij de vertellers." - Roberto Fleming
</blockquote>

<h3>Digitale Platformen en Exposure</h3>
<p>Sociale media en digitale platformen hebben lokale fotografen nieuwe mogelijkheden gegeven om hun werk te delen. Instagram accounts zoals @curacaophotographers hebben duizenden volgers en showcasen dagelijks werk van eilandfotografen.</p>',
                'featured_image' => 'blog/curacao-fotografie.jpg',
                'category_id' => $fotografie->id,
                'status' => 'published',
                'featured' => true,
                'published_at' => Carbon::now()->subDays(12),
                'views_count' => 743,
                'tags' => ['fotografie', 'straatfotografie', 'natuurfotografie', 'Willemstad'],
                'reading_time' => 8,
            ],
            [
                'title' => 'Traditionele Ambachten: Houden van Curaçaose Tradities Levend',
                'slug' => 'traditionele-ambachten-curacaose-tradities',
                'excerpt' => 'Van handgemaakte sieraden tot traditionele keramiek, lokale ambachtslieden bewaren eeuwenoude technieken terwijl ze moderne elementen toevoegen.',
                'content' => '<p>In een tijd van massaproductie en globalisering zijn er op Curaçao nog steeds ambachtslieden die traditionele technieken in ere houden. Deze meesters van hun vak combineren eeuwenoude methoden met moderne creativiteit.</p>

<h2>Keramiek en Aardewerk</h2>
<p><strong>Maestro Juan Carlos Thiel</strong> werkt al meer dan 30 jaar met klei en heeft een unieke stijl ontwikkeld die Taíno-invloeden combineert met Europese technieken. Zijn werkplaats in Seru Fortuná is een leerschool voor jonge keramisten geworden.</p>

<h3>Sieraden van Lokale Materialen</h3>
<p>Sieradeontwerpster <strong>Carmen Soliano</strong> gebruikt materialen die direct van het eiland komen:</p>
<ul>
<li>Koraal en schelpen van de kust</li>
<li>Hout van lokale bomen</li>
<li>Natuurlijke stenen</li>
<li>Gerecyclede metalen</li>
</ul>

<h2>De Markt voor Handwerk</h2>
<p>De <em>Marshe di Artesanos</em> (Ambachtsmarkt) die elke eerste zaterdag van de maand gehouden wordt bij het Rif Fort, is uitgegroeid tot een belangrijke plek waar ambachtslieden hun werk kunnen verkopen en nieuwe klanten ontmoeten.</p>

<blockquote>
"Elk stuk dat ik maak vertelt een verhaal van Curaçao - van onze geschiedenis, onze natuur, onze ziel." - Juan Carlos Thiel
</blockquote>

<h3>Leerprogramma\'s voor Jongeren</h3>
<p>Verschillende ambachtslieden werken samen met scholen om traditionele technieken door te geven aan de volgende generatie. Deze programma\'s zorgen ervoor dat oude ambachten niet verloren gaan.</p>',
                'featured_image' => 'blog/traditionele-ambachten.jpg',
                'category_id' => $ambachten->id,
                'status' => 'published',
                'featured' => false,
                'published_at' => Carbon::now()->subDays(15),
                'views_count' => 456,
                'tags' => ['ambachten', 'keramiek', 'sieraden', 'traditie'],
                'reading_time' => 6,
            ],
            [
                'title' => 'Curaçao Fashion Week: Eiland Mode op de Wereldkaart',
                'slug' => 'curacao-fashion-week-eiland-mode',
                'excerpt' => 'Lokale modeontwerpers krijgen internationale aandacht tijdens de Curaçao Fashion Week. Ontdek hoe eilandmode evolueert en wereldwijd erkenning krijgt.',
                'content' => '<p>De <strong>Curaçao Fashion Week</strong> heeft zich in slechts vier jaar gevestigd als een belangrijk evenement in de Caribische mode-industrie. Designers van over de hele regio komen naar Willemstad om hun nieuwste collecties te presenteren.</p>

<h2>Lokale Ontwerpers in de Spotlight</h2>
<p>Dit jaar presenteerden acht lokale ontwerpers hun werk, waaronder <strong>Shakira Maduro</strong> met haar duurzame modeijn en <strong>Giovanni Croezen</strong> met zijn avant-garde menswear.</p>

<h3>Sustainable Fashion Movement</h3>
<p>Een opvallende trend is de focus op duurzame mode. Ontwerpers gebruiken steeds meer:</p>
<ul>
<li>Gerecyclede materialen</li>
<li>Lokaal geteelde organic cotton</li>
<li>Natuurlijke kleurstoffen van lokale planten</li>
<li>Traditional weaving techniques</li>
</ul>

<h2>Internationale Aandacht</h2>
<p>Fashion bloggers en buyers uit New York, Miami en Europa waren aanwezig om de collecties te bekijken. Verschillende designers tekenden contracten voor internationale distributie.</p>

<blockquote>
"Curaçao mode heeft een unieke identiteit - het is vrolijk, kleurrijk, maar ook sophisticated. We laten zien dat kleine eilanden grote mode kunnen maken." - Shakira Maduro
</blockquote>

<h3>De Toekomst van Mode op Curaçao</h3>
<p>De fashion week heeft geleid tot de oprichting van het <em>Curaçao Fashion Institute</em>, dat jonge ontwerpers opleidt en ondersteunt bij het opzetten van hun eigen merken.</p>',
                'featured_image' => 'blog/fashion-week.jpg',
                'category_id' => $mode->id,
                'status' => 'published',
                'featured' => false,
                'published_at' => Carbon::now()->subDays(18),
                'views_count' => 612,
                'tags' => ['fashion week', 'mode', 'ontwerpers', 'duurzaam'],
                'reading_time' => 5,
            ],
            [
                'title' => 'Kizomba Curaçao: De Sensuale Dans Wint Terrein',
                'slug' => 'kizomba-curacao-sensuale-dans',
                'excerpt' => 'Van Angola naar Curaçao, kizomba heeft de harten van dansers op het eiland veroverd. Ontdek hoe deze intieme dansvorm een eigen Curaçaose twist heeft gekregen.',
                'content' => '<p>Kizomba, de sensuale dansvorm uit Angola, heeft de laatste jaren een enorme populariteit gewonnen op Curaçao. Deze intieme partnerdans combineert Afrikaanse ritmes met Caribische warmte.</p>

<h2>De Introductie van Kizomba</h2>
<p><strong>Paulo Santos</strong>, een Angolese dansinstructeur die zich vijf jaar geleden op Curaçao vestigde, was een van de eersten die kizomba naar het eiland bracht. Zijn dansschool <em>Kizomba Curaçao</em> heeft nu meer dan 200 studenten.</p>

<h3>Curaçaose Kizomba Stijl</h3>
<p>De lokale kizomba scene heeft unieke kenmerken ontwikkeld:</p>
<ul>
<li>Invloeden van lokale tambú ritmes</li>
<li>Caribische bachata elementen</li>
<li>Nederlandse precisie in techniek</li>
<li>Tropische warmte in expressie</li>
</ul>

<h2>Kizomba Evenementen en Festivals</h2>
<p>Het jaarlijkse <em>Curaçao Kizomba Festival</em> trekt dansers uit de hele regio aan. Dit jaar kwamen deelnemers uit meer dan 15 landen naar het eiland voor workshops, battles en social dancing.</p>

<blockquote>
"Kizomba is de perfecte dans voor Curaçao - het is warm, intiem en vol passie, net als ons eiland." - Paulo Santos
</blockquote>

<h3>De Sociale Impact</h3>
<p>Kizomba heeft niet alleen de dansscene beïnvloed, maar ook sociale verbindingen gecreëerd tussen mensen van verschillende achtergronden en leeftijden.</p>',
                'featured_image' => 'blog/kizomba-curacao.jpg',
                'category_id' => $muziekDans->id,
                'status' => 'published',
                'featured' => false,
                'published_at' => Carbon::now()->subDays(22),
                'views_count' => 389,
                'tags' => ['kizomba', 'dans', 'Angola', 'social dancing'],
                'reading_time' => 4,
            ],
            [
                'title' => 'Street Art Revolutie: Murals Transformeren Curaçao',
                'slug' => 'street-art-revolutie-murals-curacao',
                'excerpt' => 'Een nieuwe generatie street artists transformeert lege muren in Willemstad en andere delen van het eiland tot levendige kunstwerken die sociale verhalen vertellen.',
                'content' => '<p>De straten van Curaçao zijn de afgelopen jaren getransformeerd tot een open lucht galerie. Street artists van lokaal en internationaal niveau hebben samengewerkt om vervallen gebouwen en lege muren om te toveren tot adembenemende kunstwerken.</p>

<h2>De Pioniers van Curaçao Street Art</h2>
<p><strong>Francis Sling</strong> en <strong>Yubi Kirindongo</strong> waren de eersten die street art naar Curaçao brachten. Hun grote muurschildering bij de Iguana Cafe was het startschot voor een beweging die zich snel over het hele eiland verspreidde.</p>

<h3>Sociale Boodschappen in Kunst</h3>
<p>Veel van de murals hebben belangrijke sociale boodschappen:</p>
<ul>
<li>Milieubescherming en duurzaamheid</li>
<li>Culturele trots en identiteit</li>
<li>Sociale gelijkheid en rechtvaardigheid</li>
<li>Jeugd empowerment</li>
</ul>

<h2>Het Scharloo Street Art Project</h2>
<p>Het historische Scharloo district is uitgegroeid tot het epicentrum van street art op Curaçao. Meer dan 20 grote murals sieren de koloniale gevels, waarbij oude architectuur en moderne kunst een unieke symbiose aangaan.</p>

<blockquote>
"Street art maakt kunst toegankelijk voor iedereen. Je hoeft geen museum binnen te gaan - de kunst komt naar jou toe." - Francis Sling
</blockquote>

<h3>Toerisme en Culturele Impact</h3>
<p>De street art heeft een positieve impact gehad op het toerisme. Speciale street art tours leiden bezoekers langs de mooiste murals en vertellen de verhalen achter de kunstwerken.</p>',
                'featured_image' => 'blog/street-art-curacao.jpg',
                'category_id' => $lokalKunst->id,
                'status' => 'published',
                'featured' => false,
                'published_at' => Carbon::now()->subDays(25),
                'views_count' => 834,
                'tags' => ['street art', 'murals', 'Scharloo', 'sociale kunst'],
                'reading_time' => 6,
            ],
        ];

        // Create the blog posts
        foreach ($posts as $postData) {
            BlogPost::create([
                'title' => $postData['title'],
                'slug' => $postData['slug'],
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'featured_image' => $postData['featured_image'] ?? null,
                'author_id' => $author->id,
                'blog_category_id' => $postData['category_id'],
                'status' => $postData['status'],
                'is_featured' => $postData['featured'],
                'published_at' => $postData['published_at'],
                'views_count' => $postData['views_count'],
            ]);
        }

        $this->command->info('Blog categories and posts seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . count($categories) . ' blog categories');
        $this->command->info('- ' . count($posts) . ' blog posts');
        $this->command->info('- Featured posts: ' . collect($posts)->where('featured', true)->count());
    }
}
