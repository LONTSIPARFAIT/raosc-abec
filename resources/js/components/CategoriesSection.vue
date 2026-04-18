<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, GraduationCap, Heart, Leaf, Scale, Building, Users } from 'lucide-vue-next';

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
        { color: 'text-blue-600', bgColor: 'bg-blue-50 dark:bg-blue-950/30' },
        { color: 'text-red-600', bgColor: 'bg-red-50 dark:bg-red-950/30' },
        { color: 'text-green-600', bgColor: 'bg-green-50 dark:bg-green-950/30' },
        { color: 'text-purple-600', bgColor: 'bg-purple-50 dark:bg-purple-950/30' },
        { color: 'text-orange-600', bgColor: 'bg-orange-50 dark:bg-orange-950/30' },
        { color: 'text-pink-600', bgColor: 'bg-pink-50 dark:bg-pink-950/30' },
    ];
    return list[index % list.length];
};
</script>

<template>
    <div class="py-8 sm:py-12 bg-white dark:bg-zinc-950">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">
                        Parcourir par <span class="text-raosc-green">catégorie</span>
                    </h2>
                    <p class="text-sm text-zinc-500 mt-1">Trouvez les organisations qui correspondent à vos intérêts.</p>
                </div>
                <Link href="/rao" class="inline-flex items-center gap-2 text-xs font-semibold text-raosc-green hover:text-raosc-green/80 transition-colors bg-raosc-green/10 px-5 py-2.5 rounded-full border border-raosc-green/20 hover:border-raosc-green/30">
                    Voir toutes les catégories
                    <ArrowRight class="w-4 h-4" />
                </Link>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                <Link
                    v-for="(cat, index) in categories"
                    :key="cat.id"
                    :href="`/rao?category=${cat.slug}`"
                    class="group flex flex-col items-center p-6 bg-zinc-50 dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 hover:border-raosc-green/30 hover:shadow-md transition-all duration-200"
                >
                    <div :class="['w-14 h-14 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200', getDefaultColors(index).bgColor]">
                        <component :is="getDefaultIcon(cat.slug)" :class="['w-7 h-7', getDefaultColors(index).color]" />
                    </div>
                    <span class="text-sm font-semibold text-zinc-900 dark:text-white tracking-tight">{{ cat.name }}</span>
                    <span class="text-[10px] font-medium text-raosc-green mt-2 bg-raosc-green/10 px-2.5 py-1 rounded-full">Explorer</span>
                </Link>
            </div>
        </div>
    </div>
</template>
