<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRightIcon, ChevronLeft, ChevronRight, Sparkles, TrendingUp, Heart } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';
import { register } from '@/routes';

defineProps<{
    user: any;
}>();

const slides = [
    {
        image: 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=2070&auto=format&fit=crop',
        title: 'Fédérer pour Bâtir un Avenir Meilleur',
        description: 'Découvrez la plateforme collaborative du Réseau Africain des Organisations de la Société Civile.',
        badge: 'Initiative de l\'Organisation ABEC'
    },
    {
        image: 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=2070&auto=format&fit=crop',
        title: "L'Humain au Cœur de l'Innovation Sociale",
        description: "L'ABEC soutient le développement durable et les droits de l'homme à travers le réseau RAOSC.",
        badge: 'Innovation Sociale'
    },
    {
        image: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2113&auto=format&fit=crop',
        title: 'Promotion de la Paix et du Bien-être',
        description: "Rejoignez-nous pour promouvoir l'égalité et l'équité au sein de nos communautés.",
        badge: 'Paix & Solidarité'
    }
];

const currentIndex = ref(0);
let timer: any = null;
const direction = ref('next');
const isHovering = ref(false);

const nextSlide = () => {
    direction.value = 'next';
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

const prevSlide = () => {
    direction.value = 'prev';
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length;
};

const goToSlide = (index: number) => {
    direction.value = index > currentIndex.value ? 'next' : 'prev';
    currentIndex.value = index;
};

onMounted(() => {
    timer = setInterval(() => {
        if (!isHovering.value) nextSlide();
    }, 7000);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
<div 
    class="relative w-full h-[500px] sm:h-[600px] lg:h-[700px] overflow-hidden bg-zinc-950 group"
    @mouseenter="isHovering = true"
    @mouseleave="isHovering = false"
>
    <!-- Effets de fond dynamiques -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-raosc-green/20 rounded-full blur-[120px] animate-float"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-raosc-yellow/20 rounded-full blur-[120px] animate-float-delay"></div>
    </div>

    <!-- IMAGES DE FOND -->
    <div class="absolute inset-0 w-full h-full">
        <div class="relative w-full h-full">
            <div
                v-for="(slide, index) in slides"
                :key="'img-'+index"
                :class="[
                    'absolute inset-0 w-full h-full transition-all duration-1000 ease-out',
                    currentIndex === index
                        ? 'translate-x-0 opacity-100 z-10 scale-100'
                        : 'translate-x-0 opacity-0 z-0 scale-110'
                ]"
            >
                <img
                    :src="slide.image"
                    :alt="slide.title"
                    class="w-full h-full object-cover transition-transform duration-[10000ms]"
                    :class="currentIndex === index ? 'scale-110' : 'scale-100'"
                />
                <!-- Dégradé amélioré -->
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent"></div>
            </div>
        </div>
    </div>

    <!-- CONTENU TEXTE AVEC ANIMATION D'ENTRÉE -->
    <div class="relative z-20 h-full flex flex-col justify-center px-6 lg:px-12 max-w-7xl mx-auto pb-24">
        <div class="max-w-3xl">
            <transition
                :name="direction === 'next' ? 'slide-next' : 'slide-prev'"
                mode="out-in"
            >
                <div :key="currentIndex" class="space-y-5">
                    <!-- Badge avec effet glassmorphique -->
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20 hover:scale-105 transition-transform duration-300">
                        <Sparkles class="w-3 h-3 text-raosc-yellow animate-pulse" />
                        <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-raosc-yellow uppercase">
                            {{ slides[currentIndex].badge }}
                        </span>
                    </div>
                    
                    <!-- Titre avec animation -->
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white leading-[1.15] tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                        {{ slides[currentIndex].title }}
                    </h1>
                    
                    <!-- Description avec bordure animée -->
                    <p class="text-zinc-200 text-base sm:text-lg font-medium max-w-2xl leading-relaxed pl-6 py-1 animate-fade-in-up relative" style="animation-delay: 0.2s">
                        <span class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-raosc-green to-raosc-yellow rounded-full animate-slide-down"></span>
                        {{ slides[currentIndex].description }}
                    </p>
                </div>
            </transition>
        </div>
    </div>

    <!-- BOUTONS D'ACTION -->
    <div class="absolute bottom-24 left-6 lg:left-12 z-20">
        <div class="flex flex-wrap gap-4 items-center">
            <Link
                href="/rao"
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-raosc-green to-raosc-green/80 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-raosc-green/20 transition-all duration-300 hover:scale-105 hover:shadow-xl"
                prefetch
            >
                <span class="relative z-10 flex items-center gap-2">
                    Explorer l'annuaire
                    <TrendingUp class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300" />
                </span>
                <span class="absolute inset-0 bg-gradient-to-r from-raosc-green/0 via-white/20 to-raosc-green/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            </Link>
            <Link
                v-if="!user"
                :href="register()"
                class="group flex items-center gap-2 text-white text-sm font-bold hover:text-raosc-yellow transition-all duration-300 hover:gap-3"
                prefetch
            >
                <Heart class="w-4 h-4 group-hover:scale-110 transition-transform duration-300" />
                Nous Rejoindre
                <ArrowRightIcon class="h-4 w-4 transition-all duration-300 group-hover:translate-x-1" />
            </Link>
        </div>
    </div>

    <!-- CONTROLES DE NAVIGATION -->
    <div class="absolute bottom-6 inset-x-0 z-20 flex justify-between px-6 lg:px-12 items-center max-w-7xl mx-auto">
        <div class="flex gap-3">
            <button
                @click="prevSlide"
                class="h-10 w-10 backdrop-blur-md bg-white/10 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-raosc-green hover:border-raosc-green transition-all duration-300 hover:scale-110 group"
                aria-label="Diapositive précédente"
            >
                <ChevronLeft class="h-4 w-4 group-hover:-translate-x-0.5 transition-transform duration-300" />
            </button>
            <button
                @click="nextSlide"
                class="h-10 w-10 backdrop-blur-md bg-white/10 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-raosc-green hover:border-raosc-green transition-all duration-300 hover:scale-110 group"
                aria-label="Diapositive suivante"
            >
                <ChevronRight class="h-4 w-4 group-hover:translate-x-0.5 transition-transform duration-300" />
            </button>
        </div>

        <!-- Indicateurs de progression -->
        <div class="flex gap-3">
            <button
                v-for="(_, index) in slides"
                :key="'dot-'+index"
                @click="goToSlide(index)"
                class="transition-all duration-500 rounded-full bg-white/50 hover:bg-white"
                :class="[
                    currentIndex === index 
                        ? 'w-8 h-2 opacity-100 bg-raosc-green' 
                        : 'w-2 h-2 opacity-40 hover:opacity-70 hover:scale-110'
                ]"
                :aria-label="`Aller à la diapositive ${index + 1}`"
            >
                <span class="sr-only">Diapositive {{ index + 1 }}</span>
            </button>
        </div>
        
        <!-- Timer progress bar -->
        <div class="hidden sm:block w-24 h-px bg-white/20 rounded-full overflow-hidden">
            <div 
                class="h-full bg-raosc-green rounded-full transition-all duration-[7000ms] linear"
                :class="isHovering ? 'paused' : 'running'"
                :style="{ width: isHovering ? '0%' : '100%' }"
                :key="currentIndex"
            ></div>
        </div>
    </div>

    <!-- Overlay de transition entre slides -->
    <div class="absolute inset-0 z-15 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
    </div>
</div>
</template>

<style scoped>
/* Animations d'entrée pour le texte */
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

@keyframes slideDown {
    from {
        transform: scaleY(0);
    }
    to {
        transform: scaleY(1);
    }
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(20px, -20px) scale(1.1);
    }
}

@keyframes floatDelay {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(-20px, 20px) scale(1.1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

.animate-slide-down {
    animation: slideDown 0.5s ease-out 0.3s both;
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

.animate-float-delay {
    animation: floatDelay 10s ease-in-out infinite;
}

/* Transitions entre les textes */
.slide-next-enter-active,
.slide-next-leave-active,
.slide-prev-enter-active,
.slide-prev-leave-active {
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-next-enter-from {
    opacity: 0;
    transform: translateX(60px);
}

.slide-next-leave-to {
    opacity: 0;
    transform: translateX(-60px);
}

.slide-prev-enter-from {
    opacity: 0;
    transform: translateX(-60px);
}

.slide-prev-leave-to {
    opacity: 0;
    transform: translateX(60px);
}

/* Animation de la barre de progression */
.running {
    animation-play-state: running;
}

.paused {
    animation-play-state: paused;
}

/* Effet de brillance sur les boutons */
@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}
</style>