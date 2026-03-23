<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Filter, Search, Globe, Map, Building2 } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import OrganizationCard from '@/components/OrganizationCard.vue';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

const props = defineProps<{
    organizations: any;
    categories: any[];
    filters: Record<string, string>;
    isPublic?: boolean;
}>();

const searchQuery = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const selectedCity = ref(props.filters.city || '');
const selectedCountry = ref(props.filters.country || '');
const isLoading = ref(false);

const handleSearch = () => {
    isLoading.value = true;
    router.get(props.isPublic ? '/rao' : '/dashboard/rao', {
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

let timeout: any = null;
watch([searchQuery, selectedCategory, selectedCity, selectedCountry], () => {
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(() => {
        handleSearch();
    }, 400);
});
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Annuaire des Organisations - RAOSC" />

        <!-- Header Section -->
        <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
            </div>

            <div class="mx-auto max-w-4xl relative z-10 text-center">
                <div class="mb-8 flex justify-center">
                    <div class="flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 border border-white/20">
                        <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Annuaire des OSC Africaines</span>
                    </div>
                </div>
                <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                    Le Réseau du <span class="text-raosc-yellow">Changement</span>
                </h1>
                <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                    Explorez l'annuaire interactif du RAOSC pour identifier, filtrer et collaborer avec les organisations de la société civile agissant sur le terrain.
                </p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-8 sm:-mt-12 relative z-20">
            <Card class="shadow-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl">
                <CardContent class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <!-- Search Name -->
                        <div class="relative">
                            <Search class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <input 
                                v-model="searchQuery" 
                                type="text" 
                                placeholder="Nom de l'organisation..." 
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none text-sm transition-all dark:text-white"
                            >
                        </div>

                        <!-- Category Filter -->
                        <div class="relative">
                            <Filter class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <select 
                                v-model="selectedCategory" 
                                class="w-full pl-11 pr-10 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none appearance-none text-sm dark:text-white"
                            >
                                <option value="">Toutes les catégories</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Country Filter -->
                        <div class="relative">
                            <Globe class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <input 
                                v-model="selectedCountry" 
                                type="text" 
                                placeholder="Pays..." 
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none text-sm transition-all dark:text-white"
                            >
                        </div>

                        <!-- City Filter -->
                        <div class="relative">
                            <Map class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <input 
                                v-model="selectedCity" 
                                type="text" 
                                placeholder="Ville..." 
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none text-sm transition-all dark:text-white"
                            >
                        </div>
                    </div>
                    
                    <div v-if="searchQuery || selectedCategory || selectedCity || selectedCountry" class="mt-5 flex flex-wrap items-center justify-between gap-3">
                        <span class="text-xs font-medium text-raosc-green bg-raosc-green/5 px-3.5 py-1.5 rounded-full border border-raosc-green/10">
                            {{ organizations.total }} résultat<span v-if="organizations.total > 1">s</span> trouvé<span v-if="organizations.total > 1">s</span>
                        </span>
                        <button @click="resetFilters" class="text-xs font-medium text-zinc-500 hover:text-raosc-green transition-colors">
                            Réinitialiser les filtres
                        </button>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Results Grid -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <!-- Loading indicator -->
            <div v-if="isLoading" class="flex justify-center items-center py-20">
                <div class="h-8 w-8 border-2 border-raosc-green border-t-transparent rounded-full animate-spin"></div>
            </div>

            <div v-else-if="organizations.data.length === 0" class="text-center py-20">
                <Building2 class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-600 mb-4" />
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Aucun résultat</h3>
                <p class="text-zinc-500 text-sm mt-1">Ajustez vos critères de recherche.</p>
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <OrganizationCard 
                    v-for="org in organizations.data" 
                    :key="org.id" 
                    :org="org" 
                />
            </div>

            <!-- Pagination -->
            <div v-if="organizations.last_page > 1" class="mt-12 flex justify-center">
                <nav class="flex items-center gap-1.5 bg-white dark:bg-zinc-900 p-1.5 rounded-xl border border-zinc-100 dark:border-zinc-800">
                    <Link 
                        v-for="link in organizations.links" 
                        :key="link.label" 
                        :href="link.url || '#'" 
                        class="px-4 py-2 rounded-lg text-xs font-medium transition-all"
                        :class="link.active ? 'bg-raosc-green text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                    >
                        {{ link.label.replace('&laquo;', '«').replace('&raquo;', '»').replace('Previous', '‹').replace('Next', '›') }}
                    </Link>
                </nav>
            </div>
        </div>
    </component>
</template>