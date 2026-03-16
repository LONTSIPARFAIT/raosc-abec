<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { register } from '@/routes';
import { ArrowRightIcon } from 'lucide-vue-next';

const props = defineProps<{
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
            <div class="mb-8 flex animate-in fade-in slide-in-from-left-4 duration-1000">
                <div class="rounded-full bg-emerald-600/20 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-emerald-400 border border-emerald-500/30 backdrop-blur-md shadow-2xl">
                    Une initiative de l'ONG ABEC
                </div>
            </div>
            
            <div class="relative min-h-[18rem] sm:min-h-[16rem]">
                <transition-group name="slide-up">
                    <div 
                        v-for="(slide, index) in slides" 
                        :key="'text-'+index" 
                        v-show="currentIndex === index" 
                        class="absolute inset-0"
                    >
                        <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl leading-[1.1]">
                            <span class="block drop-shadow-2xl">{{ slide.title.split(' ').slice(0, -2).join(' ') }}</span>
                            <span class="block bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-blue-400 pb-2">
                                {{ slide.title.split(' ').slice(-2).join(' ') }}
                            </span>
                        </h1>
                        <p class="mt-8 text-xl leading-relaxed text-zinc-300 max-w-2xl drop-shadow-lg font-medium">
                            {{ slide.description }}
                        </p>
                    </div>
                </transition-group>
            </div>
            
            <div class="mt-12 flex flex-wrap items-center gap-6 relative z-30">
                <Link
                    href="/rao"
                    class="rounded-full bg-emerald-600 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-emerald-600/30 hover:bg-emerald-500 transition-all hover:-translate-y-1 active:scale-95"
                    prefetch
                >
                    Parcourir les organisations
                </Link>
                <Link
                    v-if="!user"
                    :href="register()"
                    class="group flex items-center gap-2 text-sm font-bold text-white hover:text-emerald-400 transition-all drop-shadow-md"
                    prefetch
                >
                    Rejoindre le mouvement 
                    <ArrowRightIcon class="h-4 w-4 transition-transform group-hover:translate-x-1" />
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
