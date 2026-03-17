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

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

const prevSlide = () => {
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
    <!-- Image Slider Backgrounds -->
    <div class="absolute inset-0 w-full h-full">
        <transition-group name="fade" tag="div" class="relative items-center justify-center flex h-full">
            <div 
                v-for="(slide, index) in slides" 
                :key="'img-'+index" 
                v-show="currentIndex === index" 
                class="absolute inset-0 w-full h-full"
            >
                <img :src="slide.image" alt="Background slide" class="w-full h-full object-cover opacity-40 transition-transform duration-[7000ms] scale-105" :style="{ transform: currentIndex === index ? 'scale(1)' : 'scale(1.05)' }" />
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
            </div>
        </transition-group>
    </div>

    <!-- Content -->
    <div class="absolute inset-0 z-10 flex h-full flex-col justify-center px-6 lg:px-12 max-w-7xl mx-auto">
        <div class="max-w-3xl">
            <transition-group name="slide-fade">
                <div 
                    v-for="(slide, index) in slides" 
                    :key="'text-'+index" 
                    v-show="currentIndex === index" 
                    class="space-y-6"
                >
                    <span class="inline-block text-[#FFCB05] font-bold uppercase tracking-[0.3em] text-[10px] sm:text-xs">Initiative ONG ABEC</span>
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight">
                        {{ slide.title }}
                    </h1>
                    <p class="text-zinc-300 text-sm sm:text-xl font-medium max-w-2xl leading-relaxed italic border-l-2 border-[#008751] pl-6">
                        {{ slide.description }}
                    </p>
                </div>
            </transition-group>
            
            <div class="mt-10 sm:mt-12 flex flex-wrap gap-4 items-center">
                <Link
                    href="/rao"
                    class="rounded-full bg-[#008751] px-8 py-3.5 text-xs font-bold text-white shadow-lg shadow-[#008751]/20 hover:bg-[#006b40] transition-all hover:-translate-y-0.5"
                    prefetch
                >
                    Explorer l'annuaire
                </Link>
                <Link
                    v-if="!user"
                    :href="register()"
                    class="flex items-center gap-2 text-white text-xs font-bold hover:text-[#FFCB05] transition-colors group"
                    prefetch
                >
                    Nous Rejoindre
                    <ArrowRightIcon class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </Link>
            </div>
        </div>
    </div>
    
    <!-- Controls -->
    <div class="absolute bottom-10 inset-x-0 z-20 flex justify-between px-6 lg:px-12 items-center max-w-7xl mx-auto">
        <div class="flex gap-4">
            <button @click="prevSlide" class="h-10 w-10 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-black transition-all">
                <ChevronLeft class="h-5 w-5" />
            </button>
            <button @click="nextSlide" class="h-10 w-10 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-black transition-all">
                <ChevronRight class="h-5 w-5" />
            </button>
        </div>
        
        <div class="flex gap-2">
            <button 
                v-for="(_, index) in slides" 
                :key="'dot-'+index"
                @click="currentIndex = index"
                class="transition-all duration-300 h-1 rounded-full bg-white"
                :class="currentIndex === index ? 'w-8 opacity-100' : 'w-2 opacity-30'"
            ></button>
        </div>
    </div>
</div>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1.5s ease-in-out;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all 0.8s ease-out;
  transition-delay: 0.4s;
}
.slide-fade-leave-active {
  transition: all 0.4s ease-in;
}
.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>
