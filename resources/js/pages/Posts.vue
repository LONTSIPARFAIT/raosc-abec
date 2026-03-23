<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Newspaper, Calendar, ArrowRight } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();

const placeholderPosts = [
    {
        title: "Lancement de la plateforme RAOSC pour les ONG",
        date: "16 Mars 2026",
        category: "Annonce",
        desc: "Une nouvelle interface numérique pour faciliter la collaboration entre les acteurs de la société civile en Afrique.",
        color: "bg-raosc-green/10 text-raosc-green"
    },
    {
        title: "Séminaire sur la transformation digitale des OSC",
        date: "12 Mars 2026",
        category: "Formation",
        desc: "Comment les outils modernes peuvent aider les petites associations à gérer leurs projets et membres efficacement.",
        color: "bg-raosc-yellow/10 text-raosc-yellow"
    },
    {
        title: "Appel à projets : Innovation Sociale 2026",
        date: "05 Mars 2026",
        category: "Opportunité",
        desc: "L'ONG ABEC annonce un fonds de soutien pour les initiatives technologiques à fort impact communautaire.",
        color: "bg-raosc-red/10 text-raosc-red"
    }
];
</script>

<template>
    <PublicLayout>
        <Head title="Actualités - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 border border-white/20">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Journal du Réseau RAOSC</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        Dernières <span class="text-raosc-yellow">Actualités</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                        Suivez les moments forts, les projets et les opportunités au sein du réseau panafricain.
                    </p>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-12 sm:-mt-16 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(post, i) in placeholderPosts" 
                        :key="i" 
                        class="group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all duration-200"
                    >
                        <!-- Placeholder image area -->
                        <div class="h-48 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-zinc-200/50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-900/50 group-hover:scale-105 transition-transform duration-500"></div>
                            <div class="absolute top-5 left-5">
                                <span :class="['px-3 py-1.5 rounded-full text-[10px] font-semibold shadow-sm', post.color]">
                                    {{ post.category }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                                <Calendar class="h-3.5 w-3.5" />
                                <span>{{ post.date }}</span>
                            </div>
                            <h2 class="text-xl font-bold text-zinc-900 dark:text-white leading-tight mb-3 group-hover:text-raosc-green transition-colors">
                                {{ post.title }}
                            </h2>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-5 line-clamp-2">
                                {{ post.desc }}
                            </p>
                            <button class="inline-flex items-center gap-2 text-xs font-semibold text-raosc-green hover:gap-3 transition-all">
                                Lire l'article
                                <ArrowRight class="h-3.5 w-3.5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bottom banner (simplified) -->
                <div class="mt-16 bg-zinc-900 dark:bg-zinc-800 rounded-2xl p-10 text-center relative overflow-hidden shadow-sm">
                    <div class="relative z-10">
                        <div class="h-14 w-14 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-5">
                            <Newspaper class="h-7 w-7 text-zinc-400" />
                        </div>
                        <h2 class="text-xl font-bold text-white mb-2">Plus d'articles en préparation</h2>
                        <p class="text-sm text-zinc-400 max-w-md mx-auto mb-6">
                            Nous finalisons la rédaction de nouveaux dossiers et portraits d'organisations engagées.
                        </p>
                        <button class="inline-flex items-center gap-2 bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold px-6 py-2.5 rounded-full text-sm transition-colors shadow-sm">
                            S'abonner à la newsletter
                            <ArrowRight class="h-4 w-4" />
                        </button>
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-raosc-green opacity-5 rounded-full blur-3xl"></div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>