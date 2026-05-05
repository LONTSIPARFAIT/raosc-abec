<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Newspaper, ArrowRight, Clock, Building2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { show as showPost } from '@/actions/App/Http/Controllers/PostController';
import { show as showOrga } from '@/actions/App/Http/Controllers/RaoController';

interface PostData {
    id: number;
    slug: string | null;
    title: string;
    summary: string;
    category: string | null;
    created_at: string;
    cover_image: string | null;
    read_time: number | null;
    colorKey: string;
    organization: {
        name: string;
        slug: string;
        logo: string | null;
    } | null;
}

const {
    posts = { data: [] }
} = defineProps<{
    posts?: { data: PostData[] };
}>();

const fallbackPosts: PostData[] = [
    {
        id: 0,
        slug: null,
        title: "Lancement du programme d'accès à l'eau potable en zone rurale",
        summary: "De nombreuses ONG se sont réunies pour un grand projet d'eau potable via des forages solaires de dernière génération.",
        category: "Solidarité",
        created_at: "4 Avril 2026",
        cover_image: "https://images.unsplash.com/photo-1542385151-efd9000785a0?q=80&w=600&auto=format&fit=crop",
        read_time: 3,
        organization: null,
        colorKey: "green",
    },
    {
        id: 0,
        slug: null,
        title: "Convention de partenariat pour la scolarisation des jeunes filles",
        summary: "Un accord historique pour soutenir financièrement les familles et encourager la scolarisation continue.",
        category: "Éducation",
        created_at: "2 Avril 2026",
        cover_image: "https://images.unsplash.com/photo-1509059852496-f3822ae057bf?q=80&w=600&auto=format&fit=crop",
        read_time: 5,
        organization: null,
        colorKey: "yellow",
    },
    {
        id: 0,
        slug: null,
        title: "Campagne de vaccination gratuite et prévention communautaire",
        summary: "Des équipes médicales bénévoles se déploient dans plusieurs régions pour des consultations gratuites.",
        category: "Santé",
        created_at: "30 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1526285759904-71d1170ed2cd?q=80&w=600&auto=format&fit=crop",
        read_time: 4,
        organization: null,
        colorKey: "red",
    },
    {
        id: 0,
        slug: null,
        title: "Formation et insertion socioprofessionnelle des jeunes",
        summary: "200 artisans formés aux métiers du bois, soudure et BTP grâce au consortium RAOSC.",
        category: "Emploi",
        created_at: "28 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1489440543227-a6d3d9369952?q=80&w=600&auto=format&fit=crop",
        read_time: 2,
        organization: null,
        colorKey: "zinc",
    },
    {
        id: 0,
        slug: null,
        title: "Sommet sur le changement climatique et l'action citoyenne",
        summary: "Focus sur les initiatives de reboisement et d'assainissement pilotées par notre réseau.",
        category: "Environnement",
        created_at: "15 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop",
        read_time: 6,
        organization: null,
        colorKey: "green",
    },
    {
        id: 0,
        slug: null,
        title: "Distribution de kits alimentaires pour les fêtes",
        summary: "Solidarité inter-religieuse avec plus de 5 tonnes de vivres distribuées par l'association Vivre Ensemble.",
        category: "Solidarité",
        created_at: "10 Mars 2026",
        cover_image: "https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=600&auto=format&fit=crop",
        read_time: 3,
        organization: null,
        colorKey: "green",
    },
];

// Réels ou placeholders
const displayPosts = (posts.data && posts.data.length > 0)
    ? posts.data.map(p => ({ ...p, colorKey: 'green' }))
    : fallbackPosts;

const badgeClass: Record<string, string> = {
    green: 'bg-raosc-green text-white',
    yellow: 'bg-raosc-yellow text-zinc-900',
    red: 'bg-raosc-red text-white',
    zinc: 'bg-zinc-600 text-white',
};

const linkClass: Record<string, string> = {
    green: 'text-raosc-green',
    yellow: 'text-raosc-yellow',
    red: 'text-raosc-red',
    zinc: 'text-zinc-500',
};
</script>

