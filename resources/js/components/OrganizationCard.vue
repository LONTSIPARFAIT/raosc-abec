<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Building2, MapPin, ArrowRight } from 'lucide-vue-next';

interface Category {
    id: number;
    name: string;
}

interface Organization {
    id: number;
    name: string;
    slug: string;
    logo?: string;
    cover_image?: string;
    short_description?: string;
    description?: string;
    city?: string;
    country?: string;
    categories?: Category[];
}

defineProps<{
    org: Organization;
}>();
</script>

<template>
<article class="h-full">
    <Link 
        :href="`/rao/orga/${org.slug}`"
        class="group flex flex-col h-full bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 transition-all duration-300 hover:border-raosc-green/40 hover:shadow-xl overflow-hidden"
        prefetch
    >
        <!-- Thumbnail -->
        <div class="relative h-32 bg-zinc-100 dark:bg-zinc-800 overflow-hidden shrink-0">
            <img 
                v-if="org.cover_image" 
                :src="org.cover_image" 
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900"></div>
            
            <!-- Logo Floating -->
            <div class="absolute -bottom-4 left-6 h-12 w-12 rounded-xl bg-white dark:bg-zinc-900 p-1 shadow-lg ring-1 ring-black/5 z-10">
                <div class="h-full w-full rounded-lg bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center overflow-hidden border border-zinc-100 dark:border-zinc-700">
                    <img v-if="org.logo" :src="org.logo" class="w-full h-full object-cover" />
                    <Building2 v-else class="h-6 w-6 text-raosc-green" />
                </div>
            </div>
        </div>

        <div class="pt-8 pb-6 px-6 flex flex-col flex-grow">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white group-hover:text-raosc-green transition-colors line-clamp-1 tracking-tight">
                    {{ org.name }}
                </h3>
                <div class="flex items-center text-[11px] font-semibold text-zinc-400 mt-1.5 gap-1.5 tracking-tight">
                    <MapPin class="h-3.5 w-3.5 text-raosc-green" />
                    <span>{{ org.city || 'Siège' }}{{ org.country ? `, ${org.country}` : '' }}</span>
                </div>
            </div>
            
            <p class="text-[13px] text-zinc-500 font-medium line-clamp-2 flex-grow mb-6 border-l-3 border-raosc-yellow/40 pl-4 py-0.5 leading-relaxed tracking-tight">
                {{ org.short_description || 'Aucune description disponible pour le moment.' }}
            </p>
            
            <div class="flex flex-wrap gap-2 pt-5 border-t border-zinc-50 dark:border-zinc-800">
                <template v-if="org.categories && org.categories.length > 0">
                    <span 
                        v-for="cat in org.categories.slice(0, 2)" 
                        :key="cat.id"
                        class="px-3 py-1.5 bg-raosc-green/5 text-raosc-green border border-raosc-green/10 rounded-xl text-[10px] font-bold tracking-tight"
                    >
                        {{ cat.name }}
                    </span>
                </template>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-all group-hover:translate-x-1">
                    <ArrowRight class="h-4.5 w-4.5 text-raosc-green" />
                </div>
            </div>
        </div>
    </Link>
</article>
</template>

