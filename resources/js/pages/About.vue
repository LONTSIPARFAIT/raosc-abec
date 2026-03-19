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
            <!-- Header Section -->
            <div class="relative bg-zinc-950 py-32 sm:py-48 px-6 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=2084" class="absolute inset-0 w-full h-full object-cover opacity-20 scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
                    
                    <div class="relative mx-auto max-w-7xl text-center">
                        <span class="text-raosc-green font-bold tracking-[0.2em] text-[10px] mb-4 block uppercase">Notre Vision Panafricaine</span>
                        <h1 class="text-4xl sm:text-7xl font-extrabold text-white mb-8 tracking-tight leading-none">
                            Fédérer pour <span class="text-raosc-yellow">Mieux Servir</span>
                        </h1>
                        <p class="text-zinc-400 text-lg sm:text-2xl max-w-4xl mx-auto leading-relaxed font-medium">
                            Le Réseau Africain des Organisations de la Société Civile (RAOSC) est le pilier opérationnel de l'ONG **ABEC**, dédié à la cartographie et à la synergie des acteurs du changement en Afrique.
                        </p>
                    </div>
            </div>

            <!-- Content Section -->
            <div class="py-20 bg-white dark:bg-zinc-950 px-6">
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                        <div>
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-zinc-900 dark:text-white mb-8 tracking-tight">Une mission, un <span class="text-raosc-green">réseau</span></h2>
                            <div class="space-y-6 text-zinc-600 dark:text-zinc-400 text-lg leading-relaxed font-medium">
                                <p>
                                    Le **RAOSC** a été fondé sur le constat que de nombreuses actions sociales en Afrique manquent de visibilité et de coordination. Porté par l'**ABEC**, ce réseau numérique permet de structurer les efforts locaux pour un impact global.
                                </p>
                                <p>
                                    Nous offrons aux organisations à but non lucratif une plateforme vitrine pour exposer leurs projets, leurs succès et leurs besoins, tout en garantissant aux donateurs et partenaires une transparence totale grâce à notre processus de validation rigoureux.
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800">
                                <Target class="h-8 w-8 text-raosc-green mb-4" />
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2">Mission</h3>
                                <p class="text-xs text-zinc-500">Accélérer le développement par la collaboration.</p>
                            </div>
                            <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800">
                                <Eye class="h-8 w-8 text-raosc-yellow mb-4" />
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2">Vision</h3>
                                <p class="text-xs text-zinc-500">Un réseau panafricain uni et fort.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="bg-zinc-50 dark:bg-zinc-900/50 py-24 px-6 border-y border-zinc-100 dark:border-zinc-800">
                <div class="mx-auto max-w-7xl text-center">
                    <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-16">Nos Valeurs</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-12">
                        <div class="space-y-4">
                            <div class="h-14 w-14 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto shadow-sm text-raosc-green">
                                <ShieldCheck class="h-7 w-7" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white tracking-tight text-sm">Transparence</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto">L'intégrité au cœur de chaque interaction au sein du réseau.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="h-14 w-14 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto shadow-sm text-raosc-yellow">
                                <Heart class="h-7 w-7" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white tracking-tight text-sm">Solidarité</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto">L'entraide mutuelle pour un progrès collectif durable.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="h-14 w-14 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto shadow-sm text-raosc-red">
                                <Award class="h-7 w-7" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white tracking-tight text-sm">Excellence</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto">La recherche permanente de la qualité dans l'action sociale.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>

