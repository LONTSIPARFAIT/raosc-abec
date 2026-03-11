<?php

namespace Database\Seeders;

use App\Models\OrganizationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Éducation & Formation',
                'description' => 'Soutien scolaire, alphabétisation, construction d\'écoles et formation professionnelle.',
                'icon' => 'BookOpen'
            ],
            [
                'name' => 'Santé Publique',
                'description' => 'Soins de proximité, prévention, fourniture de matériel médical et luttes contre les épidémies.',
                'icon' => 'HeartPulse'
            ],
            [
                'name' => 'Environnement & Écologie',
                'description' => 'Protection de la nature, reboisement, gestion des déchets et lutte contre le réchauffement climatique.',
                'icon' => 'Leaf'
            ],
            [
                'name' => 'Droits de l\'Homme',
                'description' => 'Défense des droits humains, aide aux réfugiés, lutte contre l\'injustice et aide juridique.',
                'icon' => 'Scale'
            ],
            [
                'name' => 'Développement Agricole',
                'description' => 'Soutien aux agriculteurs locaux, sécurité alimentaire et techniques agricoles durables.',
                'icon' => 'Sprout'
            ],
            [
                'name' => 'Jeunesse & Sports',
                'description' => 'Encadrement des jeunes, activités sportives, centres récréatifs et aide au développement personnel.',
                'icon' => 'Users'
            ],
            [
                'name' => 'Entrepreneuriat & Tech',
                'description' => 'Incubateurs, aide à la création d\'entreprise, tech for good et financement de micro-projets.',
                'icon' => 'Lightbulb'
            ],
            [
                'name' => 'Culture & Patrimoine',
                'description' => 'Préservation du patrimoine africain, soutien à la création artistique et festivals.',
                'icon' => 'Palette'
            ],
        ];

        foreach ($categories as $category) {
            OrganizationCategory::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'icon' => $category['icon']
                ]
            );
        }
    }
}
