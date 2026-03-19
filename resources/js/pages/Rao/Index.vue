<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Filter, Search, Globe, Map } from 'lucide-vue-next';
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
        <div class="relative bg-zinc-950 py-32 sm:py-48 px-6 text-center overflow-hidden">
            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2113" class="absolute inset-0 w-full h-full object-cover opacity-20 scale-105" />
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>

            <div class="relative text-center max-w-4xl mx-auto">
                <span class="text-[#008751] font-bold tracking-[0.2em] text-[10px] mb-4 block uppercase leading-none">Annuaire des OSC Africaines</span>
                <h1 class="text-4xl sm:text-7xl font-extrabold text-white mb-8 tracking-tight leading-none">
                    Le Réseau du <span class="text-[#008751]">Changement</span>
                </h1>
                <p class="text-zinc-400 text-lg sm:text-2xl max-w-4xl mx-auto leading-relaxed font-medium tracking-tight">
                    Explorez l'annuaire interactif du RAOSC pour identifier, filtrer et collaborer avec les organisations de la société civile agissant sur le terrain.
                </p>
            </div>
        </div>

        <!-- Search & Advanced Filters -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
            <Card class="bg-white dark:bg-zinc-900 shadow-xl border-zinc-200 dark:border-zinc-800 rounded-3xl">
                <CardContent class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search Name -->
                        <div class="relative group">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <input 
                                v-model="searchQuery" 
                                type="text" 
                                placeholder="Nom de l'ONG..." 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none text-sm transition-all dark:text-white"
                            >
                        </div>

                        <!-- Category Filter -->
                        <div class="relative group">
                            <Filter class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <select 
                                v-model="selectedCategory" 
                                class="w-full pl-10 pr-10 py-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none appearance-none text-sm dark:text-white"
                            >
                                <option value="">Toutes les catégories</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Country Filter -->
                        <div class="relative group">
                            <Globe class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <input 
                                v-model="selectedCountry" 
                                type="text" 
                                placeholder="Pays..." 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none text-sm transition-all dark:text-white"
                            >
                        </div>

                        <!-- City Filter -->
                        <div class="relative group">
                            <Map class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 h-4 w-4" />
                            <input 
                                v-model="selectedCity" 
                                type="text" 
                                placeholder="Ville..." 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none text-sm transition-all dark:text-white"
                            >
                        </div>
                    </div>
                    
                    <div v-if="searchQuery || selectedCategory || selectedCity || selectedCountry" class="mt-4 flex items-center justify-between">
                        <span class="text-[11px] font-bold text-[#008751] bg-[#008751]/5 px-3.5 py-1.5 rounded-lg border border-[#008751]/10 tracking-tight">
                            {{ organizations.total }} résultats trouvés
                        </span>
                        <button @click="resetFilters" class="text-xs font-semibold text-zinc-500 hover:text-[#008751] transition-colors">
                            Réinitialiser les filtres
                        </button>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Results Grid -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div v-if="organizations.data.length === 0" class="text-center py-20">
                <Building2 class="mx-auto h-12 w-12 text-zinc-300 mb-4" />
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Aucun résultat</h3>
                <p class="text-zinc-500 text-sm mt-1">Ajustez vos critères de recherche.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <OrganizationCard 
                    v-for="org in organizations.data" 
                    :key="org.id" 
                    :org="org" 
                />
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center" v-if="organizations.last_page > 1">
                <nav class="flex items-center gap-1 bg-white dark:bg-zinc-900 p-1.5 rounded-2xl shadow-lg border border-zinc-100 dark:border-zinc-800">
                    <Link v-for="link in organizations.links" :key="link.label" :href="link.url || '#'" 
                          class="px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all"
                          :class="link.active ? 'bg-[#008751] text-white' : 'text-zinc-500 hover:bg-zinc-50 dark:hover:bg-zinc-800'">
                        {{ link.label.replace('&laquo;', '').replace('&raquo;', '').replace('Previous', '«').replace('Next', '»') }}
                    </Link>
                </nav>
            </div>
        </div>
    </component>
</template>
