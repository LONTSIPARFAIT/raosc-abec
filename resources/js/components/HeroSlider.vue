<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRightIcon, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';
import { register } from '@/routes';

defineProps<{
    user: any;
}>();

// Slides du carousel avec leurs images, titres et descriptions
const slides = [
    {
        image: 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=2070&auto=format&fit=crop',
        title: 'Fédérer pour Bâtir un Avenir Meilleur',
        description: 'Découvrez la plateforme collaborative du Réseau Africain des Organisations de la Société Civile.',
    },
    {
        image: 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=2070&auto=format&fit=crop',
        title: "L'Humain au Cœur de l'Innovation Sociale",
        description: "L'ABEC soutient le développement durable et les droits de l'homme à travers le réseau RAOSC.",
    },
    {
        image: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2113&auto=format&fit=crop',
        title: 'Promotion de la Paix et du Bien-être',
        description: "Rejoignez-nous pour promouvoir l'égalité et l'équité au sein de nos communautés.",
    }
];

// Index du slide actuellement affiché
const currentIndex = ref(0);
let timer: any = null;

// Direction de l'animation (gauche ou droite)
const direction = ref('next');

// Passage au slide suivant
const nextSlide = () => {
    direction.value = 'next';
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

// Passage au slide précédent
const prevSlide = () => {
    direction.value = 'prev';
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length;
};

// Démarrage du carousel automatique au chargement
onMounted(() => {
    timer = setInterval(nextSlide, 7000);
});

// Nettoyage du timer à la destruction du composant
onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
<div class="relative w-full h-[400px] sm:h-[500px] overflow-hidden bg-zinc-950">
    <!--
      SECTION 1: IMAGES DE FOND
      - Les images changent avec une transition slide horizontale
      - L'image active a un zoom léger (scale-105)
    -->
    <div class="absolute inset-0 w-full h-full">
        <div class="relative w-full h-full">
            <div
                v-for="(slide, index) in slides"
                :key="'img-'+index"
                :class="[
                    'absolute inset-0 w-full h-full transition-all duration-700 ease-in-out',
                    currentIndex === index
                        ? 'translate-x-0 opacity-100 z-10'
                        : direction === 'next' && index < currentIndex
                            ? '-translate-x-full opacity-0 z-0'
                            : direction === 'next' && index > currentIndex
                                ? 'translate-x-full opacity-0 z-0'
                                : direction === 'prev' && index < currentIndex
                                    ? '-translate-x-full opacity-0 z-0'
                                    : 'translate-x-full opacity-0 z-0'
                ]"
            >
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="w-full h-full object-cover transition-transform duration-[7000ms] scale-105"
                    :style="{ transform: currentIndex === index ? 'scale(1)' : 'scale(1.05)' }"
                />
                <!-- Dégradé pour améliorer la lisibilité du texte -->
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
            </div>
        </div>
    </div>

    <!--
      SECTION 2: CONTENU TEXTE
      - Centré verticalement avec flex justify-center
      - Le texte glisse horizontalement comme un vrai carousel
      - pb-20 pour laisser de l'espace pour les boutons en bas
    -->
    <div class="relative z-10 h-full flex flex-col justify-center px-6 lg:px-12 max-w-7xl mx-auto pb-20">
        <div class="max-w-3xl">
            <div class="relative overflow-hidden">
                <div
                    v-for="(slide, index) in slides"
                    :key="'text-'+index"
                    :class="[
                        'transition-all duration-500 ease-out absolute w-full',
                        currentIndex === index
                            ? 'translate-x-0 opacity-100 z-10 relative'
                            : direction === 'next' && index < currentIndex
                                ? '-translate-x-full opacity-0 z-0 absolute'
                                : direction === 'next' && index > currentIndex
                                    ? 'translate-x-full opacity-0 z-0 absolute'
                                    : direction === 'prev' && index < currentIndex
                                        ? '-translate-x-full opacity-0 z-0 absolute'
                                        : 'translate-x-full opacity-0 z-0 absolute'
                    ]"
                >
                    <div class="space-y-4">
                        <!-- Badge indicateur -->
                        <span class="inline-block text-raosc-yellow font-bold tracking-[0.2em] text-[10px] sm:text-xs">
                            Initiative de l'Organisation ABEC
                        </span>
                        <!-- Titre principal -->
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.15] tracking-tight">
                            {{ slide.title }}
                        </h1>
                        <!-- Description -->
                        <p class="text-zinc-300 text-base sm:text-lg font-medium max-w-2xl leading-relaxed italic border-l-3 border-raosc-green pl-6 py-1">
                            {{ slide.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
      SECTION 3: BOUTONS D'ACTION
      - Position: absolute bottom-20 (fixe en bas, ne disparaît pas)
      - Ne fait PAS partie de la transition du texte
    -->
    <div class="absolute bottom-20 left-6 lg:left-12 z-20">
        <div class="flex flex-wrap gap-4 items-center">
            <Link
                href="/rao"
                class="rounded-full bg-raosc-green px-8 py-3 text-xs font-bold text-white shadow-lg shadow-raosc-green/20 hover:bg-[#006b40] transition-all hover:-translate-y-0.5"
                prefetch
            >
                Explorer l'annuaire
            </Link>
            <Link
                v-if="!user"
                :href="register()"
                class="flex items-center gap-2 text-white text-xs font-bold hover:text-raosc-yellow transition-colors group"
                prefetch
            >
                Nous Rejoindre
                <ArrowRightIcon class="h-4 w-4 transition-transform group-hover:translate-x-1" />
            </Link>
        </div>
    </div>

    <!--
      SECTION 4: CONTROLES DE NAVIGATION
      - Boutons Prev/Next et Dots
      - Position: absolute bottom-6 (tout en bas)
      - Restent fixes et ne disparaissent pas
    -->
    <div class="absolute bottom-6 inset-x-0 z-20 flex justify-between px-6 lg:px-12 items-center max-w-7xl mx-auto">
        <!-- Boutons Prev/Next -->
        <div class="flex gap-3">
            <button
                @click="prevSlide"
                class="h-9 w-9 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-black transition-all"
                aria-label="Diapositive précédente"
            >
                <ChevronLeft class="h-4 w-4" />
            </button>
            <button
                @click="nextSlide"
                class="h-9 w-9 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-black transition-all"
                aria-label="Diapositive suivante"
            >
                <ChevronRight class="h-4 w-4" />
            </button>
        </div>

        <!-- Dots indicateurs -->
        <div class="flex gap-2">
            <button
                v-for="(_, index) in slides"
                :key="'dot-'+index"
                @click="currentIndex = index"
                class="transition-all duration-300 h-1 rounded-full bg-white"
                :class="currentIndex === index ? 'w-6 opacity-100' : 'w-2 opacity-40 hover:opacity-70'"
                :aria-label="`Aller à la diapositive ${index + 1}`"
            ></button>
        </div>
    </div>
</div>
</template>

<style scoped>
/* Suppression des animations fade et slide-fade */
/* Maintenant les animations sont gérées par les classes CSS de transition */
</style>
