<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@raosc.org',
                'role' => 'admin'
            ]);
        }

        $organizationsData = [
            // Éducation & Formation
            [
                'name' => 'Savoir Pour Tous Africa',
                'short_description' => 'Promouvoir l\'éducation inclusive dans les zones rurales.',
                'description' => "Savoir Pour Tous Africa oeuvre pour réduire les inégalités scolaires en construisant des bibliothèques communautaires et en offrant des bourses aux enfants issus de familles défavorisées.",
                'city' => 'Bamako',
                'country' => 'Mali',
                'email' => 'contact@savoir-africa.org',
                'website' => 'https://savoir-africa.org',
                'registration_number' => 'ML/EDU/2024/001',
                'founded_date' => '2010-05-15',
                'logo' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1600&h=500&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=800',
                    'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800'
                ],
                'category_slugs' => ['education-formation'],
                'status' => 'approved'
            ],
            [
                'name' => 'EduTech Benin',
                'short_description' => 'L\'innovation technologique au service de l\'apprentissage.',
                'description' => "EduTech Benin développe des solutions numériques pour faciliter l'accès à l'éducation dans les zones reculées, notamment par le biais de classes mobiles équipées de tablettes solaires.",
                'city' => 'Cotonou',
                'country' => 'Bénin',
                'email' => 'info@edutech-benin.bj',
                'website' => 'https://edutech-benin.bj',
                'registration_number' => 'BJ/ONG/2026/44',
                'founded_date' => '2018-09-20',
                'logo' => 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1600&h=500&fit=crop&q=80',
                'gallery' => ['https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=800'],
                'category_slugs' => ['education-formation'],
                'status' => 'approved'
            ],
            [
                'name' => 'Alphabetisation Plus',
                'short_description' => 'Lutter contre l\'analphabétisme chez les adultes.',
                'description' => "Une organisation dédiée à l'alphabétisation fonctionnelle des femmes et des jeunes non scolarisés pour favoriser leur insertion socio-professionnelle.",
                'city' => 'Ouagadougou',
                'country' => 'Burkina Faso',
                'email' => 'contact@alpha-plus.bf',
                'website' => 'https://alpha-plus.bf',
                'registration_number' => 'BF/SOC/2025/12',
                'founded_date' => '2015-03-10',
                'logo' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['education-formation'],
                'status' => 'approved'
            ],

            // Santé Publique
            [
                'name' => 'Santé Pour Tous Congo',
                'short_description' => 'Soins de santé primaires pour les populations vulnérables.',
                'description' => "Nous gérons des cliniques mobiles et formons des agents de santé communautaires pour assurer un suivi médical dans les zones de conflit et de pauvreté extrême.",
                'city' => 'Kinshasa',
                'country' => 'RDC',
                'email' => 'sante@ong-rdc.org',
                'registration_number' => 'RDC/SAN/009',
                'founded_date' => '2005-11-12',
                'logo' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['sante-publique'],
                'status' => 'approved'
            ],
            [
                'name' => 'Vision Claire Africa',
                'short_description' => 'Lutter contre la cécité évitable en Afrique de l\'Ouest.',
                'description' => "Vision Claire organise des campagnes chirurgicales gratuites pour traiter la cataracte et distribuer des lunettes correctrices aux enfants scolarisés.",
                'city' => 'Lomé',
                'country' => 'Togo',
                'email' => 'info@vision-claire.tg',
                'registration_number' => 'TG/SAN/2026/77',
                'founded_date' => '2012-01-05',
                'logo' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['sante-publique'],
                'status' => 'approved'
            ],
            [
                'name' => 'Mères en Bonne Santé',
                'short_description' => 'Réduire la mortalité maternelle et infantile.',
                'description' => "MBS accompagne les femmes enceintes à travers des programmes de nutrition et d'éducation à l'hygiène, tout en équipant les maternités rurales.",
                'city' => 'Yaoundé',
                'country' => 'Cameroun',
                'email' => 'mbs@cameroun-sante.cm',
                'registration_number' => 'CM/SAN/2023/15',
                'founded_date' => '2016-08-30',
                'logo' => 'https://images.unsplash.com/photo-1584362946521-4c445a75a44d?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['sante-publique'],
                'status' => 'approved'
            ],

            // Environnement & Écologie
            [
                'name' => 'Green Sahel Initiative',
                'short_description' => 'Lutter contre la désertification par le reboisement.',
                'description' => "Green Sahel mobilise les communautés locales pour planter des millions d'arbres le long de la Grande Muraille Verte.",
                'city' => 'Niamey',
                'country' => 'Niger',
                'email' => 'green@sahel-ong.ne',
                'registration_number' => 'NE/ENV/2025/112',
                'founded_date' => '2011-04-22',
                'logo' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1425913397330-cf8af2ff40a1?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['environnement-ecologie'],
                'status' => 'approved'
            ],
            [
                'name' => 'Océans Propres Gabon',
                'short_description' => 'Protection des écosystèmes marins et des plages.',
                'description' => "Nous luttons contre la pollution plastique et protégeons les zones de ponte des tortues luths sur les côtes gabonaises.",
                'city' => 'Libreville',
                'country' => 'Gabon',
                'email' => 'clean@ocean-gabon.ga',
                'registration_number' => 'GA/ENV/2024/02',
                'founded_date' => '2014-06-08',
                'logo' => 'https://images.unsplash.com/photo-1484417894907-623942c8ee29?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1456318019777-ccdc4d5b2396?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['environnement-ecologie'],
                'status' => 'approved'
            ],
            [
                'name' => 'Eco-Guerriers du Kenya',
                'short_description' => 'Éducation environnementale et défense de la faune.',
                'description' => "Une organisation de jeunesse dédiée à la protection des éléphants et à la lutte contre le braconnage à travers la technologie.",
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'email' => 'warriors@eco-kenya.org',
                'registration_number' => 'KE/ENV/2026/88',
                'founded_date' => '2020-02-02',
                'logo' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['environnement-ecologie'],
                'status' => 'approved'
            ],

            // Droits de l'Homme
            [
                'name' => 'Liberté & Dignité',
                'short_description' => 'Défense juridique pour les plus démunis.',
                'description' => "Liberté & Dignité offre des services d'avocats gratuits aux personnes victimes d'injustices sociales et d'arbitraire judiciaire.",
                'city' => 'Abidjan',
                'country' => 'Côte d\'Ivoire',
                'email' => 'justice@liberte.ci',
                'registration_number' => 'CI/DH/2025/11',
                'founded_date' => '2009-12-10',
                'logo' => 'https://images.unsplash.com/photo-1589391886645-d51941baf7fb?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1521791136064-7986c29596af?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['droits-de-lhomme'],
                'status' => 'approved'
            ],
            [
                'name' => 'Enfants d\'Abord Africa',
                'short_description' => 'Protection des droits de l\'enfant.',
                'description' => "Lutte contre le travail forcé des enfants et promotion de leurs droits fondamentaux à travers l'Afrique.",
                'city' => 'Dakar',
                'country' => 'Sénégal',
                'email' => 'droits@enfants-africa.sn',
                'registration_number' => 'SN/DH/2024/005',
                'founded_date' => '2013-11-20',
                'logo' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1502086223501-7ea6ecd79368?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['droits-de-lhomme'],
                'status' => 'approved'
            ],
            [
                'name' => 'Femmes en Marche',
                'short_description' => 'Autonomisation et lutte contre les violences basées sur le genre.',
                'description' => "Mouvement social pour l'égalité des sexes et la protection des femmes vulnérables dans les zones rurales.",
                'city' => 'Conakry',
                'country' => 'Guinée',
                'email' => 'egalite@femmes-guinee.gn',
                'registration_number' => 'GN/DH/2023/12',
                'founded_date' => '2017-03-08',
                'logo' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['droits-de-lhomme'],
                'status' => 'approved'
            ],

            // Développement Agricole
            [
                'name' => 'AgriFuture Benin',
                'short_description' => 'Modernisation de l\'agriculture familiale.',
                'description' => "AgriFuture accompagne les petits exploitants dans la transition vers une agriculture durable et mécanisée.",
                'city' => 'Parakou',
                'country' => 'Bénin',
                'email' => 'contact@agrifuture.bj',
                'registration_number' => 'BJ/AGRI/2026/02',
                'founded_date' => '2021-05-12',
                'logo' => 'https://images.unsplash.com/photo-1592982537447-6f29fbde8147?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['developpement-agricole'],
                'status' => 'approved'
            ],
            [
                'name' => 'Semences d\'Espoir',
                'short_description' => 'Souveraineté alimentaire et semences paysannes.',
                'description' => "Promotion des semences locales et lutte contre les OGM pour garantir une alimentation saine et souveraine.",
                'city' => 'Accra',
                'country' => 'Ghana',
                'email' => 'hope@seeds-gh.org',
                'registration_number' => 'GH/AGRI/2025/11',
                'founded_date' => '2019-10-10',
                'logo' => 'https://images.unsplash.com/photo-1599584448508-5d49942a0330?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['developpement-agricole'],
                'status' => 'approved'
            ],
            [
                'name' => 'Afrique Fertile',
                'short_description' => 'Restauration des sols et permaculture.',
                'description' => "Afrique Fertile forme les agriculteurs aux techniques de permaculture pour restaurer la fertilité des sols dégradés.",
                'city' => 'Kigali',
                'country' => 'Rwanda',
                'email' => 'fertile@africa-ong.rw',
                'registration_number' => 'RW/AGRI/2024/003',
                'founded_date' => '2018-01-15',
                'logo' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1530507629858-e4977d30e9e0?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['developpement-agricole'],
                'status' => 'approved'
            ],

            // Jeunesse & Sports
            [
                'name' => 'Foot Pour Tous Foundation',
                'short_description' => 'Le sport comme vecteur d\'inclusion sociale.',
                'description' => "Utilisation du football pour encadrer les jeunes des quartiers précaires et les éloigner de la délinquance.",
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'email' => 'soccer@inclusion.ng',
                'registration_number' => 'NG/SPO/2026/001',
                'founded_date' => '2010-06-11',
                'logo' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1511886929837-354d827aae26?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['jeunesse-sports'],
                'status' => 'approved'
            ],
            [
                'name' => 'Jeunesse Connectée',
                'short_description' => 'Leadership et citoyenneté active.',
                'description' => "Plateforme d'échange et de formation pour former les futurs leaders africains aux enjeux de citoyenneté.",
                'city' => 'Douala',
                'country' => 'Cameroun',
                'email' => 'leaders@jeunesse.cm',
                'registration_number' => 'CM/JEU/2025/12',
                'founded_date' => '2019-09-12',
                'logo' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1529156069898-49953eb1f5ff?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['jeunesse-sports'],
                'status' => 'approved'
            ],
            [
                'name' => 'Talents Africains',
                'short_description' => 'Découverte et promotion des jeunes talents artistiques.',
                'description' => "Concours et mentorat pour les jeunes artistes africains dans les domaines du chant, de la danse et des arts plastiques.",
                'city' => 'Brazzaville',
                'country' => 'Congo',
                'email' => 'art@talents.cg',
                'registration_number' => 'CG/CULT/2026/05',
                'founded_date' => '2015-05-20',
                'logo' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1460661419201-fd4ce18a8024?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['jeunesse-sports', 'culture-patrimoine'],
                'status' => 'approved'
            ],

            // Entrepreneuriat & Tech
            [
                'name' => 'Startup Hub Sahel',
                'short_description' => 'Incubateur technologique pour l\'innovation sahélienne.',
                'description' => "Accompagnement des startups locales dans le développement de solutions numériques adaptées aux réalités du Sahel.",
                'city' => 'Bamako',
                'country' => 'Mali',
                'email' => 'hub@startup-sahel.ml',
                'registration_number' => 'ML/TECH/2026/001',
                'founded_date' => '2017-02-14',
                'logo' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1522071823991-b1ae5e6a30c8?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['entrepreneuriat-tech'],
                'status' => 'approved'
            ],
            [
                'name' => 'DigitAfrica Innovation',
                'short_description' => 'Formation au codage et à l\'IA pour les femmes.',
                'description' => "Une organisation féministe tech pour réduire la fracture numérique de genre en Afrique.",
                'city' => 'Addis Ababa',
                'country' => 'Éthiopie',
                'email' => 'tech@digit-africa.et',
                'registration_number' => 'ET/TECH/2025/11',
                'founded_date' => '2022-10-10',
                'logo' => 'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['entrepreneuriat-tech'],
                'status' => 'approved'
            ],
            [
                'name' => 'L\'Afrique de Demain',
                'short_description' => 'Financement et mentorat pour les micro-entrepreneurs.',
                'description' => "Micro-crédit et coaching pour aider les petits commerçants à structurer et digitaliser leur activité.",
                'city' => 'Lusaka',
                'country' => 'Zambie',
                'email' => 'contact@africa-tomorrow.zm',
                'registration_number' => 'ZM/ENT/2024/004',
                'founded_date' => '2016-01-20',
                'logo' => 'https://images.unsplash.com/photo-1559136555-930361582b44?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['entrepreneuriat-tech'],
                'status' => 'approved'
            ],

            // Culture & Patrimoine
            [
                'name' => 'Mémoire de l\'Afrique',
                'short_description' => 'Préservation des sites historiques et culturels.',
                'description' => "Travail de documentation et de restauration des sites classés au patrimoine mondial de l'UNESCO en Afrique.",
                'city' => 'Djenne',
                'country' => 'Mali',
                'email' => 'heritage@memoire.ml',
                'registration_number' => 'ML/CULT/2026/01',
                'founded_date' => '2008-05-15',
                'logo' => 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1544413673-2e0f5454659f?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['culture-patrimoine'],
                'status' => 'approved'
            ],
            [
                'name' => 'Artisans du Futur',
                'short_description' => 'Soutien à l\'artisanat local et commerce équitable.',
                'description' => "Promotion des savoir-faire ancestraux et aide à l'exportation des créations artisanales africaines.",
                'city' => 'Marrakech',
                'country' => 'Maroc',
                'email' => 'art@avenir.ma',
                'registration_number' => 'MA/SOC/2026/12',
                'founded_date' => '2014-03-20',
                'logo' => 'https://images.unsplash.com/photo-1459749411177-042180ec75fb?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1540206351-d6465b3ac5c1?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['culture-patrimoine'],
                'status' => 'approved'
            ],
            [
                'name' => 'Voix des Griots',
                'short_description' => 'Promotion de la tradition orale et des contes africains.',
                'description' => "Recueil des récits oraux et diffusion auprès de la jeunesse connectée à travers des podcasts et livres numériques.",
                'city' => 'Bandjoun',
                'country' => 'Cameroun',
                'email' => 'griots@voix.cm',
                'registration_number' => 'CM/CULT/2025/11',
                'founded_date' => '2016-12-12',
                'logo' => 'https://images.unsplash.com/photo-1534346589587-9b4b7325608b?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1552516421-4a4be108fb22?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['culture-patrimoine'],
                'status' => 'approved'
            ],
        ];

        foreach ($organizationsData as $data) {
            $catSlugs = $data['category_slugs'];
            unset($data['category_slugs']);
            
            $data['user_id'] = $user->id;
            $data['slug'] = Str::slug($data['name']);

            $organization = Organization::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            $catIds = OrganizationCategory::whereIn('slug', $catSlugs)->pluck('id')->toArray();
            $organization->categories()->sync($catIds);

            // Création automatique du membre admin
            $organization->members()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'role' => 'admin',
                    'job_title' => 'Fondateur'
                ]
            );
        }
    }
}
