<!-- components/StatsSection.vue -->
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
    <div class="bg-white dark:bg-zinc-950 border-b border-zinc-100 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-3 py-8 sm:py-12">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <div v-for="stat in stats" :key="stat.id" class="text-center group">
                    <div :class="['mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4 transition-transform group-hover:scale-105', stat.bg]">
                        <component :is="stat.icon" :class="['h-6 w-6', stat.color]" />
                    </div>
                    <dd class="text-3xl font-extrabold text-zinc-900 dark:text-white mb-1">{{ stat.value }}</dd>
                    <dt class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ stat.name }}</dt>
                </div>
            </div>
        </div>
    </div>
</template>
