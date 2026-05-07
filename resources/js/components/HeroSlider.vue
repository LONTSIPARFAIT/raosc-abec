<!-- HeroSlider.vue - Version corrigée (flèches centrées sur desktop, cachées sur mobile) -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRightIcon, ChevronLeft, ChevronRight, Sparkles, TrendingUp, Heart, Award, Globe, Shield } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref, computed } from 'vue';
import { register } from '@/routes';

defineProps<{
    user: any;
}>();

const slides = [
    {
        id: 1,
        image: '/image/fotos2.jpg',
        title: "Bâtir l'Avenir de l'Afrique Ensemble",
        description: 'Le RAOSC est une initiative de l\'ABEC (Cameroun) pour unir les forces de la société civile africaine et promouvoir un développement durable et inclusif.',
        badge: 'Initiative ABEC Cameroun',
        icon: Award
    },
    {
        id: 2,
        image: '/image/p.png',
        title: "L'Impact Social au Cœur du Continent",
        description: 'Découvrez les actions concrètes menées par nos organisations membres à travers toute l\'Afrique. Ensemble, nous faisons la différence.',
        badge: 'Solidarité Africaine',
        icon: Globe
    },
    {
        id: 3,
        image: 'https://plus.unsplash.com/premium_photo-1723489220312-27a78ca4b62a?q=80&w=779&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        title: 'Le Réseau de l\'Éveil des Consciences',
        description: 'Rejoignez une coalition dynamique dédiée au développement durable, à l\'équité sociale et à la transformation positive du continent.',
        badge: 'Engagement Citoyen',
        icon: Shield
    }
];

const currentIndex = ref(0);
let timer: any = null;
const direction = ref('next');
const isHovering = ref(false);
const isAnimating = ref(false);

const currentSlide = computed(() => slides[currentIndex.value]);

const nextSlide = () => {
    if (isAnimating.value) return;
    isAnimating.value = true;
    direction.value = 'next';
    currentIndex.value = (currentIndex.value + 1) % slides.length;
    setTimeout(() => {
        isAnimating.value = false;
    }, 600);
};

const prevSlide = () => {
    if (isAnimating.value) return;
    isAnimating.value = true;
    direction.value = 'prev';
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length;
    setTimeout(() => {
        isAnimating.value = false;
    }, 600);
};

const goToSlide = (index: number) => {
    if (isAnimating.value || index === currentIndex.value) return;
    isAnimating.value = true;
    direction.value = index > currentIndex.value ? 'next' : 'prev';
    currentIndex.value = index;
    setTimeout(() => {
        isAnimating.value = false;
    }, 600);
};

