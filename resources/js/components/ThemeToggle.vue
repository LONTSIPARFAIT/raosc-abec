<script setup lang="ts">
import { computed } from 'vue';
import { Moon, Sun } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

const { appearance, updateAppearance } = useAppearance();

// On se base sur "light" et "dark". S'il est sur system on garde une icone appropriée
const toggleTheme = () => {
    updateAppearance(appearance.value === 'dark' ? 'light' : 'dark');
};
</script>

<template>
    <button
        @click="toggleTheme"
        class="flex h-9 w-9 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:bg-zinc-200 hover:text-emerald-600 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-emerald-400 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/50"
        aria-label="Basculer le thème"
        title="Changer de thème"
    >
        <Sun v-if="appearance === 'dark'" class="h-4 w-4" />
        <Moon v-else class="h-4 w-4" />
    </button>
</template>
