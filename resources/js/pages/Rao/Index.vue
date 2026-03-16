<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { MapPin, Building2, Search, Filter } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';

// const props = defineProps({
//     organizations: Object,
//     categories: Array,
//     filters: Object
// });

const props = defineProps<{
    organizations: any; // ou ton type OrganizationResource[]
    categories: any[];
    filters: Record<string, string>;
}>();

const searchQuery = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');

const handleSearch = () => {
    router.get('/rao', {
        search: searchQuery.value,
        category: selectedCategory.value
    }, { preserveState: true, replace: true });
};

watch([searchQuery, selectedCategory], () => {
    handleSearch();
});
</script>

<template>
    <AppLayout>
        <Head title="Réseau Africain des Organisations de la Societe Civile (RAOSC)" />

        <!-- Header Section avec Glassmorphism -->
        <div class="relative overflow-hidden bg-slate-950 px-6 py-24 sm:px-12 sm:py-32 lg:px-16 text-center shadow-2xl">
            <!-- Background Gradients -->
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#00b4d8] to-[#90e0ef] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
            </div>
            
            <div class="mx-auto max-w-4xl relative z-10">
                <Badge variant="secondary" class="mb-4 bg-white/10 text-white hover:bg-white/20 border-0 backdrop-blur-md">
                    Initiative ABEC
                </Badge>
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl mb-6">
                    Réseau Africain des <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Organisations</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-300 max-w-2xl mx-auto">
                    Découvrez, connectez et collaborez avec les organisations œuvrant pour le développement et le bien-être en Afrique.
                </p>
                
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <Link href="/rao/join">
                        <Button size="lg" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white rounded-full px-8 shadow-lg shadow-blue-500/25 transition-all duration-300 hover:scale-105">
                            Rejoindre le Réseau
                        </Button>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
            <Card class="backdrop-blur-xl bg-white/90 dark:bg-slate-900/90 shadow-xl border-slate-200/50 dark:border-slate-800/50">
                <CardContent class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-grow">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <input 
                                v-model="searchQuery" 
                                type="text" 
                                placeholder="Rechercher une organisation..." 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white"
                            >
                        </div>
                        <div class="relative min-w-[200px]">
                            <Filter class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <select 
                                v-model="selectedCategory" 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none appearance-none dark:text-white"
                            >
                                <option value="">Tous les domaines</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Organizations Grid -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div v-if="organizations.data.length === 0" class="text-center py-20 text-gray-500">
                <Building2 class="mx-auto h-16 w-16 text-gray-300 mb-4" />
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Aucune organisation trouvée</h3>
                <p>Essayez de modifier vos filtres de recherche.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <Link 
                    v-for="org in organizations.data" 
                    :key="org.id" 
                    :href="`/rao/orga/${org.slug}`"
                    class="group"
                >
                    <Card class="h-full overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 border-gray-100 dark:border-gray-800 bg-white dark:bg-slate-900/50">
                        <div class="h-32 bg-slate-100 dark:bg-slate-800 relative overflow-hidden">
                            <img v-if="org.cover_image" :src="org.cover_image" class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            
                            <!-- Logo Avatar -->
                            <div class="absolute -bottom-6 left-6 h-16 w-16 rounded-xl bg-white dark:bg-slate-800 p-1 shadow-lg ring-1 ring-black/5">
                                <div class="h-full w-full rounded-lg bg-emerald-100 border flex items-center justify-center overflow-hidden">
                                     <img v-if="org.logo" :src="org.logo" class="w-full h-full object-cover" />
                                     <Building2 v-else class="h-8 w-8 text-emerald-600" />
                                </div>
                            </div>
                        </div>
                        
                        <CardHeader class="pt-10 pb-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <CardTitle class="text-xl font-bold group-hover:text-blue-600 transition-colors line-clamp-1">{{ org.name }}</CardTitle>
                                    <div class="flex items-center text-sm text-gray-500 mt-2 gap-1">
                                        <MapPin class="h-4 w-4" />
                                        <span>{{ org.city }}, {{ org.country }}</span>
                                    </div>
                                </div>
                            </div>
                        </CardHeader>
                        
                        <CardContent>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4">
                                {{ org.short_description }}
                            </p>
                            
                            <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
                                <Badge v-for="cat in org.categories" :key="cat.id" variant="outline" class="bg-blue-50/50 text-blue-700 border-blue-200 dark:bg-blue-900/20 dark:text-blue-300">
                                    {{ cat.name }}
                                </Badge>
                            </div>
                        </CardContent>
                    </Card>
                </Link>
            </div>

            <!-- Pagination Simple -->
            <div class="mt-12 flex justify-center" v-if="organizations.last_page > 1">
                <div class="flex gap-2">
                    <Link v-for="link in organizations.links" :key="link.label" :href="link.url || '#'" 
                          class="px-4 py-2 rounded-md border text-sm"
                          :class="link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-50'"
                          v-html="link.label">
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
