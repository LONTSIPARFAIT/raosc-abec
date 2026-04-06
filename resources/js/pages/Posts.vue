<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Newspaper, ArrowRight, Clock, Building2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

const props = defineProps<{
    posts?: { data: any[] };
}>();

// Placeholder articles utilisés si aucun article n'est encore en base
const fallbackPosts = [
    {
        id: null, slug: null,
        title: "Lancement du programme d'accès à l'eau potable en zone rurale",
        summary: "ONG réunies pour un grand projet d'eau potable via des forages solaires.",
        category: "Solidarité", color: "raosc-green",
        created_at: "4 Avril 2026",
        cover_image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop",
        read_time: 3, organization: null
    },
    {
        id: null, slug: null,
        title: "Nouvelle convention pour la scolarisation des jeunes filles",
        summary: "Accord historique pour soutenir financièrement les familles et encourager la scolarisation.",
        category: "Éducation", color: "raosc-yellow",
        created_at: "2 Avril 2026",
        cover_image: "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop",
        read_time: 5, organization: null
    },
    {
        id: null, slug: null,
        title: "Campagne de vaccination gratuite et de prévention communautaire",
        summary: "Équipes médicales bénévoles dans plusieurs régions pour consultations gratuites.",
        category: "Santé", color: "raosc-red",
        created_at: "30 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=600&auto=format&fit=crop",
        read_time: 4, organization: null
    },
    {
        id: null, slug: null,
        title: "Formation et insertion socioprofessionnelle des jeunes",
        summary: "200 artisans formés aux métiers du bois, soudure et BTP grâce au consortium RAOSC.",
        category: "Emploi", color: "zinc",
        created_at: "28 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1541888081682-1ddc81604a1b?q=80&w=600&auto=format&fit=crop",
        read_time: 2, organization: null
    },
    {
        id: null, slug: null,
        title: "Sommet sur le changement climatique et l'action citoyenne",
        summary: "Focus sur les initiatives de reboisement pilotées par notre réseau.",
        category: "Environnement", color: "raosc-green",
        created_at: "15 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=600&auto=format&fit=crop",
        read_time: 6, organization: null
    },
    {
        id: null, slug: null,
        title: "Distribution de kits alimentaires pour les fêtes",
        summary: "Solidarité inter-religieuse avec plus de 5 tonnes de vivres distribuées.",
        category: "Solidarité", color: "raosc-green",
        created_at: "10 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop",
        read_time: 3, organization: null
    }
];

const displayPosts = (props.posts?.data && props.posts.data.length > 0)
    ? props.posts.data
    : fallbackPosts;

const colorBadge: Record<string, string> = {
    'raosc-green': 'bg-raosc-green text-white',
    'raosc-yellow': 'bg-raosc-yellow text-zinc-900',
    'raosc-red': 'bg-raosc-red text-white',
    'zinc': 'bg-zinc-600 text-white',
};

const colorText: Record<string, string> = {
    'raosc-green': 'text-raosc-green',
    'raosc-yellow': 'text-raosc-yellow',
    'raosc-red': 'text-raosc-red',
    'zinc': 'text-zinc-500',
};

const getBadgeClass = (post: any) => {
    if (post.color) return colorBadge[post.color] ?? 'bg-raosc-green text-white';
    return 'bg-raosc-green text-white';
};

const getTextClass = (post: any) => {
    if (post.color) return colorText[post.color] ?? 'text-raosc-green';
    return 'text-raosc-green';
};
</script>