<template>
    <PublicLayout>
        <Head title="Actualités - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">

            <!-- Premium News Header -->
            <div class="relative bg-zinc-50 dark:bg-zinc-950 py-24 sm:py-32 px-6 overflow-hidden">
                <!-- Background Accents -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-raosc-green/10 dark:bg-raosc-green/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3"></div>
                    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-raosc-yellow/10 dark:bg-raosc-yellow/5 rounded-full blur-[100px] translate-y-1/3 -translate-x-1/4"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-white dark:bg-zinc-900 shadow-sm border border-zinc-100 dark:border-zinc-800 mb-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-raosc-green opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-raosc-green"></span>
                        </span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">Le Journal de la Coalition</span>
                    </div>
                    
                    <h1 class="text-5xl sm:text-7xl font-black text-zinc-900 dark:text-white leading-[1.1] tracking-tight mb-8 animate-in fade-in slide-in-from-bottom-6 duration-1000">
                        Impact & <span class="text-transparent bg-clip-text bg-gradient-to-r from-raosc-green via-raosc-green to-raosc-yellow">Récits</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto leading-relaxed animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-200">
                        Découvrez les victoires quotidiennes et les initiatives concrètes portées par les organisations du réseau RAOSC à travers le continent.
                    </p>
                </div>
            </div>

            <!-- Grille articles -->
            <div class="mx-auto max-w-7xl px-5 sm:px-8 -mt-10 relative z-20">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
                    <div
                        v-for="(post, i) in displayPosts"
                        :key="i"
                        class="group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-zinc-100 dark:border-zinc-800 transition-all duration-300 flex flex-col hover:-translate-y-1"
                    >
                        <!-- Image -->
                        <div class="relative h-52 overflow-hidden bg-zinc-100 dark:bg-zinc-800 shrink-0">
                            <img
                                v-if="post.cover_image"
                                :src="post.cover_image"
                                :alt="post.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center">
                                <Newspaper class="w-10 h-10 text-zinc-300 dark:text-zinc-600" />
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <!-- Badge catégorie -->
                            <span :class="['absolute top-4 left-4 text-xs font-bold px-3 py-1 rounded-full shadow', badgeClass[post.colorKey] ?? badgeClass.green]">
                                {{ post.category || 'Actualité' }}
                            </span>
                            <!-- Date + lecture -->
                            <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between">
                                <span class="text-xs text-white font-medium">{{ post.created_at }}</span>
                                <span v-if="post.read_time" class="flex items-center gap-1 text-xs text-white/80 bg-black/30 backdrop-blur-sm px-2 py-0.5 rounded-full">
                                    <Clock class="w-3 h-3" /> {{ post.read_time }} min
                                </span>
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-5 flex flex-col flex-grow">
                            <!-- Organisation -->
                            <div v-if="post.organization" class="flex items-center gap-2 mb-3">
                                <div class="h-5 w-5 rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex items-center justify-center shrink-0">
                                    <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-cover" />
                                    <Building2 v-else class="w-3 h-3 text-zinc-400" />
                                </div>
                                <Link :href="showOrga(post.organization.slug).url" class="text-xs font-semibold text-zinc-500 hover:text-raosc-green transition-colors truncate">
                                    {{ post.organization.name }}
                                </Link>
                            </div>

                            <!-- Titre -->
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-2 line-clamp-2 group-hover:text-raosc-green transition-colors">
                                {{ post.title }}
                            </h3>
                            <!-- Résumé -->
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 mb-4 leading-relaxed flex-grow">
                                {{ post.summary }}
                            </p>

                            <!-- CTA -->
                            <div class="border-t border-zinc-100 dark:border-zinc-800 pt-4 mt-auto">
                                <Link
                                    v-if="post.slug"
                                    :href="showPost(post.slug).url"
                                    :class="['inline-flex items-center gap-1.5 text-sm font-bold transition-colors', linkClass[post.colorKey] ?? linkClass.green]"
                                >
                                    Lire l'article complet
                                    <ArrowRight class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                                </Link>
                                <span v-else class="inline-flex items-center gap-1.5 text-sm font-bold text-zinc-300 dark:text-zinc-600 cursor-not-allowed select-none">
                                    Lire l'article complet
                                    <ArrowRight class="w-4 h-4" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <!-- <div class="mt-20 bg-zinc-950 border border-zinc-800 rounded-3xl p-10 sm:p-14 text-center relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="h-14 w-14 bg-raosc-green/10 border border-raosc-green/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                            <Newspaper class="h-7 w-7 text-raosc-green" />
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3">Ne manquez plus aucune action</h2>
                        <p class="text-sm text-zinc-400 max-w-sm mx-auto mb-7 leading-relaxed">
                            Abonnez-vous pour recevoir nos dossiers, appels à projets et portraits d'organisations.
                        </p>
                        <form @submit.prevent="" class="flex flex-col sm:flex-row max-w-md mx-auto gap-3">
                            <input type="email" placeholder="Votre adresse email" class="flex-grow rounded-xl bg-white/5 border border-white/10 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-raosc-green px-4 py-2.5 text-sm">
                            <button type="submit" class="bg-raosc-green hover:bg-raosc-green/90 text-white font-bold px-7 py-2.5 rounded-xl text-sm transition-all">
                                S'abonner
                            </button>
                        </form>
                    </div>
                    <div class="absolute -top-24 -right-24 w-72 h-72 bg-raosc-green/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-raosc-yellow/10 rounded-full blur-3xl pointer-events-none"></div>
                </div> -->
            </div>
        </main>
    </PublicLayout>
</template>