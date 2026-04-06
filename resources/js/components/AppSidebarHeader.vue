<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';
import { Moon, Sun } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

const { appearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    updateAppearance(appearance.value === 'dark' ? 'light' : 'dark');
};

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <!-- Header fixe qui s'adapte à la largeur de la sidebar -->
    <header
        class="fixed top-0 right-0 z-50 flex h-16 items-center justify-between border-b border-sidebar-border/70 bg-white px-6 transition-[left,height] ease-linear backdrop-blur-md dark:bg-zinc-950/70 md:px-4 left-0 md:left-[var(--sidebar-width)] group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 group-has-data-[collapsible=icon]/sidebar-wrapper:md:left-[var(--sidebar-width-icon)]"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div class="flex items-center gap-4">
            <!-- Bouton Toggle Theme -->
            <button
                @click="toggleTheme"
                class="flex h-9 w-9 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 transition-colors hover:bg-zinc-200 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-emerald-400"
                aria-label="Basculer le thème"
                title="Changer de thème"
            >
                <Sun v-if="appearance === 'dark'" class="h-4 w-4" />
                <Moon v-else class="h-4 w-4" />
            </button>

            <!-- Dashboard User Profile Navigation -->
            <Link v-if="$page.props.auth.user" href="/settings/profile" class="flex items-center gap-2 rounded-full border border-transparent p-1.5 pr-3 transition-colors hover:border-zinc-200 hover:bg-zinc-100 dark:hover:border-zinc-700 dark:hover:bg-zinc-800">
                <div class="bg-raosc-green flex h-8 w-8 items-center justify-center overflow-hidden rounded-full font-bold text-white shadow-sm">
                    <span class="text-sm">{{ $page.props.auth.user.name.charAt(0).toUpperCase() }}</span>
                </div>
                <div class="hidden text-left text-sm md:block">
                    <p class="leading-none font-semibold text-zinc-900 dark:text-white">{{ $page.props.auth.user.name }}</p>
                    <p class="mt-1 max-w-[120px] truncate text-xs text-zinc-500">{{ $page.props.auth.user.email }}</p>
                </div>
            </Link>
        </div>
    </header>

    <!-- Espaceur pour éviter que le contenu ne passe sous le header -->
    <div class="h-16 shrink-0 group-has-data-[collapsible=icon]/sidebar-wrapper:h-12"></div>
</template>
