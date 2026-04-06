<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

// Exemple de données statiques pour l'instant (à dynamiser plus tard avec la DB)
const news = [
    {
        id: 1,
        title: "Lancement du programme d'accès à l'eau potable en zone rurale",
        summary: "De nombreuses ONG se sont réunies pour initier ce grand projet visant à fournir de l'eau potable à plus de 50 villages...",
        category: "Solidarité",
        color: "raosc-green",
        date: "4 Avril 2026",
        image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop"
    },
    {
        id: 2,
        title: "Nouvelle convention de partenariat pour la scolarisation",
        summary: "Un accord historique a été signé aujourd'hui pour soutenir financièrement les familles et encourager la scolarisation continuelle.",
        category: "Éducation",
        color: "raosc-yellow",
        date: "2 Avril 2026",
        image: "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop"
    },
    {
        id: 3,
        title: "Campagne de vaccination gratuite et de prévention",
        summary: "Les équipes médicales bénévoles se déploient dans plusieurs régions pour des consultations gratuites et de la prévention médicale.",
        category: "Santé",
        color: "raosc-red",
        date: "30 Mars 2026",
        image: "https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=600&auto=format&fit=crop"
    }
];

const getColorClass = (color: string) => {
    if (color === 'raosc-yellow') return 'bg-raosc-yellow text-zinc-900';
    if (color === 'raosc-red') return 'bg-raosc-red text-white';
    return 'bg-raosc-green text-white';
};

const getHoverColor = (color: string) => {
    if (color === 'raosc-yellow') return 'hover:text-raosc-yellow';
    if (color === 'raosc-red') return 'hover:text-raosc-red';
    return 'hover:text-raosc-green';
};

const getTextColor = (color: string) => {
    if (color === 'raosc-yellow') return 'text-raosc-yellow';
    if (color === 'raosc-red') return 'text-raosc-red';
    return 'text-raosc-green';
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
                    v-for="item in news" 
                    :key="item.id"
                    class="group bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-xl shadow-zinc-200/40 dark:shadow-none hover:-translate-y-2 transition-all duration-300"
                >
                    <div class="h-56 relative overflow-hidden">
                        <img 
                            :src="item.image" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                            :alt="item.title" 
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                        <div :class="['absolute top-4 left-4 text-xs font-bold px-4 py-1.5 rounded-full shadow-sm', getColorClass(item.color)]">
                            {{ item.category }}
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <p class="text-xs font-semibold text-white/90 mb-1 drop-shadow-md">{{ item.date }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 :class="['text-xl font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 transition-colors cursor-pointer', getHoverColor(item.color)]">
                            {{ item.title }}
                        </h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3 mb-5 leading-relaxed">
                            {{ item.summary }}
                        </p>
                        
                        <Link 
                            :href="`/posts`" 
                            :class="['font-bold text-sm inline-flex items-center gap-1.5 group/link', getTextColor(item.color)]"
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
