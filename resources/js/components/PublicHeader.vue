<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';
import UserInfo from '@/components/UserInfo.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import { BuildingIcon, ArrowRightIcon } from 'lucide-vue-next';

defineProps<{
    user: any;
    canRegister?: boolean;
}>();
</script>

<template>
<header class="border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <Link href="/" class="-m-1.5 p-1.5 flex items-center gap-3 group" prefetch>
                <div class="flex h-10 w-10 items-center justify-center rounded bg-emerald-600 text-white shadow-lg shadow-emerald-600/20 transition-transform group-hover:scale-110">
                    <BuildingIcon class="h-6 w-6" />
                </div>
                <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                    RAOSC
                </span>
            </Link>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden lg:flex lg:gap-x-10 items-center">
            <Link href="/" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors" prefetch>
                Accueil
            </Link>
            <Link href="/rao" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors" prefetch>
                Organisations
            </Link>
            <Link href="/posts" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors" prefetch>
                Actualités
            </Link>
            <Link href="/about" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors" prefetch>
                À propos
            </Link>
            <Link href="/contact" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors" prefetch>
                Contact
            </Link>
        </div>
        
        <div class="flex flex-1 justify-end items-center gap-3 sm:gap-6">
            <ThemeToggle />
            
            <template v-if="user">
                <Link
                    :href="dashboard()"
                    class="group relative flex items-center gap-3 rounded-full bg-zinc-100 py-1 pl-1 pr-4 transition-all hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 shadow-sm"
                    prefetch
                >
                    <UserInfo :user="user" :show-email="false" class="pointer-events-none" />
                    <div class="hidden sm:flex items-center gap-2 border-l border-zinc-300 dark:border-zinc-600 pl-3">
                        <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Dashboard</span>
                        <ArrowRightIcon class="h-3.5 w-3.5 text-emerald-600 dark:text-emerald-400 transition-transform group-hover:translate-x-0.5" />
                    </div>
                </Link>
            </template>
            <template v-else>
                <Link
                    :href="login()"
                    class="hidden sm:block text-sm font-semibold leading-6 text-zinc-900 hover:text-emerald-600 dark:text-zinc-100 dark:hover:text-emerald-400 transition-colors"
                    prefetch
                >
                    Connexion
                </Link>
                <Link
                    v-if="canRegister"
                    :href="register()"
                    class="rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 transition-all hover:-translate-y-0.5"
                    prefetch
                >
                    S'inscrire
                </Link>
            </template>
        </div>
    </nav>
</header>
</template>
