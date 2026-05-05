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
            // CAMEROUN
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
            // SÉNÉGAL
            [
                'name' => 'Teranga Digital',
                'city' => 'Dakar', 'country' => 'Sénégal', 'phone' => '+221 77 123 45 67',
                'email' => 'hello@terangadigital.sn', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Accélérateur de startups numériques sénégalaises.',
                'responsible_name' => 'Abdoulaye Wade Jr', 'member_count' => 30, 'status' => 'approved'
            ],
            [
                'name' => 'Sahel Vert',
                'city' => 'Thiès', 'country' => 'Sénégal', 'phone' => '+221 70 555 44 33',
                'email' => 'sahel@vert.sn', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Lutte contre la désertification par le reboisement.',
                'responsible_name' => 'Ibrahima Fall', 'member_count' => 50, 'status' => 'approved'
            ],
            // CÔTE D'IVOIRE
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
            // BÉNIN
            [
                'name' => 'EduTech Benin',
                'city' => 'Cotonou', 'country' => 'Bénin', 'phone' => '+229 61 00 00 00',
                'email' => 'info@edutech.bj', 'category_slugs' => ['education-formation'],
                'short_description' => 'Tablettes solaires pour les écoles rurales.',
                'responsible_name' => 'Koffi Azon', 'member_count' => 14, 'status' => 'approved'
            ],
            // MALI
            [
                'name' => 'Bamako Code Hub',
                'city' => 'Bamako', 'country' => 'Mali', 'phone' => '+223 70 11 22 33',
                'email' => 'code@bamako.ml', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Centre de formation aux métiers du web.',
                'responsible_name' => 'Moussa Traoré', 'member_count' => 12, 'status' => 'approved'
            ],
            // TOGO
            [
                'name' => 'Lomé Green City',
                'city' => 'Lomé', 'country' => 'Togo', 'phone' => '+228 90 11 22 33',
                'email' => 'green@lome.tg', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Agriculture urbaine et compostage.',
                'responsible_name' => 'Kodjo Agbeyome', 'member_count' => 15, 'status' => 'approved'
            ],
            // GABON
            [
                'name' => 'Forêt Précieuse',
                'city' => 'Libreville', 'country' => 'Gabon', 'phone' => '+241 07 11 22 33',
                'email' => 'foret@gabon.ga', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Protection des éléphants de forêt.',
                'responsible_name' => 'Brice Oligui', 'member_count' => 22, 'status' => 'approved'
            ],
            // BURKINA FASO
            [
                'name' => 'Savoir Faso',
                'city' => 'Ouagadougou', 'country' => 'Burkina Faso', 'phone' => '+226 25 11 22 33',
                'email' => 'savoir@faso.bf', 'category_slugs' => ['education-formation'],
                'short_description' => 'Alphabétisation en langues locales.',
                'responsible_name' => 'Thomas Sankara Jr', 'member_count' => 35, 'status' => 'approved'
            ],
            // NIGER
            [
                'name' => 'Niger Solaire',
                'city' => 'Niamey', 'country' => 'Niger', 'phone' => '+227 96 00 11 22',
                'email' => 'contact@niger-solaire.ne', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Énergie solaire pour les villages du désert.',
                'responsible_name' => 'Ousmane Mahamane', 'member_count' => 10, 'status' => 'approved'
            ],
            // TCHAD
            [
                'name' => 'Eau Vive Tchad',
                'city' => 'N\'Djaména', 'country' => 'Tchad', 'phone' => '+235 66 00 99 88',
                'email' => 'eau@tchad-vive.td', 'category_slugs' => ['sante-publique'],
                'short_description' => 'Accès à l\'eau potable dans le Sahel.',
                'responsible_name' => 'Idriss Deby', 'member_count' => 40, 'status' => 'approved'
            ],
            // GUINÉE
            [
                'name' => 'Guinée Sante Plus',
                'city' => 'Conakry', 'country' => 'Guinée', 'phone' => '+224 621 00 00 00',
                'email' => 'sante@guinee-plus.gn', 'category_slugs' => ['sante-publique'],
                'short_description' => 'Lutte contre les maladies tropicales.',
                'responsible_name' => 'Mamadi Doumbouya', 'member_count' => 28, 'status' => 'approved'
            ],
            // CONGO (BRAZZA)
            [
                'name' => 'Brazza Tech Hub',
                'city' => 'Brazzaville', 'country' => 'Congo', 'phone' => '+242 05 11 22 33',
                'email' => 'tech@brazza-hub.cg', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Promotion de l\'innovation numérique au Congo.',
                'responsible_name' => 'Denis Sassou', 'member_count' => 18, 'status' => 'approved'
            ],
            // RCA
            [
                'name' => 'Paix et Solidarité RCA',
                'city' => 'Bangui', 'country' => 'République Centrafricaine', 'phone' => '+236 75 00 11 22',
                'email' => 'paix@rca-solidarite.cf', 'category_slugs' => ['droits-hommes'],
                'short_description' => 'Réconciliation et soutien aux victimes.',
                'responsible_name' => 'Faustin Touadéra', 'member_count' => 60, 'status' => 'approved'
            ],
            // BURUNDI
            [
                'name' => 'Agri-Futur Burundi',
                'city' => 'Gitega', 'country' => 'Burundi', 'phone' => '+257 22 00 11 22',
                'email' => 'agri@burundi-futur.bi', 'category_slugs' => ['developpement-agricole'],
                'short_description' => 'Agriculture de montagne et permaculture.',
                'responsible_name' => 'Evariste Ndayishimiye', 'member_count' => 32, 'status' => 'approved'
            ],
            // MADAGASCAR
            [
                'name' => 'Madagascar Biodiversité',
                'city' => 'Antananarivo', 'country' => 'Madagascar', 'phone' => '+261 20 00 11 22',
                'email' => 'bio@mada.mg', 'category_slugs' => ['environnement-ecologie'],
                'short_description' => 'Protection de la faune endémique.',
                'responsible_name' => 'Andry Rajoelina', 'member_count' => 45, 'status' => 'approved'
            ],
            // RWANDA
            [
                'name' => 'Kigali Women In Tech',
                'city' => 'Kigali', 'country' => 'Rwanda', 'phone' => '+250 788 00 11 22',
                'email' => 'tech@kigali-women.rw', 'category_slugs' => ['entrepreneuriat-tech'],
                'short_description' => 'Formation des femmes aux métiers du numérique.',
                'responsible_name' => 'Paul Kagame Jr', 'member_count' => 55, 'status' => 'approved'
            ],
            // MAURITANIE
            [
                'name' => 'Dunes Solidaires',
                'city' => 'Nouakchott', 'country' => 'Mauritanie', 'phone' => '+222 45 00 11 22',
                'email' => 'dunes@mauritanie.mr', 'category_slugs' => ['droits-hommes'],
                'short_description' => 'Soutien aux populations nomades.',
                'responsible_name' => 'Mohamed Ould Ghazouani', 'member_count' => 20, 'status' => 'approved'
            ],
        ];

        $stockImages = [
            'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800', // Laughing people
            'https://images.unsplash.com/photo-1523240715639-963c9a0b4740?w=800', // Students
            'https://images.unsplash.com/photo-1573497620053-ea5310f94f17?w=800', // Business woman
            'https://images.unsplash.com/photo-1573164713988-8665fc963095?w=800', // Tech
            'https://images.unsplash.com/photo-1531123897727-8f129e16fd3c?w=800', // Woman
            'https://images.unsplash.com/photo-1509095056764-6720bf39baad?w=800', // Children
            'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800', // Community
            'https://images.unsplash.com/photo-1526285759904-71d1170ed2cd?w=800', // Meeting
            'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=800', // Office
            'https://images.unsplash.com/photo-1573164574572-cb89e39749b4?w=800'  // Workshop
        ];

        foreach ($organizationsData as $index => $data) {
            $catSlugs = $data['category_slugs'];
            unset($data['category_slugs']);
            
            $data['user_id'] = $user->id;
            $data['slug'] = Str::slug($data['name']);
            $data['description'] = $data['short_description'] . " Cette organisation travaille activement à " . $data['city'] . " pour améliorer les conditions de vie des populations locales à travers divers programmes de développement durable, d'innovation et de solidarité communautaire. Nous croyons en l'impact local pour un changement global.";
            $data['address'] = "Quartier Central, Rue " . ($index + 1);
            $data['registration_number'] = strtoupper(substr(Str::slug($data['country']), 0, 2)) . "/ONG/" . (2020 + ($index % 5)) . "/" . (100 + $index);
            $data['founded_date'] = (2010 + ($index % 10)) . "-01-01";
            $data['logo'] = "https://api.dicebear.com/7.x/identicon/svg?seed=" . urlencode($data['name']);
            $data['cover_image'] = $stockImages[$index % count($stockImages)];
            $data['responsible_email'] = "resp." . Str::slug($data['responsible_name']) . "@" . explode('@', $data['email'])[1];
            $data['responsible_phone'] = $data['phone'];
            $data['responsible_photo'] = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($data['responsible_name']) . "&skinColor=47281e,614335,ae5d29";
            $data['responsible_id_doc'] = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";

            // Vice-responsible
            $data['vice_responsible_name'] = "Marie-Louise " . explode(' ', $data['responsible_name'])[1];
            $data['vice_responsible_email'] = "vice." . Str::slug($data['vice_responsible_name']) . "@" . explode('@', $data['email'])[1];
            $data['vice_responsible_phone'] = $data['phone'];
            $data['vice_responsible_photo'] = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($data['vice_responsible_name']) . "&skinColor=47281e,614335,ae5d29";
            $data['vice_responsible_id_doc'] = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";

            // Legal Docs
            $data['legal_docs'] = json_encode([
                "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
            ]);
            $data['presentation_doc'] = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";
            
            $organization = Organization::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            $catIds = OrganizationCategory::whereIn('slug', $catSlugs)->pluck('id')->toArray();
            if (empty($catIds)) {
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
