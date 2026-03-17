<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Menu, X, ArrowRight } from 'lucide-vue-next';
import { ref } from 'vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import UserInfo from '@/components/UserInfo.vue';
import { dashboard, login, register } from '@/routes';

defineProps<{
    user: any;
    canRegister?: boolean;
}>();

const isMenuOpen = ref(false);

const navLinks = [
    { name: 'Accueil', href: '/' },
    { name: 'Associations', href: '/rao' },
    { name: 'Actualités', href: '/posts' },
    { name: 'Communauté', href: '/community' },
    { name: 'À Propos', href: '/about' },
    { name: 'Contact', href: '/contact' },
];
</script>

<template>
<!-- Fixed Header -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md border-b border-zinc-100 dark:border-zinc-800">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8" aria-label="Global">
        <!-- Logo -->
        <div class="flex lg:flex-1">
            <Link href="/" class="flex items-center gap-3 group" prefetch>
                <img src="/images/Logo_Raosc-removebg-preview.png" alt="RAOSC Logo" class="h-10 w-auto" />
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white leading-none">
                        RAOSC
                    </span>
                    <span class="text-[9px] font-bold text-[#008751] tracking-widest uppercase mt-0.5">
                        ONG ABEC
                    </span>
                </div>
            </Link>
        </div>

        <!-- Mobile Toggle -->
        <div class="flex lg:hidden items-center gap-4">
            <ThemeToggle />
            <button @click="isMenuOpen = !isMenuOpen" class="p-2 text-zinc-500">
                <Menu v-if="!isMenuOpen" class="h-6 w-6" />
                <X v-else class="h-6 w-6" />
            </button>
        </div>

        <!-- Desktop Links - Well categorized -->
        <div class="hidden lg:flex lg:gap-x-8 items-center">
            <Link 
                v-for="link in navLinks" 
                :key="link.name" 
                :href="link.href" 
                class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:text-[#008751] transition-colors uppercase tracking-wider" 
                prefetch
            >
                {{ link.name }}
            </Link>
        </div>
        
        <!-- Actions -->
        <div class="hidden lg:flex lg:flex-1 justify-end items-center gap-6">
            <ThemeToggle />
            
            <template v-if="user">
                <Link
                    :href="dashboard()"
                    class="flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white hover:text-[#008751] transition-colors"
                    prefetch
                >
                    <span class="bg-zinc-100 dark:bg-zinc-800 p-1.5 rounded-full">
                        <UserInfo :user="user" :show-email="false" class="h-6 w-6" />
                    </span>
                    <span>Mon Espace</span>
                </Link>
            </template>
            <template v-else>
                <Link :href="login()" class="text-xs font-bold text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white uppercase tracking-widest" prefetch>
                    Connexion
                </Link>
                <Link
                    v-if="canRegister"
                    :href="register()"
                    class="rounded-lg bg-[#008751] px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-[#006b40] transition-all"
                    prefetch
                >
                    S'inscrire
                </Link>
            </template>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div v-if="isMenuOpen" class="lg:hidden bg-white dark:bg-zinc-950 px-6 py-8 border-t border-zinc-100 dark:border-zinc-800 space-y-6">
        <div class="flex flex-col gap-4">
            <Link 
                v-for="link in navLinks" 
                :key="link.name" 
                :href="link.href" 
                class="text-sm font-bold text-zinc-900 dark:text-white uppercase tracking-widest"
                @click="isMenuOpen = false"
            >
                {{ link.name }}
            </Link>
            <hr class="border-zinc-100 dark:border-zinc-800"/>
            <template v-if="user">
                <Link :href="dashboard()" class="text-sm font-bold text-[#008751] uppercase tracking-widest">Tableau de bord</Link>
            </template>
            <template v-else>
                <Link :href="login()" class="text-sm font-bold text-zinc-600 dark:text-zinc-400 uppercase tracking-widest">Connexion</Link>
                <Link :href="register()" class="text-sm font-bold text-[#008751] uppercase tracking-widest">S'inscrire</Link>
            </template>
        </div>
    </div>
</header>
</template>
