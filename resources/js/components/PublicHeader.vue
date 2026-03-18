<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Menu, X, Search } from 'lucide-vue-next';
import { ref } from 'vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import UserInfo from '@/components/UserInfo.vue';
import { dashboard, login, register } from '@/routes';

const searchQuery = ref('');
const isSearchOpen = ref(false);

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        router.get('/rao', { search: searchQuery.value });
        isSearchOpen.value = false;
    }
};

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
<header class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl border-b border-zinc-100 dark:border-zinc-800 transition-all">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8" aria-label="Global">
        <!-- Logo -->
        <div class="flex lg:flex-1">
            <Link href="/" class="flex items-center gap-3 group" prefetch>
                <img src="/images/Logo_Raosc-removebg-preview.png" alt="RAOSC Logo" class="h-10 w-auto" />
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight text-zinc-900 dark:text-white leading-none">
                        RAOSC
                    </span>
                    <span class="text-[9px] font-bold text-[#008751] tracking-[0.1em] mt-0.5">
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
                class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-[#008751] transition-colors tracking-tight" 
                prefetch
            >
                {{ link.name }}
            </Link>
            
            <div class="h-4 w-px bg-zinc-200 dark:bg-zinc-800"></div>

            <!-- Search Field -->
            <div class="relative flex items-center">
                <button @click="isSearchOpen = !isSearchOpen" class="p-2 text-zinc-500 hover:text-[#008751] transition-colors">
                    <Search class="h-4 w-4" />
                </button>
                <transition name="expand">
                    <input 
                        v-if="isSearchOpen"
                        v-model="searchQuery"
                        @keyup.enter="handleSearch"
                        type="text" 
                        placeholder="Rechercher une OSC..." 
                        class="absolute right-10 w-48 bg-zinc-100 dark:bg-zinc-900 border-none rounded-full px-4 py-1.5 text-xs focus:ring-1 focus:ring-[#008751] transition-all"
                        autoFocus
                    />
                </transition>
            </div>
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
                <Link :href="login()" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" prefetch>
                    Connexion
                </Link>
                <Link
                    v-if="canRegister"
                    :href="register()"
                    class="rounded-xl bg-[#008751] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#008751]/10 hover:bg-[#006b40] hover:-translate-y-0.5 transition-all"
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
                class="text-base font-medium text-zinc-900 dark:text-white tracking-tight"
                @click="isMenuOpen = false"
            >
                {{ link.name }}
            </Link>
            <hr class="border-zinc-100 dark:border-zinc-800"/>
            <template v-if="user">
                <Link :href="dashboard()" class="text-base font-bold text-[#008751]">Tableau de bord</Link>
            </template>
            <template v-else>
                <Link :href="login()" class="text-base font-medium text-zinc-600 dark:text-zinc-400">Connexion</Link>
                <Link :href="register()" class="text-base font-bold text-[#008751]">S'inscrire</Link>
            </template>
        </div>
    </div>
</header>
</template>

<style scoped>
.expand-enter-active, .expand-leave-active {
    transition: all 0.3s ease-out;
}
.expand-enter-from, .expand-leave-to {
    opacity: 0;
    width: 0;
    transform: translateX(20px);
}
</style>
