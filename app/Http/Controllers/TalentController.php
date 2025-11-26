<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TalentController extends Controller
{
    public function show($id)
    {
        // Mock talent data - in real app this would come from database
        $talent = [
            'id' => 1,
            'name' => 'Maria Rodriguez',
            'profession' => 'Schilder & Muralist',
            'category' => 'Beeldende Kunst',
            'location' => 'Willemstad, Curaçao',
            'rating' => 4.9,
            'reviewCount' => 45,
            'studentsCount' => 128,
            'profileViews' => 2847,
            'joinedDate' => 'Maart 2020',
            'lastActive' => '2 uur geleden',
            'verified' => true,
            'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=600&h=400&fit=crop',
            'profileImage' => asset('images/default-avatar.svg'),
            'skills' => ['Muurschildering', 'Portret', 'Abstract', 'Olieverf', 'Acryl', 'Digitale Kunst'],
            'experience' => '8 jaar ervaring',
            'level' => 'Professional',
            'languages' => ['Nederlands', 'Papiamentu', 'Engels', 'Spaans'],
            'availability' => 'Beschikbaar',
            'responseTime' => 'Binnen 2 uur',
            'completedProjects' => 85,
            'repeatClients' => '92%',
            'onTimeDelivery' => '98%',
            'priceRange' => '€150 - €2500',
            'description' => 'Gepassioneerde kunstenaar gespecialiseerd in kleurrijke murals en portretten met Caribische invloeden. Ik help mensen hun verhalen te vertellen door middel van kunst en kleur.',
            'about' => 'Hallo! Ik ben Maria, een professionele schilder en muralist uit Willemstad, Curaçao. Met meer dan 8 jaar ervaring in de kunstwereld, specialiseer ik mij in het creëren van levendige, betekenisvolle kunstwerken die de rijke cultuur en geschiedenis van onze prachtige eiland weerspiegelen.\n\nMijn passie ligt in het transformeren van lege muren tot verhalen die spreken tot de ziel. Of het nu gaat om een intiem portret of een grootschalige muurschildering, ik breng altijd mijn volledige toewijding en creativiteit mee naar elk project.\n\nIk werk graag samen met klanten om hun visie tot leven te brengen en zorg ervoor dat elk kunstwerk uniek en persoonlijk is.',
            'workingProcess' => 'Mijn werkproces begint altijd met een uitgebreid gesprek om uw visie te begrijpen. Daarna maak ik schetsen en concepten, gevolgd door de uitvoering met regelmatige updates. Ik zorg voor transparante communicatie gedurende het hele proces.',
            'education' => [
                [
                    'degree' => 'Bachelor Beeldende Kunst',
                    'school' => 'Universiteit van Curaçao',
                    'year' => '2015'
                ],
                [
                    'degree' => 'Certificaat Muurschildering',
                    'school' => 'Caribbean Art Institute',
                    'year' => '2018'
                ]
            ],
            'certifications' => [
                'Gecertificeerd Muralist',
                'Professioneel Portrettist',
                'Digitale Kunst Specialist'
            ],
            'awards' => [
                'Beste Lokale Kunstenaar 2023',
                'Caribische Kunst Prijs 2022',
                'Community Impact Award 2021'
            ]
        ];

        $portfolio = [
            [
                'id' => 1,
                'title' => 'Caribische Cultuur Muurschildering',
                'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=400&h=300&fit=crop',
                'description' => 'Grote muurschildering die de rijke geschiedenis van Curaçao weergeeft',
                'clientName' => 'Hotel Kura Hulanda',
                'projectObjective' => 'Het hotel wilde een authentieke Caribische sfeer creëren in hun lobby met een muurschildering die de lokale cultuur en geschiedenis van Curaçao zou weerspiegelen. Het doel was om gasten direct onder te dompelen in de rijke erfenis van het eiland.',
                'projectResult' => 'Een 8x4 meter muurschildering die de evolutie van Curaçao toont, van de oorspronkelijke Arawak bewoners tot de koloniale periode en moderne tijd. De levendige kleuren en symbolische elementen creëren een warmte en authentieke sfeer die door gasten zeer gewaardeerd wordt.'
            ],
            [
                'id' => 2,
                'title' => 'Portret Serie - Lokale Helden',
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
                'description' => 'Portretten van belangrijke figuren uit de Curaçaose geschiedenis',
                'clientName' => 'Curaçao Museum',
                'projectObjective' => 'Het museum wilde een nieuwe tentoonstelling over lokale helden en pioniers, met portretten die hun bijdragen aan de samenleving zouden benadrukken en jongeren zouden inspireren.',
                'projectResult' => 'Een serie van 12 realistische portretten van invloedrijke Curaçaoënaars, elk 60x80cm. De portretten combineren traditionele schildertechnieken met moderne elementen die de impact van elke persoon symboliseren. De tentoonstelling trok 40% meer bezoekers dan verwacht.'
            ],
            [
                'id' => 3,
                'title' => 'Abstract Coral Reef',
                'image' => 'https://images.unsplash.com/photo-1578321272176-b7bbc0679853?w=400&h=300&fit=crop',
                'description' => 'Abstracte interpretatie van de onderwaterwereld rond Curaçao',
                'clientName' => 'Curaçao Sea Aquarium',
                'projectObjective' => 'Het aquarium wilde bezoekers bewust maken van de bedreigde koraalriffen rond Curaçao door middel van kunst die zowel de schoonheid als de kwetsbaarheid van het ecosysteem zou tonen.',
                'projectResult' => 'Een drieluik abstract schilderij (totaal 6x2 meter) dat de transformatie van gezonde naar bedreigde koraalriffen toont. Door kleurverloop en textuur wordt de urgentie van natuurbescherming visueel overgebracht. Het werk werd onderdeel van hun educatieve programma.'
            ],
            [
                'id' => 4,
                'title' => 'Community Center Mural',
                'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=400&h=300&fit=crop',
                'description' => 'Kleurrijke muurschildering voor lokaal gemeenschapscentrum',
                'clientName' => 'Sentro di Komunidat Otrobanda',
                'projectObjective' => 'Het gemeenschapscentrum wilde hun buitenmuur transformeren tot een vrolijk en uitnodigend kunstwerk dat de diversiteit en eenheid van de lokale gemeenschap zou vieren en jongeren zou aanmoedigen om deel te nemen aan activiteiten.',
                'projectResult' => 'Een 15 meter lange muurschildering die verschillende generaties en culturen toont die samen spelen, leren en vieren. De interactieve elementen nodigen voorbijgangers uit om deel te worden van het kunstwerk. Het centrum zag een 60% toename in jeugdparticipatie.'
            ]
        ];

        return view('talent.profile', compact('talent', 'portfolio'));
    }
}
