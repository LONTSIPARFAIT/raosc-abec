<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Filter, Search, Globe, Map, Building2, X, ChevronLeft, ChevronRight, Grid3x3, List, TrendingUp, Award, Shield, Users, Calendar } from 'lucide-vue-next';
import { ref, watch, computed } from 'vue';
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
    city?: string;
    country?: string;
    logo?: string;
    short_description?: string;
    status?: string;
    categories?: { id: number; name: string }[];
}

interface OrganizationsPagination {
    data: Organization[];
    total: number;
    last_page: number;
    current_page: number;
    per_page: number;
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

// États
const searchQuery = ref(filters.search || '');
const selectedCategory = ref(filters.category || '');
const selectedCity = ref(filters.city || '');
const selectedCountry = ref(filters.country || '');
const isLoading = ref(false);
const viewMode = ref<'grid' | 'list'>('grid');
const showFilters = ref(false);

// Computed
const hasActiveFilters = computed(() => {
    return !!(searchQuery.value || selectedCategory.value || selectedCity.value || selectedCountry.value);
});

const activeFiltersCount = computed(() => {
    let count = 0;
    if (searchQuery.value) count++;
    if (selectedCategory.value) count++;
    if (selectedCity.value) count++;
    if (selectedCountry.value) count++;
    return count;
});

// Méthodes
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

const clearFilter = (filterName: string) => {
    switch (filterName) {
        case 'search':
            searchQuery.value = '';
            break;
        case 'category':
            selectedCategory.value = '';
            break;
        case 'city':
            selectedCity.value = '';
            break;
        case 'country':
            selectedCountry.value = '';
            break;
    }
    handleSearch();
};

// Debounce
let timeout: ReturnType<typeof setTimeout> | null = null;
watch([searchQuery, selectedCategory, selectedCity, selectedCountry], () => {
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(() => {
        handleSearch();
    }, 400);
});

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
            
            <!-- ============================================ -->
            <!-- HEADER SECTION - MODERNE -->
            <!-- ============================================ -->
            <div class="relative bg-zinc-50 dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-16 lg:py-20 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute top-0 left-1/4 w-96 h-96 bg-raosc-green opacity-[0.08] dark:opacity-20 rounded-full blur-[120px]"></div>
                    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-raosc-yellow opacity-[0.05] dark:opacity-10 rounded-full blur-[120px]"></div>
                </div>

                <div class="container mx-auto px-6 lg:px-12 relative z-10">
                    <div class="max-w-3xl mx-auto text-center">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-raosc-green/5 dark:bg-white/10 backdrop-blur-sm border border-raosc-green/10 dark:border-white/20 mb-6">
                            <Award class="w-4 h-4 text-raosc-green dark:text-raosc-yellow" />
                            <span class="text-[10px] font-bold tracking-wider text-raosc-green dark:text-raosc-yellow uppercase">Réseau panafricain</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-zinc-900 dark:text-white tracking-tight mb-4">
                            Annuaire des <span class="text-raosc-green dark:text-raosc-yellow">Organisations</span>
                        </h1>
                        <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-300 max-w-2xl mx-auto font-medium">
                            Explorez notre réseau d'organisations de la société civile à travers l'Afrique.
                            Trouvez des partenaires, collaborez et développez votre impact.
                        </p>
                    </div>
                </div>
            </div>


            <!-- ============================================ -->
            <!-- SEARCH & FILTERS SECTION -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-8">
                
                <!-- Barre de recherche principale -->
                <div class="mb-4">
                    <div class="relative">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 w-5 h-5" />
                        <input 
                            v-model="searchQuery" 
                            type="text" 
                            placeholder="Rechercher une organisation par nom, mission ou localisation..." 
                            class="w-full pl-12 pr-24 py-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                        >
                        <button 
                            @click="showFilters = !showFilters"
                            class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all"
                            :class="showFilters || hasActiveFilters ? 'bg-raosc-green text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-raosc-green/10'"
                        >
                            <Filter class="w-4 h-4" />
                            Filtres
                            <span v-if="activeFiltersCount > 0" class="ml-1 px-1.5 py-0.5 text-xs bg-white/20 rounded-full">{{ activeFiltersCount }}</span>
                        </button>
                    </div>
                </div>

