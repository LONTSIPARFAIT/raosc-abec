<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRightIcon } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';

import { register } from '@/routes';

defineProps<{
    user: any;
}>();

const slides = [
    {
        image: 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=2070&auto=format&fit=crop',
        title: 'Réseau des Associations et ONG de la Société Civile',
        description: 'Unir la force des acteurs engagés pour bâtir un avenir meilleur. Découvrez notre plateforme collaborative pour gérer vos actions de terrain.',
    },
    {
        image: 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=2070&auto=format&fit=crop',
        title: 'La Jeunesse & L\'Environnement au Coeur de nos Actions',
        description: 'L\'ABEC lutte pour le développement durable, les droits de l\'homme et la santé des populations les plus vulnérables à travers le réseau RAOSC.',
    },
    {
        image: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2113&auto=format&fit=crop',
        title: 'Le Bien-être des Communautés est Notre Priorité',
        description: 'Rejoignez-nous pour promouvoir la paix, l\'égalité et l\'équité. Créez le profil de votre ONG, participez aux discussions et partagez vos actions.',
    }
];

const currentIndex = ref(0);
let timer: any = null;

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

onMounted(() => {
    timer = setInterval(nextSlide, 6000); // 6 sec per slide for better reading time
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
<div class="relative w-full h-[600px] sm:h-[700px] overflow-hidden bg-zinc-950">
    <!-- Image Slider Backgrounds -->
    <transition-group name="fade" tag="div" class="absolute inset-0 w-full h-full">
        <div 
            v-for="(slide, index) in slides" 
            :key="'img-'+index" 
            v-show="currentIndex === index" 
            class="absolute inset-0 w-full h-full"
        >
            <img :src="slide.image" alt="Background slide" class="w-full h-full object-cover opacity-50 dark:opacity-40" />
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-900/40 to-black/20"></div>
        </div>
    </transition-group>

    <!-- Text Slider Content -->
    <div class="absolute inset-0 z-10 flex h-full flex-col justify-center px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="max-w-3xl relative">
            <div class="mb-10 flex animate-in fade-in slide-in-from-left-4 duration-1000">
                <div class="flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 border border-white/20 backdrop-blur-xl shadow-2xl">
                    <img src="/images/Logo_Raosc-removebg-preview.png" alt="Logo" class="h-6 w-auto" />
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-white">Une initiative de l'ONG ABEC</span>
                </div>
            </div>
            
            <div class="relative min-h-[22rem] sm:min-h-[18rem]">
                <transition-group name="slide-up">
                    <div 
                        v-for="(slide, index) in slides" 
                        :key="'text-'+index" 
                        v-show="currentIndex === index" 
                        class="absolute inset-0"
                    >
                        <h1 class="text-5xl font-black tracking-tighter text-white sm:text-8xl leading-[0.9] uppercase italic">
                            <span class="block drop-shadow-2xl">{{ slide.title.split(' ').slice(0, -2).join(' ') }}</span>
                            <span class="block bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 via-yellow-400 to-red-400 pb-4">
                                {{ slide.title.split(' ').slice(-2).join(' ') }}
                            </span>
                        </h1>
                        <p class="mt-8 text-xl leading-relaxed text-zinc-100 max-w-2xl drop-shadow-lg font-bold border-l-4 border-emerald-500 pl-6 bg-black/20 p-4 rounded-r-2xl backdrop-blur-sm">
                            {{ slide.description }}
                        </p>
                    </div>
                </transition-group>
            </div>
            
            <div class="mt-16 flex flex-wrap items-center gap-8 relative z-30">
                <Link
                    href="/rao"
                    class="rounded-full bg-[#008751] px-10 py-5 text-sm font-black text-white shadow-2xl shadow-emerald-950/50 hover:bg-[#006b40] transition-all hover:-translate-y-1 active:scale-95 uppercase tracking-widest"
                    prefetch
                >
                    Explorer l'annuaire
                </Link>
                <Link
                    v-if="!user"
                    :href="register()"
                    class="group flex items-center gap-3 text-sm font-black text-white hover:text-yellow-400 transition-all drop-shadow-md uppercase tracking-widest"
                    prefetch
                >
                    Nous Rejoindre
                    <div class="h-10 w-10 flex items-center justify-center rounded-full bg-white/10 group-hover:bg-yellow-400 group-hover:text-black transition-all">
                        <ArrowRightIcon class="h-5 w-5 transition-transform group-hover:translate-x-1" />
                    </div>
                </Link>
            </div>
        </div>
    </div>
    
    <!-- Dots Navigation -->
    <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 flex space-x-4 z-30 bg-black/20 backdrop-blur-md px-4 py-2 rounded-full border border-white/10">
        <button 
            v-for="(_, index) in slides" 
            :key="'dot-'+index"
            @click="currentIndex = index"
            class="group relative h-1.5 transition-all duration-300 ease-in-out cursor-pointer overflow-hidden rounded-full"
            :class="currentIndex === index ? 'w-8 bg-emerald-500' : 'w-4 bg-white/30 hover:bg-white/50'"
            aria-label="Changer de diapositive"
        >
            <span v-if="currentIndex === index" class="absolute inset-0 bg-white/30 animate-progress"></span>
        </button>
    </div>
</div>
</template>

<style scoped>
/* Image Fade Effect */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1.2s ease-in-out;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Text Slide-Up Effect */
.slide-up-enter-active {
  transition: all 0.8s ease-out;
  transition-delay: 0.3s; /* Delay text entry slightly after image fade starts */
}
.slide-up-leave-active {
  transition: all 0.4s ease-in;
}
.slide-up-enter-from {
  opacity: 0;
  transform: translateY(30px);
}
.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

@keyframes progress {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(0); }
}

.animate-progress {
  animation: progress 6s linear forwards;
}
</style>
