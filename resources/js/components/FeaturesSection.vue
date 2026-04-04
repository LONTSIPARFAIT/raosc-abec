<!-- components/FeaturesSection.vue -->
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
    <div class="py-12 sm:py-20 bg-zinc-50/50 dark:bg-zinc-900/20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-raosc-green text-xs font-semibold tracking-[0.2em] uppercase bg-raosc-green/10 px-4 py-1.5 rounded-full mb-4 inline-block">
                    Pourquoi rejoindre le réseau ?
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-6">
                    Des outils pour transformer votre <span class="text-raosc-yellow">engagement</span>
                </h2>
                <p class="text-zinc-600 dark:text-zinc-400 text-base sm:text-lg leading-relaxed">
                    Le RAOSC offre un écosystème complet pour aider les associations africaines à gagner en crédibilité et en efficacité.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div v-for="feature in features" :key="feature.name"
                     class="group bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-raosc-green/20 transition-all duration-200">
                    <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-6 group-hover:scale-105 transition-transform', feature.bg]">
                        <component :is="feature.icon" :class="['w-6 h-6', feature.color]" />
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">{{ feature.name }}</h3>
                    <p class="text-sm text-zinc-500 leading-relaxed">{{ feature.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