                <!-- Filtres avancés -->
                <transition name="slide-down">
                    <div v-if="showFilters" class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5 mb-4 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Catégorie -->
                            <div>
                                <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Catégorie</label>
                                <select 
                                    v-model="selectedCategory" 
                                    class="w-full px-3 py-2.5 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green outline-none text-sm transition-all"
                                >
                                    <option value="">Toutes les catégories</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                                        {{ cat.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Pays -->
                            <div>
                                <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Pays</label>
                                <div class="relative">
                                    <Globe class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 w-4 h-4" />
                                    <input 
                                        v-model="selectedCountry" 
                                        type="text" 
                                        placeholder="Tous les pays" 
                                        class="w-full pl-10 pr-3 py-2.5 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green outline-none text-sm transition-all"
                                    >
                                </div>
                            </div>

                            <!-- Ville -->
                            <div>
                                <label class="block text-xs font-semibold text-zinc-500 mb-1.5">Ville</label>
                                <div class="relative">
                                    <Map class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 w-4 h-4" />
                                    <input 
                                        v-model="selectedCity" 
                                        type="text" 
                                        placeholder="Toutes les villes" 
                                        class="w-full pl-10 pr-3 py-2.5 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green outline-none text-sm transition-all"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Actions filtres -->
                        <div class="flex justify-end gap-3 mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                            <button 
                                @click="resetFilters" 
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-zinc-500 hover:text-raosc-green transition-colors"
                            >
                                <X class="w-3 h-3" />
                                Réinitialiser tout
                            </button>
                        </div>
                    </div>
                </transition>

                <!-- Filtres actifs -->
                <div v-if="hasActiveFilters" class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="text-xs text-zinc-500">Filtres actifs :</span>
                    <div class="flex flex-wrap gap-2">
                        <span v-if="searchQuery" class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-raosc-green/10 text-raosc-green rounded-full">
                            Recherche: "{{ searchQuery }}"
                            <button @click="clearFilter('search')" class="hover:text-raosc-red"><X class="w-3 h-3" /></button>
                        </span>
                        <span v-if="selectedCategory" class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-raosc-green/10 text-raosc-green rounded-full">
                            Catégorie: {{ categories.find(c => c.slug === selectedCategory)?.name || selectedCategory }}
                            <button @click="clearFilter('category')" class="hover:text-raosc-red"><X class="w-3 h-3" /></button>
                        </span>
                        <span v-if="selectedCountry" class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-raosc-green/10 text-raosc-green rounded-full">
                            Pays: {{ selectedCountry }}
                            <button @click="clearFilter('country')" class="hover:text-raosc-red"><X class="w-3 h-3" /></button>
                        </span>
                        <span v-if="selectedCity" class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-raosc-green/10 text-raosc-green rounded-full">
                            Ville: {{ selectedCity }}
                            <button @click="clearFilter('city')" class="hover:text-raosc-red"><X class="w-3 h-3" /></button>
                        </span>
                    </div>
                </div>

                <!-- Header résultats -->
                <div class="flex flex-wrap items-center justify-between gap-4 py-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-zinc-500">Résultats :</span>
                        <span class="text-lg font-bold text-zinc-900 dark:text-white">{{ organizations.total }}</span>
                        <span class="text-sm text-zinc-500">organisation(s)</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <!-- Vue Grid / List -->
                        <div class="flex bg-zinc-100 dark:bg-zinc-800 rounded-lg p-1">
                            <button 
                                @click="viewMode = 'grid'"
                                :class="['p-1.5 rounded-md transition-all', viewMode === 'grid' ? 'bg-white dark:bg-zinc-700 shadow-sm text-raosc-green' : 'text-zinc-500']"
                            >
                                <Grid3x3 class="w-4 h-4" />
                            </button>
                            <button 
                                @click="viewMode = 'list'"
                                :class="['p-1.5 rounded-md transition-all', viewMode === 'list' ? 'bg-white dark:bg-zinc-700 shadow-sm text-raosc-green' : 'text-zinc-500']"
                            >
                                <List class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- RESULTS GRID / LIST -->
                <!-- ============================================ -->
                
                <!-- Loading -->
                <div v-if="isLoading" class="flex justify-center items-center py-20">
                    <div class="flex flex-col items-center gap-4">
                        <div class="h-10 w-10 border-3 border-raosc-green border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-sm text-zinc-500">Chargement des organisations...</p>
                    </div>
                </div>

                <!-- No results -->
                <div v-else-if="organizations.data.length === 0" class="text-center py-20 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800">
                    <Building2 class="mx-auto h-16 w-16 text-zinc-300 dark:text-zinc-600 mb-4" />
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Aucun résultat</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-md mx-auto">
                        Aucune organisation ne correspond à vos critères de recherche. Essayez de modifier vos filtres.
                    </p>
                    <button 
                        @click="resetFilters" 
                        class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-raosc-green text-white rounded-lg text-sm font-semibold hover:bg-raosc-green/90 transition-colors"
                    >
                        Réinitialiser les filtres
                    </button>
                </div>

                <!-- Vue Grid -->
                <div v-else-if="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <OrganizationCard 
                        v-for="org in organizations.data" 
                        :key="org.id" 
                        :org="org" 
                    />
                </div>

                <!-- Vue Liste -->
                <div v-else class="space-y-4">
                    <div v-for="org in organizations.data" :key="org.id" 
                         class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 hover:shadow-md transition-all hover:-translate-y-0.5 flex flex-col sm:flex-row gap-4">
                        <div class="h-20 w-20 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center flex-shrink-0">
                            <img v-if="org.logo" :src="org.logo" class="h-full w-full object-cover rounded-xl" />
                            <Building2 v-else class="h-8 w-8 text-zinc-400" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                <Link :href="`/rao/orga/${org.slug}`" class="text-lg font-bold text-zinc-900 dark:text-white hover:text-raosc-green transition-colors">
                                    {{ org.name }}
                                </Link>
                                <span v-if="org.status" :class="['text-[9px] font-semibold px-2 py-0.5 rounded-full', 
                                    org.status === 'approved' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 
                                    org.status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700']">
                                    {{ org.status === 'approved' ? 'Vérifiée' : org.status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-zinc-500 mb-2">
                                <span class="flex items-center gap-1"><Globe class="w-3 h-3" /> {{ org.country || 'Pays' }}{{ org.city ? `, ${org.city}` : '' }}</span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">{{ org.short_description || 'Aucune description disponible.' }}</p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span v-for="cat in org.categories?.slice(0, 2)" :key="cat.id" class="px-2 py-0.5 text-[9px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 rounded-full">
                                    {{ cat.name }}
                                </span>
                                <span v-if="org.categories && org.categories.length > 2" class="px-2 py-0.5 text-[9px] font-medium text-zinc-400">
                                    +{{ org.categories.length - 2 }}
                                </span>
                            </div>
                        </div>
                        <Link :href="`/rao/orga/${org.slug}`" class="sm:self-center inline-flex items-center gap-1 text-raosc-green font-semibold text-sm hover:gap-2 transition-all shrink-0">
                            Voir détails
                            <ChevronRight class="w-4 h-4" />
                        </Link>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- PAGINATION -->
                <!-- ============================================ -->
                <div v-if="organizations.last_page > 1" class="mt-10 flex justify-center">
                    <nav class="flex flex-wrap items-center justify-center gap-1 bg-white dark:bg-zinc-900 p-2 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <Link 
                            v-for="link in organizations.links" 
                            :key="link.label" 
                            :href="link.url || '#'" 
                            class="min-w-[38px] h-10 px-3 rounded-lg text-sm font-medium transition-all duration-300 flex items-center justify-center"
                            :class="link.active 
                                ? 'bg-raosc-green text-white shadow-md' 
                                : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:scale-105'"
                            :preserve-scroll="true"
                        >
                            <span v-if="link.label === 'Previous'"><ChevronLeft class="w-4 h-4" /></span>
                            <span v-else-if="link.label === 'Next'"><ChevronRight class="w-4 h-4" /></span>
                            <span v-else class="text-sm">{{ formatLabel(link.label) }}</span>
                        </Link>
                    </nav>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- SECTION CTA -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-12">
                <div class="bg-gradient-to-r from-raosc-green to-raosc-green/80 rounded-2xl p-8 text-center text-white">
                    <h3 class="text-2xl font-bold mb-2">Vous êtes une organisation ?</h3>
                    <p class="text-white/80 mb-6">Rejoignez le réseau RAOSC et bénéficiez de visibilité, de partenariats et d'outils adaptés.</p>
                    <Link href="/rao/join" class="inline-flex items-center gap-2 bg-white text-raosc-green px-6 py-3 rounded-xl font-semibold hover:scale-105 transition-all shadow-lg">
                        Inscrire mon organisation
                        <ChevronRight class="w-4 h-4" />
                    </Link>
                </div>
            </div>
        </div>
    </component>
</template>

<style scoped>
.slide-down-enter-active {
    transition: all 0.3s ease-out;
}
.slide-down-leave-active {
    transition: all 0.2s ease-in;
}
.slide-down-enter-from {
    transform: translateY(-10px);
    opacity: 0;
}
.slide-down-leave-to {
    transform: translateY(-5px);
    opacity: 0;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>