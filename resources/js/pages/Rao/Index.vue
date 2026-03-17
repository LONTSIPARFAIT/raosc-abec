<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Filter, MapPin, Search, Building2, Globe, Map } from 'lucide-vue-next';
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

const handleSearch = () => {
    router.get(props.isPublic ? '/rao' : '/dashboard/rao', {
        search: searchQuery.value,
        category: selectedCategory.value,
        city: selectedCity.value,
        country: selectedCountry.value
    }, { preserveState: true, replace: true });
};

const resetFilters = () => {
    searchQuery.value = '';
    selectedCategory.value = '';
    selectedCity.value = '';
    selectedCountry.value = '';
    handleSearch();
};

watch([searchQuery, selectedCategory, selectedCity, selectedCountry], () => {
    handleSearch();
});
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Annuaire des Organisations - RAOSC" />

        <!-- Header Section -->
        <div class="bg-zinc-950 px-6 py-16 sm:py-24 text-center">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-3xl sm:text-5xl font-bold text-white mb-4 tracking-tight">
                    Annuaire des <span class="text-[#008751]">Organisations</span>
                </h1>
                <p class="text-zinc-400 text-sm sm:text-base max-w-2xl mx-auto">
                    Recherchez et filtrez les organisations de la société civile par domaine, ville ou pays.
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
                    
                    <div v-if="searchQuery || selectedCategory || selectedCity || selectedCountry" class="mt-4 flex justify-end">
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
                <Link 
                    v-for="org in organizations.data" 
                    :key="org.id" 
                    :href="isPublic ? `/rao/orga/${org.slug}` : `/dashboard/rao/orga/${org.slug}`"
                    class="group"
                >
                    <Card class="h-full border-zinc-200 dark:border-zinc-800 hover:border-[#008751]/50 transition-all rounded-3xl overflow-hidden shadow-sm hover:shadow-lg">
                        <div class="h-32 bg-zinc-100 dark:bg-zinc-800 relative">
                            <img v-if="org.cover_image" :src="org.cover_image" class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-zinc-800 dark:to-zinc-900"></div>
                            
                            <!-- Logo -->
                            <div class="absolute -bottom-6 left-6 h-16 w-16 rounded-2xl bg-white dark:bg-zinc-900 p-1 shadow-lg ring-1 ring-black/5">
                                <div class="h-full w-full rounded-xl bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center overflow-hidden">
                                     <img v-if="org.logo" :src="org.logo" class="w-full h-full object-cover" />
                                     <Building2 v-else class="h-8 w-8 text-[#008751]" />
                                </div>
                            </div>
                        </div>
                        
                        <CardHeader class="pt-10 pb-2 px-6">
                            <CardTitle class="text-lg font-bold group-hover:text-[#008751] transition-colors line-clamp-1 italic">
                                {{ org.name }}
                            </CardTitle>
                            <div class="flex items-center text-[10px] font-bold text-zinc-500 mt-1 gap-1 uppercase tracking-wider">
                                <MapPin class="h-3 w-3 text-[#008751]" />
                                <span>{{ org.city }}, {{ org.country }}</span>
                            </div>
                        </CardHeader>
                        
                        <CardContent class="px-6 pb-6 mt-2">
                            <p class="text-zinc-600 dark:text-zinc-400 text-xs leading-relaxed line-clamp-2 mb-4 font-medium italic border-l-2 border-[#FFCB05] pl-3">
                                {{ org.short_description }}
                            </p>
                            
                            <div class="flex flex-wrap gap-1.5 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                                <Badge v-for="cat in org.categories" :key="cat.id" variant="outline" class="text-[9px] font-bold uppercase py-0.5 px-2">
                                    {{ cat.name }}
                                </Badge>
                            </div>
                        </CardContent>
                    </Card>
                </Link>
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
