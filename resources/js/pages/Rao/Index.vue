<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Filter, Search, Globe, Map, Building2, X, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import OrganizationCard from '@/components/OrganizationCard.vue';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { index as raoIndex } from '@/actions/App/Http/Controllers/RaoController';

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Organization {
    id: number;
    name: string;
    slug: string;
}

interface OrganizationsPagination {
    data: Organization[];
    total: number;
    last_page: number;
    links: { url: string | null; label: string; active: boolean }[];
}

const {
    organizations,
    categories = [],
    filters = {},
    isPublic = false
} = defineProps<{
    organizations: OrganizationsPagination;
    categories?: Category[];
    filters?: Record<string, string>;
    isPublic?: boolean;
}>();

const searchQuery = ref(filters.search || '');
const selectedCategory = ref(filters.category || '');
const selectedCity = ref(filters.city || '');
const selectedCountry = ref(filters.country || '');
const isLoading = ref(false);

const hasActiveFilters = () => {
    return searchQuery.value || selectedCategory.value || selectedCity.value || selectedCountry.value;
};

const handleSearch = () => {
    isLoading.value = true;
    router.get(raoIndex().url, {
        search: searchQuery.value,
        category: selectedCategory.value,
        city: selectedCity.value,
        country: selectedCountry.value
    }, { 
        preserveState: true, 
        preserveScroll: true,
        replace: true,
        only: ['organizations', 'filters'],
        onFinish: () => { isLoading.value = false; }
    });
};

const resetFilters = () => {
    searchQuery.value = '';
    selectedCategory.value = '';
    selectedCity.value = '';
    selectedCountry.value = '';
    handleSearch();
};

let timeout: ReturnType<typeof setTimeout> | null = null;
watch([searchQuery, selectedCategory, selectedCity, selectedCountry], () => {
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(() => {
        handleSearch();
    }, 400);
});

// Format pagination label
const formatLabel = (label: string) => {
    return label
        .replace('&laquo;', '«')
        .replace('&raquo;', '»')
        .replace('Previous', '‹')
        .replace('Next', '›');
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Annuaire des Organisations - RAOSC" />

        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- Effets de fond subtils -->
            <div class="fixed inset-0 pointer-events-none opacity-20 dark:opacity-5">
                <div class="absolute top-20 -left-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-green)"></div>
                <div class="absolute bottom-20 -right-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-yellow)"></div>
            </div>

            <!-- Header Section -->
            <div class="relative bg-zinc-950 py-16 sm:py-20 lg:py-24 px-6 overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-10 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-6 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/10 backdrop-blur-sm px-4 py-2 border border-white/20">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Annuaire des OSC Africaines</span>
                        </div>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight mb-4">
                        Le Réseau du <span class="text-raosc-yellow">Changement</span>
                    </h1>
                    <p class="text-sm sm:text-base text-zinc-400 max-w-2xl mx-auto font-medium">
                        Explorez l'annuaire interactif du RAOSC pour identifier et collaborer avec les organisations de la société civile.
                    </p>
                </div>
            </div>

            <!-- Search & Filters -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-8 sm:-mt-10 relative z-20">
                <Card class="shadow-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl">
                    <CardContent class="p-5 sm:p-6 lg:p-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search Name -->
                            <div class="relative">
                                <Search class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 w-4 h-4" />
                                <input 
                                    v-model="searchQuery" 
                                    type="text" 
                                    placeholder="Nom de l'organisation..." 
                                    class="w-full pl-10 pr-3 py-2.5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                >
                            </div>

                            <!-- Category Filter -->
                            <div class="relative">
                                <Filter class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 w-4 h-4" />
                                <select 
                                    v-model="selectedCategory" 
                                    class="w-full pl-10 pr-8 py-2.5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300 appearance-none cursor-pointer"
                                >
                                    <option value="">Toutes les catégories</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                                        {{ cat.name }}
                                    </option>
                                </select>
                                <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-3 h-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Country Filter -->
                            <div class="relative">
                                <Globe class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 w-4 h-4" />
                                <input 
                                    v-model="selectedCountry" 
                                    type="text" 
                                    placeholder="Pays..." 
                                    class="w-full pl-10 pr-3 py-2.5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                >
                            </div>

                            <!-- City Filter -->
                            <div class="relative">
                                <Map class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 w-4 h-4" />
                                <input 
                                    v-model="selectedCity" 
                                    type="text" 
                                    placeholder="Ville..." 
                                    class="w-full pl-10 pr-3 py-2.5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                >
                            </div>
                        </div>
                        
                        <!-- Active filters bar -->
                        <div v-if="hasActiveFilters()" class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-medium text-zinc-500">Filtres actifs :</span>
                                <span class="text-xs font-medium text-raosc-green bg-raosc-green/10 px-2.5 py-1 rounded-full">
                                    {{ organizations.total }} résultat<span v-if="organizations.total > 1">s</span>
                                </span>
                                <button 
                                    @click="resetFilters" 
                                    class="inline-flex items-center gap-1 text-xs font-medium text-zinc-500 hover:text-raosc-green transition-colors duration-300"
                                >
                                    <X class="w-3 h-3" />
                                    Tout effacer
                                </button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Results Grid -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-12 lg:py-16">
                
                <!-- Loading indicator -->
                <div v-if="isLoading" class="flex justify-center items-center py-16">
                    <div class="h-8 w-8 border-3 border-raosc-green border-t-transparent rounded-full animate-spin"></div>
                </div>

                <!-- No results -->
                <div v-else-if="organizations.data.length === 0" class="text-center py-16">
                    <Building2 class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-600 mb-4" />
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-1">Aucun résultat</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Ajustez vos critères de recherche.</p>
                </div>

                <!-- Results grid -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <OrganizationCard 
                        v-for="org in organizations.data" 
                        :key="org.id" 
                        :org="org" 
                    />
                </div>

                <!-- Pagination -->
                <div v-if="organizations.last_page > 1" class="mt-10 flex justify-center">
                    <nav class="flex items-center gap-1 bg-white dark:bg-zinc-900 p-1 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <Link 
                            v-for="link in organizations.links" 
                            :key="link.label" 
                            :href="link.url || '#'" 
                            class="min-w-[36px] h-9 px-3 rounded-lg text-sm font-medium transition-all duration-300 flex items-center justify-center"
                            :class="link.active 
                                ? 'bg-raosc-green text-white shadow-md' 
                                : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:scale-105'"
                            :preserve-scroll="true"
                        >
                            <span v-if="link.label === 'Previous'"><ChevronLeft class="w-4 h-4" /></span>
                            <span v-else-if="link.label === 'Next'"><ChevronRight class="w-4 h-4" /></span>
                            <span v-else>{{ formatLabel(link.label) }}</span>
                        </Link>
                    </nav>
                </div>
            </div>
        </div>
    </component>
</template>