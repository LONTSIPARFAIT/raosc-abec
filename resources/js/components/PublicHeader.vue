<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BuildingIcon, ArrowRightIcon } from 'lucide-vue-next';
import ThemeToggle from '@/components/ThemeToggle.vue';
import UserInfo from '@/components/UserInfo.vue';
import { dashboard, login, register } from '@/routes';

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
                <div class="flex h-12 w-12 items-center justify-center transition-transform group-hover:scale-105">
                    <img src="/images/Logo_Raosc-removebg-preview.png" alt="RAOSC Logo" class="h-12 w-auto" />
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-black tracking-tighter text-zinc-900 dark:text-white leading-none">
                        RAOSC
                    </span>
                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 tracking-widest uppercase leading-none mt-1">
                        ONG ABEC
                    </span>
                </div>
            </Link>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden lg:flex lg:gap-x-10 items-center">
            <Link href="/" class="text-sm font-bold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors uppercase tracking-wider" prefetch>
                Accueil
            </Link>
            <Link href="/rao" class="text-sm font-bold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors uppercase tracking-wider" prefetch>
                Associations
            </Link>
            <Link href="/posts" class="text-sm font-bold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors uppercase tracking-wider" prefetch>
                Actualités
            </Link>
            <Link href="/about" class="text-sm font-bold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors uppercase tracking-wider" prefetch>
                À Propos
            </Link>
            <Link href="/contact" class="text-sm font-bold leading-6 text-zinc-900 dark:text-zinc-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors uppercase tracking-wider" prefetch>
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
                    class="rounded-full bg-[#008751] px-6 py-3 text-sm font-black text-white shadow-xl shadow-[#008751]/20 hover:bg-[#006b40] transition-all hover:-translate-y-0.5 uppercase tracking-widest"
                    prefetch
                >
                    S'inscrire
                </Link>
            </template>
        </div>
    </nav>
</header>
</template>
