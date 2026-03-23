<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Target, Eye, ShieldCheck, Heart, Award } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <PublicLayout>
        <Head title="À Propos - RAOSC" />

        <main>
            <!-- Header Section - simplified, no image -->
            <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 border border-white/20">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Notre Vision Panafricaine</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        Fédérer pour <span class="text-raosc-yellow">Mieux Servir</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                        Le Réseau Africain des Organisations de la Société Civile (RAOSC) est le pilier opérationnel de l'ONG **ABEC**, dédié à la cartographie et à la synergie des acteurs du changement en Afrique.
                    </p>
                </div>
            </div>

            <!-- Mission & Vision Section -->
            <div class="py-16 sm:py-20 bg-white dark:bg-zinc-950 px-6">
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <div class="inline-flex items-center gap-2 bg-raosc-green/5 px-3 py-1 rounded-full mb-5">
                                <span class="text-[10px] font-semibold text-raosc-green uppercase tracking-wider">Notre raison d'être</span>
                            </div>
                            <h2 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-white mb-6 tracking-tight">
                                Une mission, un <span class="text-raosc-green">réseau</span>
                            </h2>
                            <div class="space-y-5 text-zinc-600 dark:text-zinc-400 text-base leading-relaxed">
                                <p>
                                    Le **RAOSC** a été fondé sur le constat que de nombreuses actions sociales en Afrique manquent de visibilité et de coordination. Porté par l'**ABEC**, ce réseau numérique permet de structurer les efforts locaux pour un impact global.
                                </p>
                                <p>
                                    Nous offrons aux organisations à but non lucratif une plateforme vitrine pour exposer leurs projets, leurs succès et leurs besoins, tout en garantissant aux donateurs et partenaires une transparence totale grâce à notre processus de validation rigoureux.
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="bg-zinc-50 dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm">
                                <div class="h-10 w-10 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green mb-4">
                                    <Target class="h-5 w-5" />
                                </div>
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2 text-sm">Mission</h3>
                                <p class="text-xs text-zinc-500 leading-relaxed">Accélérer le développement par la collaboration et la mutualisation des ressources.</p>
                            </div>
                            <div class="bg-zinc-50 dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm">
                                <div class="h-10 w-10 rounded-lg bg-raosc-yellow/10 flex items-center justify-center text-raosc-yellow mb-4">
                                    <Eye class="h-5 w-5" />
                                </div>
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2 text-sm">Vision</h3>
                                <p class="text-xs text-zinc-500 leading-relaxed">Un réseau panafricain uni, où chaque acteur contribue à un développement durable et inclusif.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="bg-zinc-50/50 dark:bg-zinc-900/20 py-20 sm:py-24 px-6 border-t border-zinc-100 dark:border-zinc-800">
                <div class="mx-auto max-w-7xl text-center">
                    <div class="mb-12">
                        <span class="text-raosc-green text-[10px] font-semibold tracking-[0.2em] uppercase bg-raosc-green/10 px-4 py-1.5 rounded-full mb-4 inline-block">Nos fondements</span>
                        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mt-3">Nos Valeurs</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm transition-all hover:shadow-md">
                            <div class="h-12 w-12 rounded-xl bg-raosc-green/10 flex items-center justify-center mx-auto text-raosc-green mb-5">
                                <ShieldCheck class="h-6 w-6" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white mb-3 text-base">Transparence</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto leading-relaxed">L'intégrité au cœur de chaque interaction au sein du réseau.</p>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm transition-all hover:shadow-md">
                            <div class="h-12 w-12 rounded-xl bg-raosc-yellow/10 flex items-center justify-center mx-auto text-raosc-yellow mb-5">
                                <Heart class="h-6 w-6" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white mb-3 text-base">Solidarité</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto leading-relaxed">L'entraide mutuelle pour un progrès collectif durable.</p>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm transition-all hover:shadow-md">
                            <div class="h-12 w-12 rounded-xl bg-raosc-red/10 flex items-center justify-center mx-auto text-raosc-red mb-5">
                                <Award class="h-6 w-6" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white mb-3 text-base">Excellence</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto leading-relaxed">La recherche permanente de la qualité dans l'action sociale.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>