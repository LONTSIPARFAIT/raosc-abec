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
        $organizations = Organization::all();
        
        $postTemplates = [
            'education-formation' => [
                'title' => 'Rapport annuel sur l\'alphabétisation',
                'summary' => 'Les progrès réalisés dans nos écoles partenaires cette année.',
                'content' => "L'éducation est le socle de tout développement durable. Au cours de l'année écoulée, nous avons constaté une amélioration significative du taux de scolarisation dans les zones où nous intervenons. \n\nGrâce au soutien de nos partenaires et de la communauté RAOSC, nous continuons à fournir des kits scolaires et à former les enseignants aux nouvelles pédagogies."
            ],
            'sante-publique' => [
                'title' => 'Bilan de la caravane médicale',
                'summary' => 'Plus de 1000 patients reçus en une semaine de consultations gratuites.',
                'content' => "La santé est un droit fondamental. Notre dernière caravane médicale a permis de dépister de nombreuses pathologies et d'apporter des soins essentiels aux populations les plus reculées. \n\nLes sourires sur les visages des enfants et des mères sont notre plus belle récompense. Nous planifions déjà la prochaine intervention."
            ],
            'environnement-ecologie' => [
                'title' => 'Agir pour la biodiversité locale',
                'summary' => 'Pourquoi la préservation de nos forêts est vitale pour notre avenir.',
                'content' => "La nature nous donne tout, et il est temps de lui rendre. Nos actions de reboisement et de sensibilisation à l'écologie visent à protéger les écosystèmes fragiles de notre région. \n\nChaque arbre planté est une promesse pour les générations futures. Rejoignez-nous dans ce combat pour une Afrique plus verte."
            ],
            'entrepreneuriat-tech' => [
                'title' => 'L\'innovation au service du social',
                'summary' => 'Comment la technologie transforme le quotidien des populations africaines.',
                'content' => "Le numérique n'est pas un luxe, c'est un outil de développement puissant. À travers nos programmes d'incubation et de formation tech, nous voyons émerger des solutions locales à des défis globaux. \n\nL'Afrique de demain se construit aujourd'hui avec du code, de l'IA et beaucoup de créativité."
            ],
            'developpement-agricole' => [
                'title' => 'Soutenir nos petits producteurs',
                'summary' => 'Les clés d\'une agriculture durable et rentable pour les familles.',
                'content' => "L'agriculture est le premier employeur en Afrique. En soutenant les techniques agroécologiques et l'accès au marché, nous renforçons l'autonomie financière des agriculteurs. \n\nLa sécurité alimentaire commence par le soutien aux producteurs locaux qui nourrissent nos cités."
            ],
            'culture-patrimoine' => [
                'title' => 'Transmission de la mémoire vive',
                'summary' => 'L\'importance de sauvegarder notre patrimoine oral et artistique.',
                'content' => "Un peuple sans culture est un arbre sans racines. Nos projets de numérisation des contes et de soutien aux artistes locaux visent à célébrer la richesse de notre identité africaine. \n\nNous devons être fiers de notre héritage et le transmettre avec passion à la jeunesse connectée."
            ],
        ];

        $stockImages = [
            'https://images.unsplash.com/photo-1542385151-efd9000785a0?q=80&w=800',
            'https://images.unsplash.com/photo-1526285759904-71d1170ed2cd?q=80&w=800',
            'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=800',
            'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=800',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800',
            'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800'
        ];

        foreach ($organizations as $index => $org) {
            $cat = $org->categories()->first();
            $catSlug = $cat ? $cat->slug : 'education-formation';
            
            $template = $postTemplates[$catSlug] ?? $postTemplates['education-formation'];
            
            $title = $template['title'] . " à " . $org->city;
            $slug = Str::slug($title);

            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'organization_id' => $org->id,
                    'title' => $title,
                    'summary' => $template['summary'],
                    'content' => $template['content'] . "\n\nCet article est publié par " . $org->name . " pour partager l'impact de nos actions au " . $org->country . ".",
                    'category' => $cat ? $cat->name : 'Général',
                    'cover_image' => $stockImages[($index + 2) % count($stockImages)],
                    'read_time' => 3
                ]
            );
        }
    }
}
