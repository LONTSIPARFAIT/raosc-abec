<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import { marked } from 'marked';

defineProps<{
    news?: any[];
}>();

const parseMarkdown = (content: string) => {
    return marked.parse(content);
};

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
            
            <div v-if="!news || news.length === 0" class="py-20 text-center bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-100 dark:border-zinc-800">
                <p class="text-zinc-500 font-medium">Aucune actualité publiée pour le moment.</p>
            </div>
            
            <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-8">
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
                            <p class="text-xs font-semibold text-white/90 mb-1 drop-shadow-md">{{ item.created_at }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Organization Info -->
                        <div v-if="item.organization" class="flex items-center gap-2.5 mb-4 p-2 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800/50">
                            <div class="h-8 w-8 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-white">
                                <img v-if="item.organization.logo" :src="item.organization.logo" class="w-full h-full object-cover" :alt="item.organization.name" />
                                <div v-else class="w-full h-full flex items-center justify-center bg-raosc-green/10 text-raosc-green">
                                    <span class="text-[10px] font-bold">{{ item.organization?.name?.charAt(0) || '?' }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 truncate">{{ item.organization.name }}</span>
                        </div>

                        <h3 :class="['text-xl font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 transition-colors cursor-pointer', getHoverColor(index)]">
                            {{ item.title }}
                        </h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-5 leading-relaxed">{{ item.summary }}</p>
                        
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
