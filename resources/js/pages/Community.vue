<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Sparkles, Users, MessageSquare, Share2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <PublicLayout>
        <Head title="Communauté - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 border border-white/20">
                            <Sparkles class="h-4 w-4 text-raosc-yellow" />
                            <span class="text-[10px] font-bold tracking-[0.2em] text-white uppercase">Espace de Synergie</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        L'Union fait notre <span class="text-raosc-yellow">Force</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium mb-8">
                        Rejoignez le mouvement, partagez vos défis et bâtissez des partenariats durables avec la communauté RAOSC.
                    </p>
                    <div class="flex justify-center">
                        <div class="flex -space-x-2">
                            <div v-for="i in 5" :key="i" class="h-10 w-10 rounded-full border-2 border-zinc-950 bg-zinc-800 flex items-center justify-center overflow-hidden">
                                <img :src="`https://i.pravatar.cc/150?u=${i}`" alt="Avatar" class="h-full w-full object-cover" />
                            </div>
                            <div class="h-10 w-10 rounded-full border-2 border-zinc-950 bg-zinc-900 flex items-center justify-center text-[9px] font-bold text-zinc-400">
                                +500
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-12 sm:-mt-16 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all">
                        <div class="h-12 w-12 rounded-xl bg-raosc-green/10 flex items-center justify-center text-raosc-green mb-5">
                            <Users class="h-6 w-6" />
                        </div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Forums Thématiques</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            Discutez de santé, d'éducation, d'environnement et d'entrepreneuriat social avec vos pairs.
                        </p>
                    </div>
                    
                    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all">
                        <div class="h-12 w-12 rounded-xl bg-raosc-yellow/10 flex items-center justify-center text-raosc-yellow mb-5">
                            <MessageSquare class="h-6 w-6" />
                        </div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Collaboration Directe</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            Identifiez des partenaires potentiels et initiez des projets conjoints en quelques clics.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all">
                        <div class="h-12 w-12 rounded-xl bg-raosc-red/10 flex items-center justify-center text-raosc-red mb-5">
                            <Share2 class="h-6 w-6" />
                        </div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Base Documentaire</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            Accédez à des guides, modèles et tutoriels partagés par les membres pour booster votre ONG.
                        </p>
                    </div>
                </div>

                <!-- Coming Soon Feature -->
                <div class="mt-16 bg-zinc-900 dark:bg-zinc-800 rounded-2xl p-8 sm:p-12 text-white shadow-sm">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <div>
                            <div class="mb-5">
                                <span class="inline-block bg-raosc-yellow text-zinc-900 px-3 py-1 rounded-full text-[10px] font-bold tracking-wide">En Développement</span>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-4">
                                Un Réseau Évolutif à <span class="text-raosc-green">Votre Écoute</span>
                            </h2>
                            <p class="text-zinc-400 text-sm leading-relaxed mb-8">
                                Nous concevons un espace où chaque voix compte. D'ici peu, vous pourrez profiter d'une application mobile dédiée pour rester connecté partout.
                            </p>
                            <button class="inline-flex items-center gap-2 bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                                Rejoindre la liste d'attente
                                <Sparkles class="h-4 w-4" />
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                                <span class="text-2xl font-bold text-raosc-green">50+</span>
                                <p class="text-[10px] text-zinc-400 mt-1">Groupes de travail</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                                <span class="text-2xl font-bold text-raosc-yellow">10k+</span>
                                <p class="text-[10px] text-zinc-400 mt-1">Ressources partagées</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                                <span class="text-2xl font-bold text-white">24/7</span>
                                <p class="text-[10px] text-zinc-400 mt-1">Support bénévole</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                                <span class="text-2xl font-bold text-raosc-red">15</span>
                                <p class="text-[10px] text-zinc-400 mt-1">Pays africains</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>