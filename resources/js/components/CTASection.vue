<!-- components/CTASection.vue -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import { register } from '@/routes';

defineProps<{
    isAuthenticated: boolean;
}>();
</script>

<template>
    <div class="bg-zinc-950 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <!-- Section avec vidéo en arrière-plan -->
            <div class="relative overflow-hidden rounded-2xl text-center shadow-lg">
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

                <!-- Overlay sombre pour améliorer la lisibilité du texte -->
                <div class="absolute inset-0 bg-black/50"></div>

                <!-- Dégradés colorés -->
                <div class="absolute top-0 right-0 w-72 h-72 bg-raosc-green/20 rounded-full blur-3xl z-0"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-raosc-yellow/10 rounded-full blur-3xl z-0"></div>

                <!-- Contenu -->
                <div class="relative z-10 p-12 sm:p-20">
                    <h2 class="text-3xl sm:text-5xl font-bold text-white mb-6 max-w-3xl mx-auto leading-tight">
                        Rejoignez la plus grande coalition d'OSC en <span class="text-raosc-yellow">Afrique</span>
                    </h2>
                    <p class="text-white/70 text-base sm:text-lg max-w-2xl mx-auto mb-10">
                        Inscrivez votre organisation gratuitement et devenez un acteur clé du réseau RAOSC.
                    </p>
                    <div class="flex flex-wrap justify-center gap-5">
                        <Link
                            v-if="!isAuthenticated"
                            :href="register()"
                            class="inline-flex items-center gap-2 bg-white text-zinc-900 px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-white/90 transition-all shadow-md hover:-translate-y-0.5"
                            prefetch
                        >
                            S'inscrire maintenant
                            <ArrowRight class="w-4 h-4" />
                        </Link>
                        <Link href="/contact" class="inline-flex items-center gap-2 text-white font-semibold text-sm bg-white/10 hover:bg-white/20 px-8 py-3.5 rounded-xl transition-all border border-white/20">
                            En savoir plus
                            <ArrowRight class="w-4 h-4" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
