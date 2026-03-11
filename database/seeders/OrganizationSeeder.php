<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // S'assurer qu'il existe au moins un utilisateur pour associer comme créateur
        $user = User::first() ?: User::factory()->create();

        // Récupérer toutes les catégories
        $categories = OrganizationCategory::all();

        if ($categories->isEmpty()) {
            return; // on ne fait rien s'il n'y a pas de catégories
        }

        $organizationsData = [
            [
                'name' => 'African Wildlife Foundation',
                'short_description' => 'Agir pour la faune et les terres sauvages d\'Afrique.',
                'description' => "La Fondation de la faune sauvage d'Afrique travaille avec les populations locales pour assurer la conservation de la faune et des habitats exceptionnels de l'Afrique. Nous croyons que la protection de l'environnement passe par le développement durable des communautés vivant à proximité de ces espaces.",
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'email' => 'contact@awf-example.org',
                'website' => 'https://www.awf.org',
                'founded_date' => '1961-01-01',
                'logo' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['environnement-ecologie']
            ],
            [
                'name' => 'Tech For Africa',
                'short_description' => 'Autonomiser la jeunesse africaine par les compétences numériques.',
                'description' => "Tech For Africa est une organisation à but non lucratif dédiée à la formation de la prochaine génération de leaders technologiques en Afrique. Nous offrons des bootcamps gratuits de codage, de conception UI/UX et de science des données dans plus de 10 pays africains.",
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'email' => 'hello@techforafrica-example.com',
                'website' => 'https://example-techforafrica.com',
                'founded_date' => '2015-05-12',
                'logo' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1531297122539-d31db6fb442b?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['education-formation', 'entrepreneuriat-tech', 'jeunesse-sports']
            ],
            [
                'name' => 'Fonds de Santé Panafricain',
                'short_description' => 'Garantir un accès équitable aux soins de santé de base.',
                'description' => "Le Fonds réunit professionnels de santé, décideurs politiques et acteurs communautaires pour bâtir des structures médicales solides. Nous intervenons dans les zones rurales pour fournir des médicaments, bâtir des dispensaires et former des sages-femmes et infirmiers.",
                'city' => 'Dakar',
                'country' => 'Senegal',
                'email' => 'info@sante-panafricaine-org.test',
                'website' => 'https://example-sante-panafricaine.org',
                'founded_date' => '2008-09-21',
                'logo' => 'https://images.unsplash.com/photo-1550831107-1553da8c8464?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['sante-publique']
            ],
            [
                'name' => 'AgriNov Côte d\'Ivoire',
                'short_description' => 'Stimuler l\'innovation agricole et soutenir les cultivateurs.',
                'description' => "Une coopérative régionale visant à introduire des pratiques agricoles durables, faire face aux changements climatiques et assurer un salaire juste aux producteurs de cacao, noix de cajou et de vivriers.",
                'city' => 'Abidjan',
                'country' => 'Côte d\'Ivoire',
                'email' => 'contact@agrinov-ci.example',
                'website' => 'https://example-agrinov.ci',
                'founded_date' => '2019-02-10',
                'logo' => 'https://images.unsplash.com/photo-1592982537447-6f29fbde8147?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['developpement-agricole', 'environnement-ecologie']
            ],
            [
                'name' => 'Voix des Femmes Africaines',
                'short_description' => 'Plaidoyer pour l\'égalité des sexes et les droits des femmes.',
                'description' => "Notre réseau panafricain fournit une assistance juridique, offre un soutien psychologique aux victimes de violences et promeut les droits fondamentaux des femmes sur le continent africain à travers des ateliers d'empowerment.",
                'city' => 'Kigali',
                'country' => 'Rwanda',
                'email' => 'voix@femmes-africaines.example',
                'website' => 'https://example-vfa.org',
                'founded_date' => '2011-03-08',
                'logo' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=300&h=300&fit=crop&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1589304049870-07cd45e20ee4?w=1600&h=500&fit=crop&q=80',
                'category_slugs' => ['droits-de-l-homme']
            ]
        ];

        foreach ($organizationsData as $data) {
            $categorySlugs = $data['category_slugs'];
            unset($data['category_slugs']);

            $data['user_id'] = $user->id;
            $data['slug'] = Str::slug($data['name']);
            $data['status'] = 'approved';
            $data['approved_at'] = now();
            
            $organization = Organization::create($data);

            // Associer aux catégories
            $catsToAttach = $categories->whereIn('slug', $categorySlugs)->pluck('id')->toArray();
            if (!empty($catsToAttach)) {
                $organization->categories()->attach($catsToAttach);
            }

            // Mettre l'utilisateur en tant que membre/admin de l'orga
            $organization->members()->create([
                'user_id' => $user->id,
                'role' => 'admin',
                'job_title' => 'Direction'
            ]);
        }
    }
}
