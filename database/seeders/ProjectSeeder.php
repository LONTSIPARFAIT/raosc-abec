<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        
        $projectTypes = [
            'education-formation' => [
                ['title' => 'Bootcamp de Formation Numérique', 'desc' => 'Formation intensive aux métiers du web pour les jeunes.'],
                ['title' => 'Bibliothèque Communautaire', 'desc' => 'Construction et équipement d\'un espace de lecture.'],
            ],
            'sante-publique' => [
                ['title' => 'Caravane de Santé', 'desc' => 'Soins de proximité et sensibilisation aux maladies endémiques.'],
                ['title' => 'Don de Matériel Médical', 'desc' => 'Équipement des maternités rurales.'],
            ],
            'environnement-ecologie' => [
                ['title' => 'Reboisement Participatif', 'desc' => 'Plantation d\'arbres pour lutter contre l\'érosion.'],
                ['title' => 'Gestion des Déchets Urbains', 'desc' => 'Mise en place de circuits de collecte et recyclage.'],
            ],
            'entrepreneuriat-tech' => [
                ['title' => 'Incubateur de Micro-Projets', 'desc' => 'Accompagnement financier et technique des porteurs de projets.'],
                ['title' => 'Innovation Hackathon', 'desc' => 'Challenge technologique pour résoudre des problèmes locaux.'],
            ],
            'developpement-agricole' => [
                ['title' => 'Coopérative Semencière', 'desc' => 'Mutualisation des ressources pour l\'accès aux semences de qualité.'],
                ['title' => 'Irrigation Solaire', 'desc' => 'Installation de pompes à eau solaires pour les cultures.'],
            ],
            'culture-patrimoine' => [
                ['title' => 'Festival des Arts et Contes', 'desc' => 'Célébration annuelle de la tradition orale.'],
                ['title' => 'Archivage Numérique', 'desc' => 'Sauvegarde des manuscrits anciens et récits.'],
            ],
            'jeunesse-sports' => [
                ['title' => 'Tournoi de la Solidarité', 'desc' => 'Compétition sportive pour favoriser la cohésion sociale.'],
                ['title' => 'Centre de Formation Jeunes', 'desc' => 'Espace d\'accueil et de développement personnel.'],
            ],
            'droits-hommes' => [
                ['title' => 'Clinique Juridique Mobile', 'desc' => 'Aide juridique gratuite pour les populations vulnérables.'],
                ['title' => 'Observatoire de la Paix', 'desc' => 'Monitoring des droits humains et médiation.'],
            ],
        ];

        $stockImages = [
            'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?q=80&w=800',
            'https://images.unsplash.com/photo-1542385151-efd9000785a0?q=80&w=800',
            'https://images.unsplash.com/photo-1526285759904-71d1170ed2cd?q=80&w=800',
            'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=800',
            'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800',
            'https://images.unsplash.com/photo-1489440543227-a6d3d9369952?q=80&w=800'
        ];

        foreach ($organizations as $index => $org) {
            $cat = $org->categories()->first();
            $catSlug = $cat ? $cat->slug : 'education-formation';
            
            $templates = $projectTypes[$catSlug] ?? $projectTypes['education-formation'];
            
            // Créer un PROJET
            $pData = $templates[0];
            Project::updateOrCreate(
                ['title' => $pData['title'] . " - " . $org->city],
                [
                    'organization_id' => $org->id,
                    'type' => 'projet',
                    'description' => $pData['desc'] . " Ce projet est mené par " . $org->name . " pour impacter positivement la communauté de " . $org->city . " au " . $org->country . ".",
                    'cover_image' => $stockImages[($index) % count($stockImages)],
                    'status' => ($index % 5 === 0) ? 'completed' : 'active',
                    'gallery' => [$stockImages[($index + 1) % count($stockImages)], $stockImages[($index + 2) % count($stockImages)]]
                ]
            );

            // Créer un BÉNÉVOLAT
            $vData = $templates[1] ?? $templates[0];
            Project::updateOrCreate(
                ['title' => "Bénévolat : " . $vData['title']],
                [
                    'organization_id' => $org->id,
                    'type' => 'benevolat',
                    'description' => "Nous recherchons des volontaires pour nous accompagner dans notre mission : " . $vData['desc'] . " Rejoignez l'équipe de " . $org->name . " à " . $org->city . ".",
                    'cover_image' => $stockImages[($index + 3) % count($stockImages)],
                    'status' => 'active',
                ]
            );
        }
    }
}
