<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Newspaper, Calendar, ArrowRight } from 'lucide-vue-next';

defineProps<{
    user?: any;
}>();

const placeholderPosts = [
    {
        title: "Lancement de la plateforme RAOSC pour les ONG",
        date: "16 Mars 2026",
        category: "Annonce",
        desc: "Une nouvelle interface numérique pour faciliter la collaboration entre les acteurs de la société civile en Afrique.",
        color: "bg-[#008751]/10 text-[#008751]"
    },
    {
        title: "Séminaire sur la transformation digitale des OSC",
        date: "12 Mars 2026",
        category: "Formation",
        desc: "Comment les outils modernes peuvent aider les petites associations à gérer leurs projets et membres efficacement.",
        color: "bg-[#FFCB05]/10 text-[#FFCB05]"
    },
    {
        title: "Appel à projets : Innovation Sociale 2026",
        date: "05 Mars 2026",
        category: "Opportunité",
        desc: "L'ONG ABEC annonce un fonds de soutien pour les initiatives technologiques à fort impact communautaire.",
        color: "bg-[#E4002B]/10 text-[#E4002B]"
    }
];
</script>

<template>
    <PublicLayout>
        <Head title="Actualités - RAOSC" />

        <main class="relative bg-zinc-50 dark:bg-zinc-950 pb-24">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-24 sm:py-32 px-6 overflow-hidden relative">
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#E4002B] to-[#FFCB05] opacity-10 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
                </div>

                <div class="mx-auto max-w-7xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/5 px-5 py-2.5 border border-white/10 backdrop-blur-xl">
                            <span class="text-[11px] font-bold tracking-[0.1em] text-white">Journal du Réseau</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-none mb-6">
                        Dernières <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#FFCB05] to-[#E4002B]">Actualités</span>
                    </h1>
                    <p class="text-lg text-zinc-400 max-w-2xl mx-auto font-medium tracking-tight">
                        Suivez les moments forts, les projets et les opportunités au sein du réseau RAOSC.
                    </p>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-12 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10">
                    <div v-for="(post, i) in placeholderPosts" :key="i" class="group bg-white dark:bg-zinc-900 rounded-[2.5rem] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all hover:-translate-y-2 hover:shadow-[0_32px_64px_-12px_rgba(0,0,0,0.1)]">
                        <div class="h-48 bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-zinc-200 to-zinc-100 dark:from-zinc-800 dark:to-zinc-900 group-hover:scale-110 transition-transform duration-700"></div>
                            <div class="absolute top-6 left-6">
                                <span :class="['px-4 py-1.5 rounded-xl text-[10px] font-bold tracking-wider shadow-sm', post.color]">
                                    {{ post.category }}
                                </span>
                            </div>
                        </div>
                        <div class="p-8 sm:p-10">
                            <div class="flex items-center gap-3 text-[11px] font-semibold text-zinc-400 mb-4 tracking-tight">
                                <Calendar class="h-3.5 w-3.5" />
                                {{ post.date }}
                            </div>
                            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white tracking-tight leading-tight mb-4 group-hover:text-[#008751] transition-colors">
                                {{ post.title }}
                            </h2>
                            <p class="text-sm text-zinc-500 font-medium italic mb-8 line-clamp-2 border-l-2 border-[#008751]/20 pl-4">
                                {{ post.desc }}
                            </p>
                            <button class="flex items-center gap-2 text-[11px] font-bold text-[#008751] hover:gap-4 transition-all group-hover:translate-x-1">
                                Lire l'article <ArrowRight class="h-3.5 w-3.5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Empty State / Soon Banner -->
                <div class="mt-20 py-20 text-center bg-zinc-950 rounded-[3rem] border border-zinc-800 shadow-3xl relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="mx-auto h-20 w-20 bg-white/5 rounded-[2rem] flex items-center justify-center text-zinc-500 mb-8 border border-white/10 shadow-inner">
                            <Newspaper class="h-10 w-10" />
                        </div>
                        <h2 class="text-2xl font-bold text-white tracking-tight mb-4">Plus d'articles en préparation</h2>
                        <p class="text-zinc-500 max-w-md mx-auto font-medium italic mb-10">Nous finalisons la rédaction de nouveaux dossiers et portraits d'organisations engagées.</p>
                        <button class="bg-[#008751] hover:bg-[#006b40] text-white font-bold px-10 py-4 rounded-2xl text-xs transition-all shadow-lg shadow-[#008751]/10 hover:-translate-y-0.5">
                            S'abonner à la newsletter
                        </button>
                    </div>
                    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-64 h-64 bg-[#008751] opacity-10 rounded-full blur-[80px]"></div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>
