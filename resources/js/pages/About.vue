<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Target, Eye, ShieldCheck, Heart, Award, Globe, Users, Sparkles, ChevronRight, ArrowRight } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <PublicLayout>
        <Head title="À Propos - RAOSC" />

        <main class="overflow-hidden">
            <!-- Header Section avec effet glassmorphique -->
            <div class="relative bg-gradient-to-br from-zinc-950 via-zinc-900 to-zinc-950 py-20 sm:py-28 px-6 overflow-hidden">
                <!-- Effets de fond animés -->
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-20 rounded-full blur-[120px] animate-pulse"></div>
                    <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-raosc-yellow opacity-10 rounded-full blur-[120px] animate-pulse delay-1000"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-raosc-brown opacity-5 rounded-full blur-[150px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/10 backdrop-blur-sm px-5 py-2 border border-white/20 hover:scale-105 transition-transform duration-300">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Notre Vision Panafricaine</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6 animate-fade-in">
                        Fédérer pour <span class="text-raosc-yellow bg-gradient-to-r from-raosc-yellow to-raosc-green bg-clip-text text-transparent">Mieux Servir</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium leading-relaxed animate-fade-in-up">
                        Le Réseau Africain des Organisations de la Société Civile (RAOSC) est le pilier opérationnel de l'ONG <span class="text-raosc-yellow font-semibold">ABEC</span>, dédié à la cartographie et à la synergie des acteurs du changement en Afrique.
                    </p>
                    
                    <!-- Indicateur de scroll -->
                    <div class="absolute bottom-[-40px] left-1/2 -translate-x-1/2 animate-bounce">
                        <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                            <div class="w-1 h-2 bg-white/50 rounded-full mt-2 animate-scroll"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission & Vision Section -->
            <div class="py-20 sm:py-28 bg-gradient-to-br from-white to-zinc-50 dark:from-zinc-950 dark:to-zinc-900 px-6">
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <div class="space-y-6 animate-fade-in-left">
                            <div class="inline-flex items-center gap-2 bg-raosc-green/10 backdrop-blur-sm px-4 py-1.5 rounded-full hover:scale-105 transition-transform duration-300">
                                <Sparkles class="w-3 h-3 text-raosc-green" />
                                <span class="text-[10px] font-bold text-raosc-green uppercase tracking-wider">Notre raison d'être</span>
                            </div>
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-zinc-900 dark:text-white leading-tight tracking-tight">
                                Une mission, un <span class="text-raosc-green relative inline-block">
                                    réseau
                                    <svg class="absolute bottom-2 left-0 w-full h-3 text-raosc-green/30 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                                        <path d="M0 5 Q 25 10, 50 5 T 100 5" stroke="currentColor" fill="none" stroke-width="2"/>
                                    </svg>
                                </span>
                            </h2>
                            <div class="space-y-5 text-zinc-600 dark:text-zinc-400 text-base leading-relaxed">
                                <p class="hover:translate-x-2 transition-transform duration-300">
                                    Le <span class="font-semibold text-raosc-green">RAOSC</span> a été fondé sur le constat que de nombreuses actions sociales en Afrique manquent de visibilité et de coordination. Porté par l'<span class="font-semibold">ABEC</span>, ce réseau numérique permet de structurer les efforts locaux pour un impact global.
                                </p>
                                <p class="hover:translate-x-2 transition-transform duration-300 delay-100">
                                    Nous offrons aux organisations à but non lucratif une plateforme vitrine pour exposer leurs projets, leurs succès et leurs besoins, tout en garantissant aux donateurs et partenaires une transparence totale grâce à notre processus de validation rigoureux.
                                </p>
                            </div>
                            
                            <div class="pt-4">
                                <a href="#" class="inline-flex items-center gap-2 text-raosc-green font-semibold text-sm group hover:gap-3 transition-all duration-300">
                                    En savoir plus sur notre approche
                                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" />
                                </a>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5 animate-fade-in-right">
                            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-raosc-green/20 to-raosc-green/5 flex items-center justify-center text-raosc-green mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <Target class="h-6 w-6" />
                                </div>
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2 text-lg">Mission</h3>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Accélérer le développement par la collaboration et la mutualisation des ressources.</p>
                            </div>
                            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group mt-8 lg:mt-12">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-raosc-yellow/20 to-raosc-yellow/5 flex items-center justify-center text-raosc-yellow mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <Eye class="h-6 w-6" />
                                </div>
                                <h3 class="font-bold text-zinc-900 dark:text-white mb-2 text-lg">Vision</h3>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Un réseau panafricain uni, où chaque acteur contribue à un développement durable et inclusif.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Valeurs Section avec glassmorphism -->
            <div class="relative bg-gradient-to-br from-zinc-50 to-white dark:from-zinc-900 dark:to-zinc-950 py-20 sm:py-28 px-6 overflow-hidden">
                <!-- Effets de fond -->
                <div class="absolute inset-0 pointer-events-none opacity-30 dark:opacity-10">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-raosc-green rounded-full blur-[100px]"></div>
                    <div class="absolute bottom-20 right-10 w-72 h-72 bg-raosc-yellow rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-7xl relative z-10">
                    <div class="text-center mb-16">
                        <div class="inline-flex items-center gap-2 bg-gradient-to-r from-raosc-green/10 to-raosc-yellow/10 backdrop-blur-sm px-4 py-1.5 rounded-full mb-4">
                            <span class="text-[10px] font-bold text-raosc-green uppercase tracking-wider">Nos fondements</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-white mt-3">Nos Valeurs</h2>
                        <p class="text-zinc-600 dark:text-zinc-400 mt-4 max-w-2xl mx-auto">Des principes solides qui guident chacune de nos actions</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                        <div class="group bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg hover:shadow-2xl transition-all duration-500 hover:scale-105 hover:border-raosc-green/30 text-center">
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-raosc-green/20 to-raosc-green/5 flex items-center justify-center mx-auto text-raosc-green mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:shadow-lg">
                                <ShieldCheck class="h-8 w-8" />
                            </div>
                            <h3 class="font-bold text-xl text-zinc-900 dark:text-white mb-3">Transparence</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">L'intégrité au cœur de chaque interaction au sein du réseau.</p>
                            <div class="mt-4 h-px w-0 group-hover:w-full bg-raosc-green/30 transition-all duration-500 mx-auto"></div>
                        </div>
                        
                        <div class="group bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg hover:shadow-2xl transition-all duration-500 hover:scale-105 hover:border-raosc-yellow/30 text-center">
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-raosc-yellow/20 to-raosc-yellow/5 flex items-center justify-center mx-auto text-raosc-yellow mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:shadow-lg">
                                <Heart class="h-8 w-8" />
                            </div>
                            <h3 class="font-bold text-xl text-zinc-900 dark:text-white mb-3">Solidarité</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">L'entraide mutuelle pour un progrès collectif durable.</p>
                            <div class="mt-4 h-px w-0 group-hover:w-full bg-raosc-yellow/30 transition-all duration-500 mx-auto"></div>
                        </div>
                        
                        <div class="group bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg hover:shadow-2xl transition-all duration-500 hover:scale-105 hover:border-raosc-red/30 text-center">
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-raosc-red/20 to-raosc-red/5 flex items-center justify-center mx-auto text-raosc-red mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:shadow-lg">
                                <Award class="h-8 w-8" />
                            </div>
                            <h3 class="font-bold text-xl text-zinc-900 dark:text-white mb-3">Excellence</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">La recherche permanente de la qualité dans l'action sociale.</p>
                            <div class="mt-4 h-px w-0 group-hover:w-full bg-raosc-red/30 transition-all duration-500 mx-auto"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action Section -->
            <div class="relative py-20 px-6 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-raosc-green/5 to-raosc-yellow/5"></div>
                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="bg-gradient-to-r from-zinc-900 to-zinc-800 dark:from-zinc-800 dark:to-zinc-900 rounded-3xl p-10 sm:p-12 shadow-2xl border border-white/10">
                        <Globe class="w-12 h-12 text-raosc-yellow mx-auto mb-6" />
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Rejoignez le mouvement</h2>
                        <p class="text-zinc-300 mb-8 max-w-lg mx-auto">Intégrez le plus grand réseau d'acteurs du changement en Afrique</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="/register" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-raosc-green text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-xl transition-all duration-300">
                                <Users class="w-4 h-4" />
                                Devenir membre
                            </a>
                            <a href="/contact" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white/10 backdrop-blur-sm text-white font-bold rounded-2xl text-sm hover:bg-white/20 hover:scale-105 transition-all duration-300 border border-white/20">
                                Contactez-nous
                                <ChevronRight class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>

<style scoped>
/* Animations d'entrée */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scroll {
    0% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(10px);
    }
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.animate-fade-in-left {
    animation: fadeInLeft 0.8s ease-out forwards;
}

.animate-fade-in-right {
    animation: fadeInRight 0.8s ease-out forwards;
}

.animate-scroll {
    animation: scroll 1.5s ease-in-out infinite;
}

.animate-pulse {
    animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.delay-1000 {
    animation-delay: 1s;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.2;
    }
    50% {
        opacity: 0.4;
    }
}
</style>