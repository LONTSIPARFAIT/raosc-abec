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
            <div class="bg-zinc-950 py-24 sm:py-32 px-6">
                    <div class="mx-auto max-w-7xl text-center">
                        <span class="text-[#008751] font-bold tracking-[0.2em] text-[10px] mb-4 block">Notre Organisation</span>
                        <h1 class="text-4xl sm:text-6xl font-extrabold text-white mb-6 tracking-tight">
                            À Propos de <span class="text-[#FFCB05]">RAOSC</span>
                        </h1>
                        <p class="text-zinc-400 text-lg sm:text-xl max-w-3xl mx-auto leading-relaxed font-medium">
                            Le Réseau Africain des Organisations de la Société Civile est une initiative portée par l'ONG ABEC pour fédérer les acteurs du développement.
                        </p>
                    </div>
            </div>

            <!-- Content Section -->
            <div class="py-20 bg-white dark:bg-zinc-950 px-6">
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                        <div>
                            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-8">Notre Engagement</h2>
                            <div class="space-y-6 text-zinc-600 dark:text-zinc-400 leading-relaxed font-medium">
                                <p>
                                    Né d'une volonté de professionnaliser les actions de terrain, le RAOSC offre un pont numérique entre les organisations et leurs bénéficiaires.
                                </p>
                                <p>
                                    Nous croyons en la force du numérique pour amplifier l'impact social. En rejoignant notre réseau, chaque organisation gagne en visibilité et en outils de gestion.
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800">
                                <Target class="h-8 w-8 text-[#008751] mb-4" />
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2">Mission</h3>
                                <p class="text-xs text-zinc-500">Accélérer le développement par la collaboration.</p>
                            </div>
                            <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800">
                                <Eye class="h-8 w-8 text-[#FFCB05] mb-4" />
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
                            <div class="h-14 w-14 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto shadow-sm text-[#008751]">
                                <ShieldCheck class="h-7 w-7" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white tracking-tight text-sm">Transparence</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto">L'intégrité au cœur de chaque interaction au sein du réseau.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="h-14 w-14 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto shadow-sm text-[#FFCB05]">
                                <Heart class="h-7 w-7" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white tracking-tight text-sm">Solidarité</h3>
                            <p class="text-sm text-zinc-500 max-w-xs mx-auto">L'entraide mutuelle pour un progrès collectif durable.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="h-14 w-14 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto shadow-sm text-[#E4002B]">
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
