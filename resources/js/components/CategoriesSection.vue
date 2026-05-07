<!-- components/CategoriesSection.vue - Badge Explorer toujours visible -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, GraduationCap, Heart, Leaf, Scale, Building, Users, Sparkles } from 'lucide-vue-next';

interface Category {
    id: number;
    name: string;
    slug: string;
    description: string | null;
}

defineProps<{
    categories?: Category[];
}>();

const getDefaultIcon = (slug: string) => {
    switch (slug) {
        case 'education-formation': return GraduationCap;
        case 'sante-publique': return Heart;
        case 'environnement-ecologie': return Leaf;
        case 'droits-humains': return Scale;
        case 'developpement-durable': return Building;
        case 'jeunesse-sports': return Users;
        default: return Building;
    }
};

const getDefaultColors = (index: number) => {
    const list = [
        { color: 'text-emerald-600', bgColor: 'bg-emerald-50 dark:bg-emerald-950/30' },
        { color: 'text-blue-600', bgColor: 'bg-blue-50 dark:bg-blue-950/30' },
        { color: 'text-amber-600', bgColor: 'bg-amber-50 dark:bg-amber-950/30' },
        { color: 'text-purple-600', bgColor: 'bg-purple-50 dark:bg-purple-950/30' },
        { color: 'text-rose-600', bgColor: 'bg-rose-50 dark:bg-rose-950/30' },
        { color: 'text-cyan-600', bgColor: 'bg-cyan-50 dark:bg-cyan-950/30' },
    ];
    return list[index % list.length];
};
</script>

<template>
    <div class="py-10 sm:py-16 bg-white dark:bg-zinc-950 overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-6 mb-8 sm:mb-12">
                <div class="text-center sm:text-left">
                    <div class="inline-flex items-center gap-1.5 bg-raosc-green/10 px-3 py-1 rounded-full mb-2 sm:mb-3">
                        <Sparkles class="w-3 h-3 text-raosc-green" />
                        <span class="text-[8px] sm:text-[10px] font-bold text-raosc-green uppercase tracking-wider">Domaines d'action</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">
                        Parcourir par <span class="text-raosc-green">catégorie</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Trouvez les organisations qui correspondent à vos intérêts</p>
                </div>
                <Link 
                    href="/rao" 
                    class="shrink-0 inline-flex items-center gap-1.5 text-[10px] sm:text-xs font-semibold text-raosc-green hover:text-raosc-green/80 transition-all bg-raosc-green/10 px-3.5 sm:px-5 py-1.5 sm:py-2.5 rounded-full border border-raosc-green/20 hover:border-raosc-green/30"
                >
                    Voir toutes les catégories
                    <ArrowRight class="w-3 h-3 sm:w-4 sm:h-4" />
                </Link>
            </div>

            <!-- ============================================ -->
            <!-- DÉFILEMENT INFINI - BADGE TOUJOURS VISIBLE -->
            <!-- ============================================ -->
            <div class="relative w-full overflow-hidden mask-edges mt-6 sm:mt-8">
                <div class="flex marquee-content">
                    
                    <!-- Groupe original -->
                    <div class="flex gap-3 sm:gap-5 md:gap-6 pr-3 sm:pr-5 md:pr-6">
                        <Link
                            v-for="(cat, index) in categories"
                            :key="`orig-${cat.id}`"
                            :href="`/rao?category=${cat.slug}`"
                            class="shrink-0 group flex flex-col items-center p-3 sm:p-4 md:p-6 bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl border border-zinc-100 dark:border-zinc-800 hover:border-raosc-green/30 hover:shadow-md transition-all duration-300"
                            :class="{
                                'w-28 sm:w-36 md:w-48': true
                            }"
                        >
                            <!-- Icône -->
                            <div :class="['rounded-xl flex items-center justify-center mb-2 sm:mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300',
                                getDefaultColors(index).bgColor
                            ]">
                                <component :is="getDefaultIcon(cat.slug)" :class="['w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7', getDefaultColors(index).color]" />
                            </div>
                            
                            <!-- Nom -->
                            <span class="text-[10px] sm:text-xs md:text-sm font-semibold text-zinc-900 dark:text-white text-center line-clamp-2 min-h-[2rem] sm:min-h-[2.5rem] md:min-h-[3rem]">
                                {{ cat.name }}
                            </span>
                            
                            <!-- Badge Explorer - TOUJOURS VISIBLE sur toutes les plateformes -->
                            <span class="text-[8px] sm:text-[9px] md:text-[10px] font-medium text-raosc-green mt-1.5 sm:mt-2 md:mt-3 bg-raosc-green/10 px-2 sm:px-2.5 md:px-3 py-0.5 sm:py-1 md:py-1.5 rounded-full transition-all duration-300 group-hover:bg-raosc-green/20">
                                Explorer →
                            </span>
                        </Link>
                    </div>

                    <!-- Groupe cloné pour le défilement infini -->
                    <div class="flex gap-3 sm:gap-5 md:gap-6 pl-3 sm:pl-5 md:pl-6" aria-hidden="true">
                        <Link
                            v-for="(cat, index) in categories"
                            :key="`clone-${cat.id}`"
                            :href="`/rao?category=${cat.slug}`"
                            class="shrink-0 group flex flex-col items-center p-3 sm:p-4 md:p-6 bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl border border-zinc-100 dark:border-zinc-800 hover:border-raosc-green/30 hover:shadow-md transition-all duration-300"
                            :class="{
                                'w-28 sm:w-36 md:w-48': true
                            }"
                        >
                            <div :class="['rounded-xl flex items-center justify-center mb-2 sm:mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300', getDefaultColors(index).bgColor]">
                                <component :is="getDefaultIcon(cat.slug)" :class="['w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7', getDefaultColors(index).color]" />
                            </div>
                            <span class="text-[10px] sm:text-xs md:text-sm font-semibold text-zinc-900 dark:text-white text-center line-clamp-2 min-h-[2rem] sm:min-h-[2.5rem] md:min-h-[3rem]">
                                {{ cat.name }}
                            </span>
                            <span class="text-[8px] sm:text-[9px] md:text-[10px] font-medium text-raosc-green mt-1.5 sm:mt-2 md:mt-3 bg-raosc-green/10 px-2 sm:px-2.5 md:px-3 py-0.5 sm:py-1 md:py-1.5 rounded-full transition-all duration-300 group-hover:bg-raosc-green/20">
                                Explorer →
                            </span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Message si aucune catégorie -->
            <div v-if="!categories?.length" class="text-center py-12 bg-zinc-50 dark:bg-zinc-900 rounded-2xl mt-8">
                <Building class="w-12 h-12 text-zinc-300 mx-auto mb-3" />
                <p class="text-sm text-zinc-500">Aucune catégorie disponible pour le moment.</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* ============================================ */
/* MASQUE DE FONDU POUR EFFET INFINI */
/* ============================================ */
.mask-edges {
    mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
}

/* ============================================ */
/* ANIMATION DÉFILEMENT INFINI */
/* ============================================ */
.marquee-content {
    animation: scroll 25s linear infinite;
    width: max-content;
}

.marquee-content:hover {
    animation-play-state: paused;
}

/* Vitesse plus lente sur mobile pour meilleure lisibilité */
@media (max-width: 640px) {
    .marquee-content {
        animation: scroll 35s linear infinite;
    }
}

/* Animation desktop plus rapide */
@media (min-width: 1024px) {
    .marquee-content {
        animation: scroll 25s linear infinite;
    }
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

/* ============================================ */
/* UTILITAIRES */
/* ============================================ */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>