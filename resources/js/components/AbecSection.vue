<!-- ABECSection.vue - Version Mobile First Compacte -->
<script setup lang="ts">
import { ArrowRight, Sparkles, Heart, Globe, ShieldCheck, Award, Users, Target, ChevronRight } from 'lucide-vue-next';

const abecFeatures = [
    {
        title: "Éveil des Consciences",
        description: "Promouvoir une citoyenneté active et responsable pour un impact durable.",
        icon: Sparkles,
        color: "text-raosc-green",
        bg: "bg-raosc-green/10"
    },
    {
        title: "Soutien aux OSC",
        description: "Accompagner les organisations dans leur professionnalisation et leur croissance.",
        icon: Heart,
        color: "text-raosc-red",
        bg: "bg-raosc-red/10"
    },
    {
        title: "Réseautage Africain",
        description: "Bâtir des ponts entre les acteurs du changement à travers tout le continent.",
        icon: Globe,
        color: "text-raosc-yellow",
        bg: "bg-raosc-yellow/10"
    }
];

const stats = [
    { value: "2018", label: "Création", icon: Award },
    { value: "+50", label: "Membres", icon: Users },
    { value: "+100", label: "Projets", icon: Target }
];
</script>

<template>
    <section class="py-12 sm:py-16 bg-white dark:bg-zinc-950 overflow-hidden">
        <!-- ============================================ -->
        <!-- EFFETS DE FOND SUBTILS (réduits sur mobile) -->
        <!-- ============================================ -->
        <div class="absolute inset-0 pointer-events-none opacity-30 sm:opacity-40">
            <div class="absolute top-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-raosc-green/5 rounded-full blur-[100px] translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 sm:w-96 sm:h-96 bg-raosc-yellow/5 rounded-full blur-[100px] -translate-x-1/2 translate-y-1/2"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stack vertical sur mobile, grille sur desktop -->
            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-8 lg:gap-12">
                
                <!-- ============================================ -->
                <!-- COLONNE GAUCHE - TEXTE ABEC (priorité mobile) -->
                <!-- ============================================ -->
                <div class="order-1 space-y-5 sm:space-y-6">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-1.5 bg-zinc-100 dark:bg-white/5 px-3 py-1.5 rounded-full">
                        <ShieldCheck class="w-3.5 h-3.5 text-raosc-green" />
                        <span class="text-[9px] sm:text-[10px] font-bold tracking-wider text-zinc-600 dark:text-zinc-400 uppercase">À propos de l'ABEC</span>
                    </div>
                    
                    <!-- Titre -->
                    <h2 class="text-2xl sm:text-3xl font-black text-zinc-900 dark:text-white leading-tight">
                        Association du Bien-Être<br />Communautaire 
                        <span class="text-raosc-green">(ABEC)</span>
                    </h2>
                    
                    <!-- Description courte -->
                    <div class="space-y-2 text-sm sm:text-base text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        <p>Organisation internationale à but non lucratif, reconnue sous le numéro <span class="font-mono text-xs bg-zinc-100 dark:bg-zinc-800 px-1 rounded">00001901/RDA/J06/SAAJP/BAPP</span>.</p>
                        <p>Fondée par des jeunes visionnaires, elle rassemble des membres de plusieurs nationalités.</p>
                    </div>

                    <!-- Stats - 3 colonnes sur mobile, inline sur desktop -->
                    <div class="grid grid-cols-3 gap-2 py-2">
                        <div v-for="(stat, idx) in stats" :key="idx" 
                             class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-900/50">
                            <component :is="stat.icon" class="w-4 h-4 text-raosc-green mx-auto mb-1" />
                            <div class="text-base sm:text-lg font-black text-zinc-900 dark:text-white">{{ stat.value }}</div>
                            <div class="text-[9px] text-zinc-500">{{ stat.label }}</div>
                        </div>
                    </div>

                    <!-- Features - 1 colonne sur mobile, 2 sur desktop -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div 
                            v-for="(feature, idx) in abecFeatures" 
                            :key="idx" 
                            class="flex gap-3 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-900/30 transition-colors"
                        >
                            <div :class="['h-8 w-8 shrink-0 rounded-lg flex items-center justify-center', feature.bg]">
                                <component :is="feature.icon" :class="['w-4 h-4', feature.color]" />
                            </div>
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-zinc-900 dark:text-white">{{ feature.title }}</h4>
                                <p class="text-[10px] sm:text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ feature.description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton CTA -->
                    <div class="pt-2">
                        <a 
                            href="https://universalwelfare.org/#about" 
                            target="_blank"
                            class="group inline-flex items-center gap-2 bg-zinc-900 dark:bg-white hover:bg-zinc-800 dark:hover:bg-zinc-200 text-white dark:text-zinc-900 font-semibold rounded-lg px-4 py-2.5 text-xs sm:text-sm transition-all duration-300 hover:gap-3 shadow-md"
                        >
                            En savoir plus
                            <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- COLONNE DROITE - IMAGE (compacte) -->
                <!-- ============================================ -->
                <div class="order-2 relative group mt-4 sm:mt-0">
                    <!-- Conteneur image avec ratio fixe -->
                    <div class="relative rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-md">
                        <img 
                            src="/image/6.jpg" 
                            alt="Réunion ABEC" 
                            class="w-full h-56 sm:h-64 object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                        
                        <!-- Overlay gradient léger -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                        
                        <!-- Badge flottant compact -->
                        <div class="absolute bottom-3 left-3 right-3 p-2.5 bg-black/40 backdrop-blur-sm rounded-lg">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-raosc-green to-raosc-yellow flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    A
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-bold text-[10px] sm:text-xs">Vision ABEC 2030</p>
                                    <p class="text-zinc-300 text-[8px] sm:text-[9px]">1000+ OSC accompagnées</p>
                                </div>
                                <div class="h-6 w-6 rounded-full bg-white/20 flex items-center justify-center">
                                    <ChevronRight class="w-3 h-3 text-white" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Badge légal compact (caché sur mobile très petit, visible tablette+) -->
                    <div class="hidden sm:flex flex-wrap justify-center gap-2 mt-3 text-[9px] text-zinc-400">
                        <span class="inline-flex items-center gap-1"><span class="w-1 h-1 rounded-full bg-raosc-green"></span> N° 00001901/RDA/J06/SAAJP/BAPP</span>
                        <span class="inline-flex items-center gap-1"><span class="w-1 h-1 rounded-full bg-raosc-yellow"></span> Reconnue officiellement</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* ============================================ */
/* TRANSITIONS LÉGÈRES */
/* ============================================ */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* ============================================ */
/* RESPONSIVE - MOBILE FIRST */
/* ============================================ */
/* Mobile par défaut (tout est déjà optimisé) */
/* Tablette (sm: 640px) - ajustements mineurs */
@media (min-width: 640px) {
    .container {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
}

/* Desktop (lg: 1024px) - grille activée */
@media (min-width: 1024px) {
    .container {
        padding-left: 2rem;
        padding-right: 2rem;
        max-width: 1280px;
    }
}

/* Grands écrans (xl: 1280px) */
@media (min-width: 1280px) {
    .container {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}
</style>