<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Newspaper, ArrowRight, Clock } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();

const placeholderPosts = [
    {
        title: "Lancement du programme d'accès à l'eau potable en zone rurale",
        summary: "De nombreuses ONG se sont réunies pour initier ce grand projet visant à fournir de l'eau potable à plus de 50 villages grâce aux forages solaires de dernière génération avec l'appui complet des partenaires internationaux.",
        category: "Solidarité",
        color: "raosc-green",
        date: "4 Avril 2026",
        image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop",
        readTime: "3 min"
    },
    {
        title: "Nouvelle convention de partenariat pour la scolarisation des jeunes filles",
        summary: "Un accord historique a été signé aujourd'hui pour soutenir financièrement les familles et encourager la scolarisation continuelle. Le fonds dédié s'élève à 3 millions de francs et sera réparti sur les deux prochaines années scolaires.",
        category: "Éducation",
        color: "raosc-yellow",
        date: "2 Avril 2026",
        image: "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop",
        readTime: "5 min"
    },
    {
        title: "Campagne de vaccination gratuite et de prévention communautaire",
        summary: "Les équipes médicales bénévoles se déploient dans plusieurs régions pour des consultations gratuites et de la prévention médicale concernant le paludisme et les maladies hydriques en zone tropicale.",
        category: "Santé",
        color: "raosc-red",
        date: "30 Mars 2026",
        image: "https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=600&auto=format&fit=crop",
        readTime: "4 min"
    },
    {
        title: "Formation et insertion socioprofessionnelle des jeunes non diplômés",
        summary: "Une nouvelle vague d'apprentissage métier vient de se clôturer avec plus de 200 artisans formés aux métiers du bois, de la soudure et des BTP grâce au consortium RAOSC.",
        category: "Emploi",
        color: "zinc-600",
        date: "28 Mars 2026",
        image: "https://images.unsplash.com/photo-1541888081682-1ddc81604a1b?q=80&w=600&auto=format&fit=crop",
        readTime: "2 min"
    },
    {
        title: "Sommet sur le changement climatique et l'action citoyenne locale",
        summary: "Focus sur les initiatives de reboisement et d'assainissement pilotées par la société civile de plusieurs pays membres de notre réseau collaboratif.",
        category: "Environnement",
        color: "raosc-green",
        date: "15 Mars 2026",
        image: "https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=600&auto=format&fit=crop",
        readTime: "6 min"
    },
    {
        title: "Distribution de kits alimentaires pour le Ramadan et Pâques",
        summary: "La solidarité inter-religieuse s'est manifestée de la plus belle des manières avec l'association 'Vivre Ensemble' qui a distribué plus de 5 tonnes de vivres...",
        category: "Solidarité",
        color: "raosc-green",
        date: "10 Mars 2026",
        image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop",
        readTime: "3 min"
    }
];

const getColorClass = (color: string) => {
    if (color === 'raosc-yellow') return 'bg-raosc-yellow text-zinc-900';
    if (color === 'raosc-red') return 'bg-raosc-red text-white';
    if (color === 'zinc-600') return 'bg-zinc-600 text-white';
    return 'bg-raosc-green text-white';
};

const getHoverColor = (color: string) => {
    if (color === 'raosc-yellow') return 'hover:text-raosc-yellow';
    if (color === 'raosc-red') return 'hover:text-raosc-red';
    if (color === 'zinc-600') return 'hover:text-zinc-600';
    return 'hover:text-raosc-green';
};

const getTextColor = (color: string) => {
    if (color === 'raosc-yellow') return 'text-raosc-yellow';
    if (color === 'raosc-red') return 'text-raosc-red';
    if (color === 'zinc-600') return 'text-zinc-500';
    return 'text-raosc-green';
};
</script>