<template>
    <PublicLayout>
        <Head title="Actualités - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- En-tête sombre premium -->
            <div class="bg-zinc-950 py-24 px-6 relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                    <div class="absolute bottom-0 left-1/4 w-[500px] h-[500px] bg-raosc-yellow opacity-[0.02] rounded-full blur-[120px]"></div>
                </div>
                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-6 inline-flex items-center gap-3 rounded-full bg-white/5 backdrop-blur-sm px-5 py-2.5 border border-white/10">
                        <span class="w-2 h-2 rounded-full bg-raosc-yellow animate-pulse"></span>
                        <span class="text-xs font-bold tracking-[0.2em] text-raosc-yellow uppercase">Le Journal du Réseau</span>
                    </div>
                    <h1 class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        Dernières <span class="text-transparent bg-clip-text bg-gradient-to-r from-raosc-green to-raosc-yellow">Actualités</span>
                    </h1>
                    <p class="text-lg text-zinc-400 max-w-2xl mx-auto">
                        Suivez les actions d'impact, les projets concrets et les opportunités offertes par les organisations de la société civile.
                    </p>
                </div>
            </div>

            <!-- Grille des articles -->
            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-12 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-for="(post, i) in displayPosts"
                        :key="i"
                        class="group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden shadow-lg shadow-zinc-200/60 dark:shadow-none hover:-translate-y-1.5 transition-all duration-300 border border-zinc-100 dark:border-zinc-800 flex flex-col"
                    >
                        <!-- Image -->
                        <div class="h-56 relative overflow-hidden bg-zinc-100 dark:bg-zinc-800 shrink-0">
                            <img
                                v-if="post.cover_image"
                                :src="post.cover_image"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                :alt="post.title"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center">
                                <Newspaper class="w-12 h-12 text-zinc-300 dark:text-zinc-600" />
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                            <!-- Catégorie badge -->
                            <div :class="['absolute top-4 left-4 text-xs font-bold px-3 py-1 rounded-full shadow-md', getBadgeClass(post)]">
                                {{ post.category || 'Actualité' }}
                            </div>

                            <!-- Date + temps de lecture -->
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between">
                                <p class="text-xs font-semibold text-white">{{ post.created_at }}</p>
                                <div v-if="post.read_time" class="flex items-center gap-1.5 text-xs font-medium text-white/80 bg-black/30 backdrop-blur-md px-2.5 py-1 rounded-full">
                                    <Clock class="w-3 h-3" />
                                    {{ post.read_time }} min
                                </div>
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-6 flex flex-col flex-grow">
                            <!-- Organisation auteur -->
                            <div v-if="post.organization" class="flex items-center gap-2 mb-3">
                                <div class="h-6 w-6 rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex items-center justify-center shrink-0">
                                    <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-cover" />
                                    <Building2 v-else class="w-3 h-3 text-zinc-400" />
                                </div>
                                <Link :href="`/rao/orga/${post.organization.slug}`" class="text-xs font-semibold text-zinc-500 hover:text-raosc-green transition-colors truncate">
                                    {{ post.organization.name }}
                                </Link>
                            </div>

                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 group-hover:text-raosc-green transition-colors flex-grow-0">
                                {{ post.title }}
                            </h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 mb-5 leading-relaxed flex-grow">
                                {{ post.summary }}
                            </p>

                            <!-- Lien Lire la suite -->
                            <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800 mt-auto">
                                <Link
                                    v-if="post.slug"
                                    :href="`/posts/${post.slug}`"
                                    :class="['font-bold text-sm inline-flex items-center gap-2 transition-colors', getTextClass(post)]"
                                >
                                    Lire l'article complet
                                    <ArrowRight class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                                </Link>
                                <span v-else :class="['font-bold text-sm inline-flex items-center gap-2 opacity-50 cursor-default', getTextClass(post)]">
                                    Lire l'article complet
                                    <ArrowRight class="w-4 h-4" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination si applicable -->
                <div v-if="posts?.data && posts.data.length > 0" class="mt-16 flex justify-center">
                    <p class="text-sm text-zinc-400">{{ posts.data.length }} article(s) chargé(s)</p>
                </div>

                <!-- Banner Newsletter -->
                <div class="mt-20 bg-zinc-950 rounded-3xl p-10 sm:p-16 text-center relative overflow-hidden shadow-2xl border border-zinc-800">
                    <div class="relative z-10">
                        <div class="h-16 w-16 bg-raosc-green/10 ring-1 ring-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <Newspaper class="h-8 w-8 text-raosc-green" />
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-4">Ne manquez plus aucune action</h2>
                        <p class="text-base text-zinc-400 max-w-lg mx-auto mb-8 leading-relaxed">
                            Abonnez-vous à notre newsletter hebdomadaire pour recevoir nos dossiers, appels à projets et portraits d'organisations.
                        </p>
                        <form @submit.prevent="" class="flex flex-col sm:flex-row max-w-md mx-auto gap-3">
                            <input type="email" placeholder="Votre adresse email" class="flex-grow rounded-xl bg-white/5 border border-white/10 text-white placeholder-zinc-500 focus:ring-2 focus:ring-raosc-green px-5 py-3 outline-none">
                            <button type="submit" class="bg-raosc-green hover:bg-raosc-green/90 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg hover:-translate-y-0.5">
                                S'abonner
                            </button>
                        </form>
                    </div>
                    <div class="absolute -top-32 -right-32 w-96 h-96 bg-raosc-green/10 rounded-full blur-[100px] pointer-events-none"></div>
                    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-raosc-yellow/10 rounded-full blur-[100px] pointer-events-none"></div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>