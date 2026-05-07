<!-- components/CTASection.vue - Version mobile optimisée -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Sparkles, Users, Globe2 } from 'lucide-vue-next';
import { register } from '@/routes';

defineProps<{
    isAuthenticated: boolean;
}>();
</script>

<template>
    <div class="bg-zinc-50 dark:bg-zinc-950 py-12 sm:py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section avec vidéo en arrière-plan -->
            <div class="relative overflow-hidden rounded-xl sm:rounded-2xl text-center shadow-lg">
                <!-- Vidéo d'arrière-plan -->
                <video
                    autoplay
                    muted
                    loop
                    playsinline
                    class="absolute inset-0 w-full h-full object-cover"
                >
                    <source src="/img/video.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>

                <!-- Overlay sombre plus fort sur mobile pour lisibilité -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/50 to-black/40"></div>

                <!-- Dégradés colorés (réduits sur mobile) -->
                <div class="absolute top-0 right-0 w-40 h-40 sm:w-72 sm:h-72 bg-raosc-green/20 rounded-full blur-2xl sm:blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 sm:w-72 sm:h-72 bg-raosc-yellow/10 rounded-full blur-2xl sm:blur-3xl"></div>

                <!-- Contenu -->
                <div class="relative z-10 p-6 sm:p-10 md:p-12 lg:p-20">
                    
                    <!-- Petit icône décoratif (visible sur mobile) -->
                    <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-4 sm:mb-6 mx-auto">
                        <Sparkles class="w-6 h-6 sm:w-7 sm:h-7 text-raosc-yellow" />
                    </div>

                    <!-- Titre (plus petit sur mobile) -->
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 sm:mb-4 max-w-3xl mx-auto leading-tight">
                        Rejoignez la plus grande coalition d'OSC en 
                        <span class="text-raosc-yellow">Afrique</span>
                    </h2>
                    
                    <!-- Description (plus courte et compacte sur mobile) -->
                    <p class="text-white/80 text-sm sm:text-base md:text-lg max-w-2xl mx-auto mb-6 sm:mb-8 leading-relaxed">
                        Inscrivez gratuitement votre organisation et devenez un acteur clé du réseau panafricain RAOSC.
                    </p>

                    <!-- Boutons (full-width sur mobile, inline sur desktop) -->
                    <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                        <Link
                            v-if="!isAuthenticated"
                            :href="register()"
                            class="group inline-flex items-center justify-center gap-2 bg-white text-zinc-900 px-6 sm:px-8 py-3 rounded-xl font-bold text-sm transition-all shadow-md hover:-translate-y-0.5 hover:shadow-lg"
                            prefetch
                        >
                            S'inscrire maintenant
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </Link>
                        <Link 
                            href="/contact" 
                            class="group inline-flex items-center justify-center gap-2 text-white font-semibold text-sm bg-white/10 hover:bg-white/20 px-6 sm:px-8 py-3 rounded-xl transition-all border border-white/20"
                        >
                            En savoir plus
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </Link>
                    </div>

                    <!-- Petit texte informatif -->
                    <p class="text-white/40 text-[10px] sm:text-xs mt-6">
                        ✨ Rejoignez gratuitement • Validation sous 48h
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Animation subtile au hover des boutons */
.group:hover .group-hover\:translate-x-1 {
    transform: translateX(4px);
}

.group:hover .group-hover\:-translate-y-0\.5 {
    transform: translateY(-2px);
}

/* Transition douce */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>