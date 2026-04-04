<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';
import { ArrowRight } from 'lucide-vue-next';

const page = usePage();
// const name = page.props.name;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="relative min-h-screen flex flex-col lg:grid lg:grid-cols-2 lg:items-center lg:justify-center lg:gap-12 bg-white dark:bg-zinc-950"
    >
        <!-- Left Panel - Brand Side -->
        <div
            class="relative hidden lg:flex h-full min-h-screen flex-col justify-between bg-gradient-to-br from-raosc-green to-raosc-green/80 dark:from-raosc-green/90 dark:to-raosc-green/70 p-12 text-white"
        >
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>
            </div>
            
            <!-- Header Logo -->
            <div class="relative z-10">
                <Link
                    :href="home()"
                    class="flex items-center gap-3 text-xl font-bold group"
                >
                    <div class="bg-white/10 p-2 rounded-xl backdrop-blur-sm group-hover:bg-white/20 transition-all duration-300">
                        <AppLogoIcon class="size-12 fill-current text-white" />
                    </div>
                    <span class="tracking-tight">RAOSC</span>
                </Link>
            </div>

            <!-- Center Content -->
            <div class="relative z-10 max-w-md mx-auto text-center lg:text-left">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Plateforme collaborative
                    </div>
                    
                    <h2 class="text-4xl lg:text-5xl font-bold leading-tight">
                        Bienvenue dans le réseau
                    </h2>
                    
                    <p class="text-white/80 text-lg leading-relaxed">
                        Connectez-vous pour accéder à votre espace personnel et découvrir toutes les fonctionnalités de la plateforme.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                            <span>Accès sécurisé</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                            <span>Support 24/7</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                            <span>Communauté active</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-sm text-white/60">
                <p>© {{ new Date().getFullYear() }} RAOSC. Tous droits réservés.</p>
            </div>
        </div>

        <!-- Right Panel - Form Side -->
        <div class="flex items-center justify-center min-h-screen lg:min-h-0 py-12 px-6 sm:px-8">
            <div class="w-full max-w-md mx-auto space-y-8">
                <!-- Mobile Logo (visible only on mobile) -->
                <div class="lg:hidden flex justify-center mb-8">
                    <Link
                        :href="home()"
                        class="flex items-center gap-2 text-lg font-bold text-raosc-green"
                    >
                        <AppLogoIcon class="size-12 fill-current" />
                        <span>RAOSC</span>
                    </Link>
                </div>

                <!-- Form Container -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm p-6 sm:p-8">
                    <!-- Header -->
                    <div class="text-center space-y-2 mb-6">
                        <div v-if="title" class="inline-flex items-center justify-center gap-2 bg-raosc-green/10 text-raosc-green px-3 py-1 rounded-full text-xs font-semibold mb-3">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-raosc-green opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-raosc-green"></span>
                            </span>
                            Authentification
                        </div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white tracking-tight" v-if="title">
                            {{ title }}
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400" v-if="description">
                            {{ description }}
                        </p>
                    </div>

                    <!-- Slot for Form Content -->
                    <slot />

                    <!-- Additional Links Slot (optional) -->
                    <slot name="footer" />
                </div>

                <!-- Help Text -->
                <p class="text-center text-xs text-zinc-400 dark:text-zinc-500">
                    En vous connectant, vous acceptez nos 
                    <Link href="/terms" class="text-raosc-green hover:text-raosc-green/80 transition-colors">conditions d'utilisation</Link> 
                    et notre 
                    <Link href="/privacy" class="text-raosc-green hover:text-raosc-green/80 transition-colors">politique de confidentialité</Link>.
                </p>
            </div>
        </div>
    </div>
</template>