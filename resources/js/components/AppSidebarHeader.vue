<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';

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
    <header
        class="flex justify-between w-full h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <!-- Dashboard User Profile Navigation -->
        <div class="flex items-center gap-4">
            <Link v-if="$page.props.auth.user" href="/settings/profile" class="flex items-center gap-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 p-1.5 pr-3 rounded-full transition-colors border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                <div class="h-8 w-8 rounded-full bg-raosc-green text-white flex items-center justify-center font-bold overflow-hidden shadow-sm">
                    <!-- Si l'utilisateur as une photo avatar, on l'affiche, d'où le alt par defaut la première lettre du nom -->
                    <span class="text-sm">{{ $page.props.auth.user.name.charAt(0).toUpperCase() }}</span>
                </div>
                <div class="hidden md:block text-sm text-left">
                    <p class="font-semibold text-zinc-900 dark:text-white leading-none">{{ $page.props.auth.user.name }}</p>
                    <p class="text-xs text-zinc-500 mt-1 truncate max-w-[120px]">{{ $page.props.auth.user.email }}</p>
                </div>
            </Link>
        </div>
    </header>
</template>