onMounted(() => {
    timer = setInterval(() => {
        if (!isHovering.value && !isAnimating.value) nextSlide();
    }, 7000);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
    <div 
        class="relative w-full min-h-[550px] sm:min-h-[650px] lg:min-h-[750px] overflow-hidden bg-zinc-950"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <!-- ============================================ -->
        <!-- EFFETS DE FOND DYNAMIQUES -->
        <!-- ============================================ -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-80 h-80 bg-raosc-green/30 rounded-full blur-[150px] animate-float"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-raosc-yellow/20 rounded-full blur-[150px] animate-float-delay"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-raosc-red/10 rounded-full blur-[180px]"></div>
        </div>

        <!-- ============================================ -->
        <!-- IMAGES DE FOND AVEC TRANSITION -->
        <!-- ============================================ -->
        <div class="absolute inset-0 w-full h-full">
            <div 
                v-for="(slide, index) in slides" 
                :key="slide.id"
                class="absolute inset-0 w-full h-full transition-all duration-1000 ease-out"
                :class="[
                    currentIndex === index
                        ? 'opacity-100 scale-100 z-10'
                        : 'opacity-0 scale-110 z-0'
                ]"
            >
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="w-full h-full object-cover transition-transform duration-[12000ms] ease-out"
                    :class="currentIndex === index ? 'scale-110' : 'scale-100'"
                />
                <!-- Dégradés superposés -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/40"></div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- FLÈCHES DE NAVIGATION (centrées verticalement) -->
        <!-- ============================================ -->
        <!-- Flèche gauche -->
        <button
            @click="prevSlide"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-30 hidden sm:flex items-center justify-center w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm border border-white/20 text-white hover:bg-raosc-green hover:scale-110 transition-all duration-300"
            aria-label="Diapositive précédente"
        >
            <ChevronLeft class="w-5 h-5" />
        </button>

        <!-- Flèche droite -->
        <button
            @click="nextSlide"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-30 hidden sm:flex items-center justify-center w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm border border-white/20 text-white hover:bg-raosc-green hover:scale-110 transition-all duration-300"
            aria-label="Diapositive suivante"
        >
            <ChevronRight class="w-5 h-5" />
        </button>

        <!-- ============================================ -->
        <!-- CONTENU TEXTUEL AVEC ANIMATIONS -->
        <!-- ============================================ -->
        <div class="relative z-20 h-full flex items-center">
            <div class="container mx-auto px-6 lg:px-12 py-20">
                <div class="max-w-3xl">
                    <transition
                        :name="direction === 'next' ? 'slide-next' : 'slide-prev'"
                        mode="out-in"
                    >
                        <div :key="currentIndex" class="space-y-6">
                            <!-- Badge -->
                            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 hover:scale-105 transition-transform duration-300">
                                <component :is="currentSlide.icon" class="w-3.5 h-3.5 text-raosc-yellow" />
                                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-raosc-yellow uppercase">
                                    {{ currentSlide.badge }}
                                </span>
                            </div>
                            
                            <!-- Titre -->
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-[1.15] tracking-tight">
                                {{ currentSlide.title }}
                            </h1>
                            
                            <!-- Description avec bordure décorative -->
                            <div class="relative pl-5">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-raosc-green via-raosc-yellow to-raosc-red rounded-full"></div>
                                <p class="text-base sm:text-lg text-zinc-200 font-medium max-w-2xl leading-relaxed">
                                    {{ currentSlide.description }}
                                </p>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- BOUTONS D'ACTION -->
        <!-- ============================================ -->
        <div class="absolute bottom-6 sm:bottom-28 left-0 right-0 z-20">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="flex flex-wrap gap-4 items-center">
                    <!-- Bouton principal -->
                    <Link
                        href="/rao"
                        class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-raosc-green to-raosc-green/80 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-raosc-green/30 transition-all duration-300 hover:scale-105 hover:shadow-xl"
                        prefetch
                    >
                        <span class="relative z-10 flex items-center gap-2">
                            Explorer l'annuaire
                            <TrendingUp class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300" />
                        </span>
                        <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
                    </Link>
                    
                    <!-- Bouton secondaire -->
                    <Link
                        v-if="!user"
                        :href="register()"
                        class="group flex items-center gap-2 text-white text-sm font-semibold hover:text-raosc-yellow transition-all duration-300 hover:gap-3 bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20 hover:bg-white/20"
                        prefetch
                    >
                        <Heart class="w-4 h-4 group-hover:scale-110 transition-transform duration-300" />
                        Nous Rejoindre
                        <ArrowRightIcon class="h-4 w-4 transition-all duration-300 group-hover:translate-x-1" />
                    </Link>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- INDICATEURS DE PROGRESSION (dots) EN BAS -->
        <!-- ============================================ -->
        <div class="absolute bottom-6 inset-x-0 z-20">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="flex justify-center items-center">
                    <!-- Dots -->
                    <div class="flex gap-2">
                        <button
                            v-for="(slide, index) in slides"
                            :key="index"
                            @click="goToSlide(index)"
                            class="transition-all duration-500 rounded-full bg-white/50 hover:bg-white focus:outline-none focus:ring-2 focus:ring-raosc-green"
                            :class="[
                                currentIndex === index 
                                    ? 'w-8 h-1.5 bg-raosc-green opacity-100' 
                                    : 'w-1.5 h-1.5 opacity-40 hover:opacity-70 hover:scale-110'
                            ]"
                            :aria-label="`Aller à la diapositive ${index + 1}`"
                        >
                            <span class="sr-only">Diapositive {{ index + 1 }}</span>
                        </button>
                    </div>

                    <!-- Barre de progression (optionnel) -->
                    <div class="hidden md:block w-32 h-px bg-white/20 rounded-full overflow-hidden ml-4">
                        <div 
                            class="h-full bg-gradient-to-r from-raosc-green to-raosc-yellow rounded-full transition-all duration-[7000ms] linear"
                            :class="isHovering ? 'paused' : 'running'"
                            :style="{ width: isHovering ? '0%' : '100%' }"
                            :key="currentIndex"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- OVERLAY DE BRILLANCE AU SURVOL -->
        <!-- ============================================ -->
        <div class="absolute inset-0 z-15 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-700">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
        </div>
    </div>
</template>

<style scoped>
/* ============================================ */
/* ANIMATIONS FONDAMENTALES */
/* ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(30px, -30px) scale(1.1);
    }
}

@keyframes floatDelay {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(-30px, 30px) scale(1.1);
    }
}

/* ============================================ */
/* CLASSES D'ANIMATION */
/* ============================================ */
.animate-float {
    animation: float 10s ease-in-out infinite;
}

.animate-float-delay {
    animation: floatDelay 12s ease-in-out infinite;
}

/* ============================================ */
/* TRANSITIONS ENTRE TEXTES (SLIDE X) */
/* ============================================ */
.slide-next-enter-active,
.slide-next-leave-active,
.slide-prev-enter-active,
.slide-prev-leave-active {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-next-enter-from {
    opacity: 0;
    transform: translateX(50px);
}

.slide-next-leave-to {
    opacity: 0;
    transform: translateX(-50px);
}

.slide-prev-enter-from {
    opacity: 0;
    transform: translateX(-50px);
}

.slide-prev-leave-to {
    opacity: 0;
    transform: translateX(50px);
}

/* ============================================ */
/* BARRE DE PROGRESSION */
/* ============================================ */
.running {
    animation-play-state: running;
}

.paused {
    animation-play-state: paused;
}

/* ============================================ */
/* EFFET DE TRANSITION GLOBALE */
/* ============================================ */
.slide-image-enter-active,
.slide-image-leave-active {
    transition: opacity 1s ease, transform 1s ease;
}

.slide-image-enter-from {
    opacity: 0;
    transform: scale(1.1);
}

.slide-image-leave-to {
    opacity: 0;
    transform: scale(1);
}
</style>