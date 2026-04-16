<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRightIcon, ChevronLeft, ChevronRight } from 'lucide-vue-next';
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

const currentIndex = ref(0);
let timer: any = null;
const direction = ref('next');

const nextSlide = () => {
    direction.value = 'next';
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

const prevSlide = () => {
    direction.value = 'prev';
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length;
};

onMounted(() => {
    timer = setInterval(nextSlide, 7000);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
<div class="relative w-full h-[400px] sm:h-[500px] overflow-hidden bg-zinc-950">
    <!-- IMAGES DE FOND -->
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
                    class="w-full h-full object-cover transition-transform duration-[7000ms]"
                    :class="currentIndex === index ? 'scale-100' : 'scale-105'"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
            </div>
        </div>
    </div>

    <!-- CONTENU TEXTE AVEC ANIMATION D'ENTRÉE -->
    <div class="relative z-10 h-full flex flex-col justify-center px-6 lg:px-12 max-w-7xl mx-auto pb-20">
        <div class="max-w-3xl">
            <transition
                :name="direction === 'next' ? 'slide-next' : 'slide-prev'"
                mode="out-in"
            >
                <div :key="currentIndex" class="space-y-4">
                    <span class="inline-block text-raosc-yellow font-bold tracking-[0.2em] text-[10px] sm:text-xs animate-fade-in-up">
                        Initiative de l'Organisation ABEC
                    </span>
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.15] tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                        {{ slides[currentIndex].title }}
                    </h1>
                    <p class="text-zinc-300 text-base sm:text-lg font-medium max-w-2xl leading-relaxed italic border-l-3 border-raosc-green pl-6 py-1 animate-fade-in-up" style="animation-delay: 0.2s">
                        {{ slides[currentIndex].description }}
                    </p>
                </div>
            </transition>
        </div>
    </div>

    <!-- BOUTONS D'ACTION -->
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

    <!-- CONTROLES DE NAVIGATION -->
    <div class="absolute bottom-6 inset-x-0 z-20 flex justify-between px-6 lg:px-12 items-center max-w-7xl mx-auto">
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

        <div class="flex gap-2">
            <button
                v-for="(_, index) in slides"
                :key="'dot-'+index"
                @click="currentIndex = index; direction = index > currentIndex ? 'next' : 'prev'"
                class="transition-all duration-300 h-1 rounded-full bg-white"
                :class="currentIndex === index ? 'w-6 opacity-100' : 'w-2 opacity-40 hover:opacity-70'"
                :aria-label="`Aller à la diapositive ${index + 1}`"
            ></button>
        </div>
    </div>
</div>
</template>

<style scoped>
/* Animations d'entrée pour le texte */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
}

/* Transitions entre les textes */
.slide-next-enter-active,
.slide-next-leave-active,
.slide-prev-enter-active,
.slide-prev-leave-active {
    transition: all 0.5s ease-out;
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
</style>
