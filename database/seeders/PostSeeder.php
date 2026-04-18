<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgPosts = [
            'fonds-panafricain-sante' => [
                [
                    'title' => 'Lancement du programme d\'accès à l\'eau potable en zone rurale',
                    'summary' => 'De nombreuses ONG se sont réunies pour initier ce grand projet visant à fournir de l\'eau potable à plus de 50 villages grâce aux forages.',
                    'content' => "L'accès à l'eau potable reste un défi majeur dans de nombreuses de nos provinces. Aujourd'hui, en partenariat avec les leaders locaux, nous inaugurons un programme à grande échelle pour la construction de 50 forages manuels et solaires.\n\nCet effort permettra non seulement de réduire les maladies hydriques chez les enfants, mais aussi d'alléger le quotidien des femmes et jeunes filles, souvent responsables de la collecte de l'eau sur de longues distances.\n\nNous remercions nos bailleurs et bénévoles pour leur mobilisation sans faille.",
                    'category' => 'Solidarité',
                    'cover_image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop',

                ],
                [
                    'title' => 'Campagne de vaccination gratuite et de prévention',
                    'summary' => 'Les équipes médicales bénévoles se déploient dans plusieurs régions pour des consultations gratuites et de la prévention médicale.',
                    'content' => "Dans le cadre de la semaine mondiale de la santé, le Fonds de Santé Panafricain lance une caravane médicale s'étendant sur 3 régions. Plus de 100 médecins, infirmiers et logisticiens sont déployés pour offrir des consultations pédiatriques, des soins bucco-dentaires et administrer les vaccins essentiels.\n\nL'objectif est d'atteindre 10 000 personnes en un mois. Les cliniques mobiles joueront un rôle clé pour atteindre les zones enclavées.",
                    'category' => 'Santé',
                    'cover_image' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=600&auto=format&fit=crop',

                ]
            ],
            'tech-africa' => [
                [
                    'title' => 'Nouvelle convention de partenariat pour la scolarisation',
                    'summary' => 'Un accord historique a été signé aujourd\'hui pour soutenir financièrement les familles et encourager la scolarisation continuelle.',
                    'content' => "Aujourd'hui marque une étape décisive pour Tech For Africa et l'éducation numérique. Nous avons signé un MoU (Mémorandum d'entente) avec le Ministère de l'Éducation pour fournir des tablettes éducatives à 200 écoles primaires et former 500 professeurs aux outils numériques.\n\nCe partenariat s'étalera sur les trois prochaines années. La scolarisation ne suffit plus, l'acquisition de compétences techniques dès le jeune âge est indispensable aujourd'hui.",
                    'category' => 'Éducation',
                    'cover_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop',

                ]
            ],
            'conservation-nature' => [
                [
                    'title' => 'Succès de la préservation côtière : 5000 tortues remises à l\'eau',
                    'summary' => 'Retour sur notre semaine de nettoyage des plages et la nidification des tortues marines.',
                    'content' => "Le bilan de ce mois est exceptionnel ! Grâce à l'aide de plus de 400 volontaires locaux, nos équipes ont nettoyé près de 15 kilomètres de plages servant de lieu de ponte pour les tortues marines.\n\nNous avons protégé ainsi des centaines de nids et facilité la remise à l'eau de milliers de bébés tortues. Cette action participe directement à la régénération de notre écosystème marin.",
                    'category' => 'Environnement',
                    'cover_image' => 'https://images.unsplash.com/photo-1520110300438-e6d246c24508?q=80&w=600&auto=format&fit=crop',

                ]
            ],
            'justice-sociale' => [
                [
                    'title' => 'Inauguration du Centre d\'Écoute et de Soutien',
                    'summary' => 'Un nouveau refuge pour l\'accompagnement psychologique des victimes.',
                    'content' => "Le Centre offre une ligne d'assistance 24/7 et des professionnels de santé formés. C'est un espace sûr, anonyme, qui va permettre de briser le silence et d'offrir une porte de sortie sécurisée.",
                    'category' => 'Social',
                    'cover_image' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=600&auto=format&fit=crop',
                ]
            ]
        ];

        foreach ($orgPosts as $slug => $posts) {
            $organization = Organization::where('slug', 'like', $slug . '%')->first();

            if (!$organization) {
                continue;
            }

            foreach ($posts as $data) {
                $data['organization_id'] = $organization->id;
                $data['slug'] = Str::slug($data['title']);

                $wordCount = str_word_count(strip_tags((string)$data['content']));
                $data['read_time'] = max(1, (int)round($wordCount / 250));
                
                Post::firstOrCreate(
                    ['slug' => $data['slug']],
                    $data
                );
            }
        }
    }
}