<template>
    <PublicLayout>
        <Head title="Actualités et Blog - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                    <div class="absolute bottom-0 left-1/4 w-[500px] h-[500px] bg-raosc-yellow opacity-[0.02] rounded-full blur-[120px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center animate-fade-in">
                        <div class="inline-flex items-center gap-3 rounded-full bg-white/5 backdrop-blur-sm px-5 py-2.5 border border-white/10 shadow-xl">
                            <span class="text-xs font-bold tracking-[0.2em] text-raosc-yellow uppercase flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-raosc-yellow animate-pulse"></span>
                                Le Journal du Réseau Panafricain
                            </span>
                        </div>
                    </div>
                    <h1 class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6 animate-fade-in" style="animation-delay: 100ms;">
                        Dernières <span class="text-transparent bg-clip-text bg-gradient-to-r from-raosc-green to-raosc-yellow">Actualités</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-zinc-400 max-w-2xl mx-auto font-medium leading-relaxed animate-fade-in" style="animation-delay: 200ms;">
                        Suivez en temps réel les actions d'impact, les projets concrets et les opportunités exclusives offertes par les organisations de la société civile.
                    </p>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-16 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(post, i) in placeholderPosts" 
                        :key="i"
                        class="group bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-xl shadow-zinc-200/50 dark:shadow-none hover:-translate-y-2 transition-all duration-300 border border-zinc-100 dark:border-zinc-800"
                    >
                        <div class="h-60 relative overflow-hidden">
                            <img 
                                :src="post.image" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                :alt="post.title" 
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/80 via-zinc-900/20 to-transparent"></div>
                            <div :class="['absolute top-5 left-5 text-xs font-bold px-4 py-1.5 rounded-full shadow-md backdrop-blur-sm', getColorClass(post.color)]">
                                {{ post.category }}
                            </div>
                            <div class="absolute bottom-5 left-5 right-5 flex items-center justify-between">
                                <p class="text-sm font-semibold text-white drop-shadow-md">{{ post.date }}</p>
                                <div class="flex items-center gap-1.5 text-xs font-medium text-white/80 bg-black/30 backdrop-blur-md px-3 py-1 rounded-full">
                                    <Clock class="w-3.5 h-3.5" />
                                    {{ post.readTime }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 sm:p-8 flex flex-col h-[calc(100%-15rem)]">
                            <h3 :class="['text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white mb-4 line-clamp-2 transition-colors cursor-pointer', getHoverColor(post.color)]">
                                {{ post.title }}
                            </h3>
                            <p class="text-sm sm:text-base text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-6 leading-relaxed flex-grow">
                                {{ post.summary }}
                            </p>
                            
                            <a 
                                href="#" 
                                :class="['font-bold text-sm inline-flex items-center gap-1.5 group/link pt-4 border-t border-zinc-100 dark:border-zinc-800 w-full', getTextColor(post.color)]"
                            >
                                Lire l'article complet 
                                <ArrowRight class="w-4 h-4 transition-transform group-hover/link:translate-x-2" />
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bottom banner -->
                <div class="mt-20 bg-zinc-950 rounded-[2.5rem] p-10 sm:p-16 text-center relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <div class="h-16 w-16 bg-gradient-to-br from-raosc-green/20 to-raosc-green/5 ring-1 ring-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <Newspaper class="h-8 w-8 text-raosc-green" />
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-4">Ne manquez plus aucune de nos actions</h2>
                        <p class="text-base text-zinc-400 max-w-lg mx-auto mb-8 leading-relaxed">
                            Abonnez-vous à notre newsletter hebdomadaire pour recevoir en avant-première nos dossiers, appels à projets et portraits d'organisations.
                        </p>
                        <form @submit.prevent="" class="flex flex-col sm:flex-row max-w-md mx-auto gap-3">
                            <input type="email" placeholder="Votre adresse email" class="flex-grow rounded-xl bg-white/5 border border-white/10 text-white placeholder-zinc-500 focus:ring-2 focus:ring-raosc-green px-5 py-3 outline-none transition-all">
                            <button type="submit" class="bg-raosc-green hover:bg-raosc-green/90 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg hover:shadow-raosc-green/20 hover:-translate-y-0.5">
                                S'abonner
                            </button>
                        </form>
                    </div>
                    <div class="absolute -top-32 -right-32 w-96 h-96 bg-raosc-green/10 rounded-full blur-[100px]"></div>
                    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-raosc-yellow/10 rounded-full blur-[100px]"></div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>