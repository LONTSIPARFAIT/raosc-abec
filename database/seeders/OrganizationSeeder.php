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
        $user = User::where('role', 'admin')->first() ?: User::first();

        $organizationsData = [
            // CAMEROUN (5)
            [
                'name' => 'Savoir Pour Tous Cameroun',
                'city' => 'Yaoundé', 'country' => 'Cameroun', 'phone' => '+237 670 00 00 01',
                'email' => 'contact@savoir-cameroun.org', 'category_slugs' => ['education-formation'],
                'short_description' => 'Éducation inclusive en zone rurale.',
                'responsible_name' => 'Jean-Pierre Ndongo', 'member_count' => 15, 'status' => 'approved'
            ],
            [
                'name' => 'Mères en Bonne Santé (MBS)',
                'city' => 'Bafoussam', 'country' => 'Cameroun', 'phone' => '+237 699 00 11 22',
                'email' => 'mbs@cameroun-sante.cm', 'category_slugs' => ['sante-publique'],
                'short_description' => 'Réduction de la mortalité maternelle.',
                'responsible_name' => 'Dr. Alice Nkodo', 'member_count' => 25, 'status' => 'approved'
            ],
            [
                'name' => 'Femmes Tech Cameroun',
                'city' => 'Douala', 'country' => 'Cameroun', 'phone' => '+237 655 11 22 33',
                'email' => 'contact@femmestech.cm', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Codage et IA pour les femmes.',
                'responsible_name' => 'Grace Epondo', 'member_count' => 12, 'status' => 'approved'
            ],
            [
                'name' => 'Cœur d\'Afrique Solidarité',
                'city' => 'Maroua', 'country' => 'Cameroun', 'phone' => '+237 677 33 44 55',
                'email' => 'coeur@afrique-solidarite.cm', 'category_slugs' => ['droits-hommes'],
                'short_description' => 'Soutien aux orphelins du Grand Nord.',
                'responsible_name' => 'Bello Bouba', 'member_count' => 40, 'status' => 'approved'
            ],
            [
                'name' => 'Eco-Watch Littoral',
                'city' => 'Kribi', 'country' => 'Cameroun', 'phone' => '+237 691 00 22 44',
                'email' => 'ecowatch@littoral.cm', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Protection des mangroves et du littoral.',
                'responsible_name' => 'Marc Etoundi', 'member_count' => 18, 'status' => 'approved'
            ],

            // SÉNÉGAL (3)
            [
                'name' => 'Teranga Digital',
                'city' => 'Dakar', 'country' => 'Sénégal', 'phone' => '+221 77 123 45 67',
                'email' => 'hello@terangadigital.sn', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Accélérateur de startups numériques sénégalaises.',
                'responsible_name' => 'Abdoulaye Wade Jr', 'member_count' => 30, 'status' => 'approved'
            ],
            [
                'name' => 'Griots Modernes',
                'city' => 'Saint-Louis', 'country' => 'Sénégal', 'phone' => '+221 76 987 65 43',
                'email' => 'culture@griots.sn', 'category_slugs' => ['culture-patrimoine'],
                'short_description' => 'Préservation des contes et traditions orales.',
                'responsible_name' => 'Fatou Diome', 'member_count' => 10, 'status' => 'approved'
            ],
            [
                'name' => 'Sahel Vert',
                'city' => 'Thiès', 'country' => 'Sénégal', 'phone' => '+221 70 555 44 33',
                'email' => 'sahel@vert.sn', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Lutte contre la désertification par le reboisement.',
                'responsible_name' => 'Ibrahima Fall', 'member_count' => 50, 'status' => 'approved'
            ],

            // CÔTE D'IVOIRE (3)
            [
                'name' => 'Ivoire Agro-Innov',
                'city' => 'Abidjan', 'country' => 'Côte d\'Ivoire', 'phone' => '+225 07 11 22 33 44',
                'email' => 'agro@ivoire-innov.ci', 'category_slugs' => ['developpement-agricole'],
                'short_description' => 'Modernisation de la filière cacao.',
                'responsible_name' => 'Amadou Bakayoko', 'member_count' => 100, 'status' => 'approved'
            ],
            [
                'name' => 'Espoir Jeunesse CI',
                'city' => 'Bouaké', 'country' => 'Côte d\'Ivoire', 'phone' => '+225 05 99 88 77 66',
                'email' => 'espoir@jeunesse.ci', 'category_slugs' => ['jeunesse-sports'],
                'short_description' => 'Réinsertion sociale par le sport.',
                'responsible_name' => 'Koffi Kouamé', 'member_count' => 45, 'status' => 'approved'
            ],
            [
                'name' => 'Santé Pour Elles',
                'city' => 'Yamoussoukro', 'country' => 'Côte d\'Ivoire', 'phone' => '+225 01 44 55 66 77',
                'email' => 'sante@elles.ci', 'category_slugs' => ['sante-publique'],
                'short_description' => 'Dépistage précoce du cancer du sein.',
                'responsible_name' => 'Dr. Mariam Ouattara', 'member_count' => 20, 'status' => 'approved'
            ],

            // BÉNIN (2)
            [
                'name' => 'EduTech Benin',
                'city' => 'Cotonou', 'country' => 'Bénin', 'phone' => '+229 61 00 00 00',
                'email' => 'info@edutech.bj', 'category_slugs' => ['education-formation'],
                'short_description' => 'Tablettes solaires pour les écoles rurales.',
                'responsible_name' => 'Koffi Azon', 'member_count' => 14, 'status' => 'approved'
            ],
            [
                'name' => 'Patrimoine Dahomey',
                'city' => 'Ouidah', 'country' => 'Bénin', 'phone' => '+229 66 11 22 33',
                'email' => 'culture@dahomey.bj', 'category_slugs' => ['culture-patrimoine'],
                'short_description' => 'Restauration des palais royaux.',
                'responsible_name' => 'Toussaint Louverture', 'member_count' => 8, 'status' => 'approved'
            ],

            // MALI (2)
            [
                'name' => 'Bamako Code Hub',
                'city' => 'Bamako', 'country' => 'Mali', 'phone' => '+223 70 11 22 33',
                'email' => 'code@bamako.ml', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Centre de formation aux métiers du web.',
                'responsible_name' => 'Moussa Traoré', 'member_count' => 12, 'status' => 'approved'
            ],
            [
                'name' => 'Solidarité Nord Mali',
                'city' => 'Mopti', 'country' => 'Mali', 'phone' => '+223 66 44 55 66',
                'email' => 'solidarite@mali.ml', 'category_slugs' => ['droits-hommes'],
                'short_description' => 'Aide humanitaire aux déplacés de guerre.',
                'responsible_name' => 'Oumar Sylla', 'member_count' => 60, 'status' => 'approved'
            ],

            // TOGO (1)
            [
                'name' => 'Lomé Green City',
                'city' => 'Lomé', 'country' => 'Togo', 'phone' => '+228 90 11 22 33',
                'email' => 'green@lome.tg', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Agriculture urbaine et compostage.',
                'responsible_name' => 'Kodjo Agbeyome', 'member_count' => 15, 'status' => 'approved'
            ],

            // GABON (1)
            [
                'name' => 'Forêt Précieuse',
                'city' => 'Libreville', 'country' => 'Gabon', 'phone' => '+241 07 11 22 33',
                'email' => 'foret@gabon.ga', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Protection des éléphants de forêt.',
                'responsible_name' => 'Brice Oligui', 'member_count' => 22, 'status' => 'approved'
            ],

            // BURKINA FASO (1)
            [
                'name' => 'Savoir Faso',
                'city' => 'Ouagadougou', 'country' => 'Burkina Faso', 'phone' => '+226 25 11 22 33',
                'email' => 'savoir@faso.bf', 'category_slugs' => ['education-formation'],
                'short_description' => 'Alphabétisation en langues locales.',
                'responsible_name' => 'Thomas Sankara Jr', 'member_count' => 35, 'status' => 'approved'
            ],

            // CONGO (1)
            [
                'name' => 'Brazza Tech',
                'city' => 'Brazzaville', 'country' => 'Congo', 'phone' => '+242 05 11 22 33',
                'email' => 'tech@brazza.cg', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Promotion de l\'inclusion numérique.',
                'responsible_name' => 'Denis Sassou', 'member_count' => 18, 'status' => 'approved'
            ],

            // GUINÉE (1)
            [
                'name' => 'Guinée Sante',
                'city' => 'Conakry', 'country' => 'Guinée', 'phone' => '+224 621 00 00 00',
                'email' => 'sante@guinee.gn', 'category_slugs' => ['sante-publique'],
                'short_description' => 'Lutte contre le paludisme.',
                'responsible_name' => 'Mamadi Doumbouya', 'member_count' => 28, 'status' => 'approved'
            ],
        ];

        $stockImages = [
            'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=600',
            'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=600',
            'https://images.unsplash.com/photo-1526285759904-71d1170ed2cd?w=600',
            'https://images.unsplash.com/photo-1573164713988-8665fc963095?w=600',
            'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600',
            'https://images.unsplash.com/photo-1489440543227-a6d3d9369952?w=600',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600',
            'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=600'
        ];

        foreach ($organizationsData as $index => $data) {
            $catSlugs = $data['category_slugs'];
            unset($data['category_slugs']);
            
            $data['user_id'] = $user->id;
            $data['slug'] = Str::slug($data['name']);
            $data['description'] = $data['short_description'] . " Cette organisation travaille activement à " . $data['city'] . " pour améliorer les conditions de vie des populations locales à travers divers programmes de développement durable.";
            $data['address'] = "Quartier Central, Rue " . ($index + 1);
            $data['registration_number'] = strtoupper(substr(Str::slug($data['country']), 0, 2)) . "/ONG/" . (2020 + ($index % 5)) . "/" . (100 + $index);
            $data['founded_date'] = (2010 + ($index % 10)) . "-01-01";
            $data['logo'] = "https://api.dicebear.com/7.x/identicon/svg?seed=" . urlencode($data['name']);
            $data['cover_image'] = $stockImages[$index % count($stockImages)];
            $data['responsible_email'] = "resp." . Str::slug($data['responsible_name']) . "@" . explode('@', $data['email'])[1];
            $data['responsible_phone'] = $data['phone'];
            $data['responsible_photo'] = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($data['responsible_name']) . "&skinColor=47281e,614335,ae5d29";
            $data['responsible_id_doc'] = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";
            
            $organization = Organization::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            $catIds = OrganizationCategory::whereIn('slug', $catSlugs)->pluck('id')->toArray();
            if (empty($catIds)) {
                // Fallback to a valid category if slug is slightly different
                $catIds = [OrganizationCategory::first()->id];
            }
            $organization->categories()->sync($catIds);

            // Création automatique du membre admin
            $organization->members()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'role' => 'admin',
                    'job_title' => 'Directeur Exécutif'
                ]
            );
        }
    }
}
