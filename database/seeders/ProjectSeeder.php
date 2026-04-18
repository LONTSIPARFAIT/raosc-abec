<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgProjects = [
            'eco-gardiens-du-kenya' => [
                [
                    'title' => 'Campagne de reboisement et création d\'espaces verts',
                    'type' => 'projet',
                    'description' => 'Un grand projet visant à restaurer les forêts dégradées et à aménager des espaces verts pour les communautés locales, ceci afin d\'améliorer la qualité de l\'air et de protéger la biodiversité de la région.',
                    'cover_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2113',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800&q=80',
                        'https://images.unsplash.com/photo-1425913397330-cf8af2ff40a1?w=800&q=80',
                        'https://images.unsplash.com/photo-1502082553048-f009c3710db4?w=800&q=80'
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Bénévolat : Journée à l\'Orphelinat de la Joie',
                    'type' => 'benevolat',
                    'description' => 'Appel aux bénévoles pour passer une journée avec les enfants de l\'orphelinat : distribution de repas, aide aux devoirs, activités ludiques. Venez nombreux partager des sourires !',
                    'cover_image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=800&q=80',
                        'https://images.unsplash.com/photo-1529156069898-49953eb1f5ff?w=800&q=80',
                        'https://images.unsplash.com/photo-1524250502761-1ac6f2e30d43?w=800&q=80'
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Installation de forages d\'eau potable',
                    'type' => 'projet',
                    'description' => 'Construction de 5 nouveaux forages d\'eau potable dans des villages isolés pour garantir l\'accès à une eau propre et prévenir les maladies hydriques.',
                    'cover_image' => 'https://images.unsplash.com/photo-1601248074697-b6f1207ae437?q=80&w=2070',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1583849186638-3db82570d032?w=800&q=80',
                        'https://images.unsplash.com/photo-1533036814674-da97af338de8?w=800&q=80'
                    ],
                    'status' => 'completed',
                ]
            ],
            'edutech-benin' => [
                [
                    'title' => 'Bootcamp de Programmation pour les Jeunes',
                    'type' => 'projet',
                    'description' => 'Formation intensive de 3 mois pour initier 50 jeunes aux métiers du développement web et mobile.',
                    'cover_image' => 'https://images.unsplash.com/photo-1531297122539-d31db6fb442b?w=1600&h=500&fit=crop&q=80',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1573164713988-8665fc963095?w=800&q=80',
                        'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&q=80'
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Collecte de matériel informatique',
                    'type' => 'benevolat',
                    'description' => 'Appel aux dons et bénévoles pour reconditionner des ordinateurs destinés aux écoles primaires.',
                    'cover_image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1600&h=500&fit=crop&q=80',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1588702545922-cf1d77a06f47?w=800&q=80',
                        'https://images.unsplash.com/photo-1531297122539-d31db6fb442b?w=800&q=80'
                    ],
                    'status' => 'completed',
                ]
            ],
            'sante-pour-tous-congo' => [
                [
                    'title' => 'Campagne de Vaccination en Zone Rurale',
                    'type' => 'projet',
                    'description' => 'Déploiement d\'équipes médicales mobiles pour vacciner les enfants de moins de 5 ans contre la poliomyélite.',
                    'cover_image' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?w=1600&h=500&fit=crop&q=80',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800&q=80',
                        'https://images.unsplash.com/photo-1581056771107-24ca5f033842?w=800&q=80'
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Bénévoles Médicaux pour les Urgences',
                    'type' => 'benevolat',
                    'description' => 'Recherche d\'infirmières et médecins bénévoles pour renforcer nos équipes lors d\'interventions post-catastrophes.',
                    'cover_image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=1600&h=500&fit=crop&q=80',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1581056771107-24ca5f033842?w=800&q=80',
                        'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800&q=80'
                    ],
                    'status' => 'active',
                ]
            ],
            'savoir-vert-gabon' => [
                [
                    'title' => 'Irrigation Solaire pour les Coopératives',
                    'type' => 'projet',
                    'description' => 'Installation de systèmes d\'irrigation alimentés par panneaux solaires pour augmenter la production maraîchère de 30%.',
                    'cover_image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1600&h=500&fit=crop&q=80',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1592982537447-6f29fbde8147?w=800&q=80',
                        'https://images.unsplash.com/photo-1581579186913-46aa1d054d76?w=800&q=80'
                    ],
                    'status' => 'active',
                ]
            ],
            'justice-sans-frontieres' => [
                [
                    'title' => 'Atelier d\'Empowerment Féminin',
                    'type' => 'projet',
                    'description' => 'Formation à l\'indépendance économique pour 100 femmes, comprenant l\'artisanat et la création de petites entreprises.',
                    'cover_image' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=1600&h=500&fit=crop&q=80',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1589304049870-07cd45e20ee4?w=800&q=80',
                        'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=800&q=80'
                    ],
                    'status' => 'completed',
                ]
            ]
        ];

        foreach ($orgProjects as $slug => $projects) {
            $organization = Organization::where('slug', 'like', $slug . '%')->first();

            if (!$organization) {
                continue;
            }

            foreach ($projects as $data) {
                $data['organization_id'] = $organization->id;
                
                Project::firstOrCreate(
                    ['title' => $data['title']],
                    $data
                );
            }
        }
    }
}
