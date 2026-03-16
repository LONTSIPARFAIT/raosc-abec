<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

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
    categories?: Category[];
}

defineProps<{
    org: Organization;
}>();
</script>

<template>
<article class="flex max-w-xl flex-col items-start justify-between bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 transition-all hover:border-emerald-500/50 hover:shadow-xl focus-within:ring-2 focus-within:ring-emerald-500 overflow-hidden group">
    
    <!-- Image de couverture de l'org ou placeholder Unsplash -->
    <div class="w-full h-48 bg-zinc-200 dark:bg-zinc-800 relative overflow-hidden shrink-0">
        <!-- Lien invisible pour rendre toute la carte cliquable plus classiquement mais on ciblera le header principal -->
        <Link :href="`/rao/orga/${org.slug}`" class="absolute inset-0 z-0" prefetch>
            <span class="sr-only">Voir l'organisation {{ org.name }}</span>
        </Link>
        
        <img 
            v-if="org.cover_image" 
            :src="org.cover_image" 
            :alt="'Couverture de ' + org.name"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
        />
        <!-- Placeholder par défaut (association / humanitaire) -->
        <img 
            v-else 
            src="https://images.unsplash.com/photo-1593113589914-075568e091ee?q=80&w=2070&auto=format&fit=crop" 
            alt="Default cover"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 dark:opacity-70" 
        />
        
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/90 via-zinc-900/20 to-transparent pointer-events-none"></div>
        <div class="absolute bottom-4 left-4 flex flex-wrap items-center gap-2 z-10">
            <span class="text-white font-medium uppercase tracking-wider text-[10px] sm:text-xs bg-emerald-600/90 backdrop-blur-sm px-2.5 py-1 rounded shadow-sm border border-emerald-500/50">
                {{ org.city || 'Siège National' }}
            </span>
            <span v-if="org.categories && org.categories.length > 0" class="rounded bg-white/90 dark:bg-zinc-900/90 px-2.5 py-1 text-[10px] sm:text-xs font-semibold text-zinc-900 dark:text-zinc-100 backdrop-blur-sm border border-zinc-200 dark:border-zinc-700 shadow-sm">
                {{ org.categories[0].name }}
            </span>
        </div>
    </div>

    <div class="p-6 flex flex-col flex-1 w-full relative">
        <!-- Logo superposé si disponible -->
        <div v-if="org.logo" class="absolute -top-12 right-6 p-1 bg-white dark:bg-zinc-900 rounded-full shadow-lg z-20 transition-transform group-hover:-translate-y-2 border border-zinc-100 dark:border-zinc-800">
            <img :src="org.logo" :alt="'Logo ' + org.name" class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover bg-zinc-50 dark:bg-zinc-800" />
        </div>
        
        <div class="pr-16 sm:pr-24 relative z-10 w-full">
            <h3 class="mt-2 text-xl font-bold leading-tight text-zinc-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                <Link :href="`/rao/orga/${org.slug}`" class="focus:outline-none" prefetch>
                    {{ org.name }}
                </Link> 
            </h3>
        </div>
        
        <p class="mt-4 line-clamp-3 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400 flex-1 relative z-10">
            {{ org.short_description || org.description || 'Découvrez les actions et les missions de cette organisation engagée sur notre plateforme pour le développement communautaire.' }}
        </p>
        
        <div class="mt-6 flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold text-sm relative z-10">
            <Link :href="`/rao/orga/${org.slug}`" class="flex items-center gap-2 hover:text-emerald-700 dark:hover:text-emerald-300" prefetch>
                <span>Visiter le profil</span>
                <span class="group-hover:translate-x-1.5 transition-transform duration-300">→</span>
            </Link>
        </div>
    </div>
</article>
</template>
