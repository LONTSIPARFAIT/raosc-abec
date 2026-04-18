<!-- components/FeaturesSection.vue - Design minimaliste optimisé -->
<script setup lang="ts">
import { Zap, MessageSquare, Trophy } from 'lucide-vue-next';

interface Feature {
    name: string;
    description: string;
    icon: any;
    color: string;
    bg: string;
}

defineProps<{
    features: Feature[];
}>();
</script>

<template>
    <div class="py-12 sm:py-16 bg-white dark:bg-zinc-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- En-tête minimaliste -->
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-raosc-green text-[10px] font-bold tracking-[0.2em] uppercase bg-raosc-green/10 px-3 py-1.5 rounded-full mb-3 inline-block">
                    Pourquoi nous rejoindre ?
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white tracking-tight mb-3">
                    Des outils pour <span class="text-raosc-green">transformer</span> votre engagement
                </h2>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Un écosystème complet pour aider les associations africaines à gagner en crédibilité et efficacité.
                </p>
            </div>

            <!-- Grille des fonctionnalités -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div 
                    v-for="feature in features" 
                    :key="feature.name"
                    class="group bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1"
                >
                    <div :class="['w-10 h-10 rounded-xl flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110', feature.bg]">
                        <component :is="feature.icon" :class="['w-5 h-5', feature.color]" />
                    </div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-2">{{ feature.name }}</h3>
                    <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ feature.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>