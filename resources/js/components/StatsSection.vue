<!-- components/StatsSection.vue - Design minimaliste optimisé -->
<script setup lang="ts">
import { Users, Globe, Heart, ShieldCheck } from 'lucide-vue-next';

interface Stat {
    id: number;
    name: string;
    value: string;
    icon: any;
    color: string;
    bg: string;
}

defineProps<{
    stats: Stat[];
}>();
</script>

<template>
    <div class="bg-white dark:bg-zinc-950 border-y border-zinc-100 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div 
                    v-for="stat in stats" 
                    :key="stat.id" 
                    class="text-center group transition-all duration-300 hover:-translate-y-1"
                >
                    <div :class="['mx-auto flex h-12 w-12 items-center justify-center rounded-xl mb-3 transition-all duration-300 group-hover:scale-110 group-hover:shadow-sm', stat.bg]">
                        <component :is="stat.icon" :class="['h-5 w-5', stat.color]" />
                    </div>
                    <dd class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white mb-0.5 tracking-tight">
                        {{ stat.value }}
                    </dd>
                    <dt class="text-[11px] sm:text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                        {{ stat.name }}
                    </dt>
                </div>
            </div>
        </div>
    </div>
</template>