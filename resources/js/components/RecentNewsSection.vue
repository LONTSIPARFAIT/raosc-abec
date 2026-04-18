<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

defineProps<{
    news?: any[];
}>();

const getColorClass = (index: number) => {
    const colors = ['bg-raosc-green text-white', 'bg-raosc-yellow text-zinc-900', 'bg-raosc-red text-white'];
    return colors[index % colors.length];
};

const getHoverColor = (index: number) => {
    const colors = ['hover:text-raosc-green', 'hover:text-raosc-yellow', 'hover:text-raosc-red'];
    return colors[index % colors.length];
};

const getTextColor = (index: number) => {
    const colors = ['text-raosc-green', 'text-raosc-yellow', 'text-raosc-red'];
    return colors[index % colors.length];
};
</script>

<template>
    <section class="py-8 sm:py-12 bg-zinc-50 dark:bg-zinc-950 border-t border-zinc-100 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
             <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">
                        Actualités <span class="text-raosc-green">Récentes</span>
                    </h2>
                    <p class="text-sm text-zinc-500 mt-1">Découvrez les dernières avancées, événements et succès des organisations membres de notre réseau.</p>
                </div>
                <Link href="/posts" class="inline-flex items-center gap-2 text-xs font-semibold text-raosc-green hover:text-raosc-green/80 transition-colors bg-raosc-green/10 px-5 py-2.5 rounded-full border border-raosc-green/20 hover:border-raosc-green/30">
                    Voir toutes les actualités
                    <ArrowRight class="w-4 h-4" />
                </Link>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div 
                    v-for="(item, index) in news" 
                    :key="item.id"
                    class="group bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-xl shadow-zinc-200/40 dark:shadow-none hover:-translate-y-2 transition-all duration-300"
                >
                    <div class="h-56 relative overflow-hidden">
                        <img 
                            v-if="item.cover_image"
                            :src="item.cover_image" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                            :alt="item.title" 
                        />
                        <div v-else class="w-full h-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center">
                            <span class="text-zinc-400">Pas d'image</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                        <div :class="['absolute top-4 left-4 text-xs font-bold px-4 py-1.5 rounded-full shadow-sm', getColorClass(index)]">
                            Actualité
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <p class="text-xs font-semibold text-white/90 mb-1 drop-shadow-md">{{ new Date(item.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 :class="['text-xl font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 transition-colors cursor-pointer', getHoverColor(index)]">
                            {{ item.title }}
                        </h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-5 leading-relaxed" v-html="item.content.replace(/\n/g, '<br>').substring(0, 150) + '...'"></p>
                        
                        <Link 
                            :href="`/posts/${item.slug}`" 
                            :class="['font-bold text-sm inline-flex items-center gap-1.5 group/link', getTextColor(index)]"
                        >
                            Lire la suite 
                            <ArrowRight class="w-4 h-4 transition-transform group-hover/link:translate-x-1" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
