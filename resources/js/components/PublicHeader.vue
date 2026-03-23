<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { Menu, X, Search } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import UserInfo from '@/components/UserInfo.vue';
import NotificationBell from '@/components/NotificationBell.vue';
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
const page = usePage();
const currentUrl = computed(() => page.url);

const navLinks = [
    { name: 'Accueil', href: '/' },
    { name: 'Associations', href: '/rao' },
    { name: 'Actualités', href: '/posts' },
    { name: 'Communauté', href: '/community' },
    { name: 'À Propos', href: '/about' },
    { name: 'Contact', href: '/contact' },
];

// Helper to check if a link is active
const isActive = (href: string) => {
    if (href === '/') {
        return currentUrl.value === '/';
    }
    return currentUrl.value.startsWith(href);
};
</script>

<template>
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl border-b border-zinc-100 dark:border-zinc-800 transition-all">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8" aria-label="Global">
            <!-- Logo -->
            <div class="flex lg:flex-1">
                <Link href="/" class="flex items-center gap-3 group" prefetch>
                    <div class="flex aspect-square h-14 w-14 items-center justify-center rounded-lg bg-transparent">
                        <img 
                            src="/images/Logo_Raosc-removebg-preview.png" 
                            alt="RAOSC Logo" 
                            class="h-full w-full object-contain"
                        />
                    </div>
                    <div class="grid flex-1 text-left text-sm">
                        <span class="truncate leading-tight font-bold text-lg tracking-tight text-zinc-900 dark:text-white">
                            RAOSC
                        </span>
                        <span class="truncate leading-none text-[10px] text-zinc-500 font-medium">
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

            <!-- Desktop Links -->
            <div class="hidden lg:flex lg:gap-x-8 items-center">
                <Link 
                    v-for="link in navLinks" 
                    :key="link.name" 
                    :href="link.href" 
                    class="relative text-sm font-medium transition-all duration-200 tracking-tight py-1"
                    :class="[
                        isActive(link.href)
                            ? 'text-raosc-green dark:text-raosc-green font-semibold'
                            : 'text-zinc-600 dark:text-zinc-400 hover:text-raosc-green'
                    ]"
                    prefetch
                >
                    {{ link.name }}
                    <!-- Active indicator underline -->
                    <span 
                        v-if="isActive(link.href)"
                        class="absolute -bottom-1 left-0 right-0 h-0.5 bg-raosc-green rounded-full"
                    ></span>
                </Link>
                
                <div class="h-4 w-px bg-zinc-200 dark:bg-zinc-800"></div>

                <!-- Search Field -->
                <div class="relative flex items-center">
                    <button @click="isSearchOpen = !isSearchOpen" class="p-2 text-zinc-500 hover:text-raosc-green transition-colors">
                        <Search class="h-4 w-4" />
                    </button>
                    <transition name="expand">
                        <input 
                            v-if="isSearchOpen"
                            v-model="searchQuery"
                            @keyup.enter="handleSearch"
                            type="text" 
                            placeholder="Rechercher une OSC..." 
                            class="absolute right-10 w-48 bg-zinc-100 dark:bg-zinc-900 border-none rounded-full px-4 py-1.5 text-xs focus:ring-1 focus:ring-raosc-green transition-all"
                            autofocus
                        />
                    </transition>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="hidden lg:flex lg:flex-1 justify-end items-center gap-6">
                <ThemeToggle />
                
                <template v-if="user">
                    <NotificationBell />
                    <Link
                        :href="dashboard()"
                        class="flex items-center gap-2 text-sm font-semibold transition-colors"
                        :class="isActive(dashboard()) ? 'text-raosc-green' : 'text-zinc-900 dark:text-white hover:text-raosc-green'"
                        prefetch
                    >
                    <span>Dashboard</span>
                    <span class="bg-zinc-100 dark:bg-zinc-800 p-1.5 rounded-full">
                        <UserInfo :user="user" :show-email="false" :compact="true" class="h-6 w-6" />
                    </span>
                    </Link>
                </template>
                <template v-else>
                    <Link 
                        :href="login()" 
                        class="text-sm font-medium transition-colors"
                        :class="isActive(login()) ? 'text-raosc-green' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'"
                        prefetch
                    >
                        Connexion
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="rounded-full bg-raosc-green px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-raosc-green/90 transition-all"
                        :class="isActive(register()) ? 'ring-2 ring-raosc-green ring-offset-2 ring-offset-white dark:ring-offset-zinc-950' : ''"
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
                    class="text-base font-medium transition-colors py-2"
                    :class="isActive(link.href) ? 'text-raosc-green' : 'text-zinc-900 dark:text-white'"
                    @click="isMenuOpen = false"
                >
                    {{ link.name }}
                </Link>
                <hr class="border-zinc-100 dark:border-zinc-800"/>
                <template v-if="user">
                    <Link :href="dashboard()" class="text-base font-bold transition-colors" :class="isActive(dashboard()) ? 'text-raosc-green' : 'text-raosc-green'" @click="isMenuOpen = false">
                        Tableau de bord
                    </Link>
                </template>
                <template v-else>
                    <Link :href="login()" class="text-base font-medium transition-colors" :class="isActive(login()) ? 'text-raosc-green' : 'text-zinc-600 dark:text-zinc-400'" @click="isMenuOpen = false">
                        Connexion
                    </Link>
                    <Link :href="register()" class="text-base font-bold transition-colors" :class="isActive(register()) ? 'text-raosc-green' : 'text-raosc-green'" @click="isMenuOpen = false">
                        S'inscrire
                    </Link>
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