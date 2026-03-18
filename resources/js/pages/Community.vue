<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <PublicLayout>
        <Head title="Communauté - RAOSC" />

        <main class="relative bg-zinc-50 dark:bg-zinc-950 pb-24 min-h-screen">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-24 sm:py-40 px-6 overflow-hidden relative">
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#008751] via-[#FFCB05] to-[#E4002B] opacity-10 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
                </div>

                <div class="mx-auto max-w-7xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/5 px-5 py-2.5 border border-white/10 backdrop-blur-xl">
                            <Sparkles class="h-4 w-4 text-[#FFCB05]" />
                            <span class="text-[11px] font-bold tracking-[0.1em] text-white">Espace de Synergie</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-none mb-8">
                        L'Union fait notre <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#008751] via-[#FFCB05] to-[#008751] bg-[length:200%_auto] animate-gradient">Force</span>
                    </h1>
                    <p class="text-lg sm:text-2xl text-zinc-400 max-w-2xl mx-auto font-medium mb-12 tracking-tight leading-relaxed">
                        Rejoignez le mouvement, partagez vos défis et bâtissez des partenariats durables avec la communauté RAOSC.
                    </p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <div class="flex -space-x-3">
                            <div v-for="i in 5" :key="i" class="h-12 w-12 rounded-full border-2 border-zinc-950 bg-zinc-800 flex items-center justify-center overflow-hidden">
                                <img :src="`https://i.pravatar.cc/150?u=${i}`" alt="Avatar" class="h-full w-full object-cover" />
                            </div>
                            <div class="h-12 w-12 rounded-full border-2 border-zinc-950 bg-zinc-900 flex items-center justify-center text-[10px] font-black text-zinc-400">
                                +500
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-20 relative z-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10">
                    <div class="group bg-white dark:bg-zinc-900 p-10 rounded-[3rem] border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all hover:-translate-y-2">
                        <div class="h-16 w-16 rounded-[2rem] bg-[#008751]/10 flex items-center justify-center text-[#008751] mb-8 group-hover:scale-110 transition-transform shadow-inner">
                            <Users class="h-8 w-8" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white tracking-tight mb-4">Forums Thématiques</h3>
                        <p class="text-sm text-zinc-500 font-medium border-l-3 border-[#008751]/20 pl-4 py-1 leading-relaxed">
                            Discutez de santé, d'éducation, d'environnement et d'entrepreneuriat social avec vos pairs.
                        </p>
                    </div>
                    
                    <div class="group bg-white dark:bg-zinc-900 p-10 rounded-[3rem] border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all hover:-translate-y-2">
                        <div class="h-16 w-16 rounded-[2rem] bg-[#FFCB05]/10 flex items-center justify-center text-[#FFCB05] mb-8 group-hover:scale-110 transition-transform shadow-inner">
                            <MessageSquare class="h-8 w-8" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white tracking-tight mb-4">Collaboration Directe</h3>
                        <p class="text-sm text-zinc-500 font-medium border-l-3 border-[#FFCB05]/20 pl-4 py-1 leading-relaxed">
                            Identifiez des partenaires potentiels et initiez des projets conjoints en quelques clics.
                        </p>
                    </div>

                    <div class="group bg-white dark:bg-zinc-900 p-10 rounded-[3rem] border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all hover:-translate-y-2">
                        <div class="h-16 w-16 rounded-[2rem] bg-[#E4002B]/10 flex items-center justify-center text-[#E4002B] mb-8 group-hover:scale-110 transition-transform shadow-inner">
                            <Share2 class="h-8 w-8" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white tracking-tight mb-4">Base Documentaire</h3>
                        <p class="text-sm text-zinc-500 font-medium border-l-3 border-[#E4002B]/20 pl-4 py-1 leading-relaxed">
                            Accédez à des guides, modèles et tutoriels partagés par les membres pour booster votre ONG.
                        </p>
                    </div>
                </div>

                <!-- Coming Soon Feature -->
                <div class="mt-24 bg-gradient-to-br from-[#310808] to-black p-10 sm:p-20 rounded-[4rem] text-white relative overflow-hidden shadow-3xl">
                    <div class="relative z-10 lg:flex items-center gap-16">
                        <div class="lg:w-1/2">
                            <div class="mb-6">
                                <span class="bg-[#FFCB05] text-black px-4 py-1.5 rounded-xl text-[10px] font-bold tracking-wider">En Développement</span>
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-bold tracking-tight mb-6 leading-none">Un Réseau Évolutif à <span class="text-[#008751]">Votre Écoute</span></h2>
                            <p class="text-zinc-400 text-base sm:text-lg font-medium mb-10 border-l-3 border-zinc-800/50 pl-8 leading-relaxed">Nous concevons un espace où chaque voix compte. D'ici peu, vous pourrez profiter d'une application mobile dédiée pour rester connecté partout.</p>
                            <button class="w-full sm:w-auto bg-[#008751] hover:bg-[#006b40] text-white font-bold px-10 py-5 rounded-2xl text-xs transition-all hover:scale-105 shadow-2xl shadow-[#008751]/20 hover:-translate-y-0.5">
                                Rejoindre la liste d'attente
                            </button>
                        </div>
                        <div class="lg:w-1/2 mt-12 lg:mt-0 grid grid-cols-2 gap-4">
                             <div class="h-40 bg-white/5 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center gap-3 shadow-inner">
                                <span class="text-2xl font-black text-[#008751]">50+</span>
                                <span class="text-[9px] font-bold text-zinc-500 text-center px-4 tracking-tight">Groupes de travail</span>
                            </div>
                            <div class="h-40 bg-white/5 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center gap-3 shadow-inner">
                                <span class="text-2xl font-black text-[#FFCB05]">10k+</span>
                                <span class="text-[9px] font-bold text-zinc-500 text-center px-4 tracking-tight">Ressources partagées</span>
                            </div>
                            <div class="h-40 bg-white/5 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center gap-3 shadow-inner">
                                <span class="text-2xl font-black text-white">24/7</span>
                                <span class="text-[9px] font-bold text-zinc-500 text-center px-4 tracking-tight">Support bénévole</span>
                            </div>
                            <div class="h-40 bg-white/5 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center gap-3 shadow-inner">
                                <span class="text-2xl font-black text-[#E4002B]">15</span>
                                <span class="text-[9px] font-bold text-zinc-500 text-center px-4 tracking-tight">Pays africains</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>

<style scoped>
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.animate-gradient {
    background-size: 200% auto;
    animation: gradient 8s linear infinite;
}
</style>
