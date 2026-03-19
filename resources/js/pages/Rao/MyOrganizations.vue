<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Building2,
    PlusCircle,
    Globe,
    Edit,
    ArrowRight
} from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Organization {
    id: number;
    name: string;
    slug: string;
    status: string;
    city?: string;
    country?: string;
    registration_number?: string;
    founded_date?: string;
    short_description?: string;
}

defineProps<{
    organizations: Organization[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tableau de bord',
        href: '/dashboard',
    },
    {
        title: 'Mes structures',
        href: '/rao/mes-structures',
    },
];

const getStatusClass = (status: string) => {
    switch (status) {
        case 'approved': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'pending': return 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400';
        case 'rejected': return 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400';
        default: return 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/10 dark:text-zinc-400';
    }
};

const getStatusLabel = (status: string) => {
    switch (status) {
        case 'approved': return 'Approuvée';
        case 'pending': return 'En attente';
        case 'rejected': return 'Rejetée';
        default: return status;
    }
}
</script>

<template>
    <Head title="Mes Structures - RAOSC" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 p-6 lg:p-10 bg-zinc-50/50 dark:bg-zinc-950">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <Building2 class="text-raosc-green w-8 h-8" />
                        Mes Structures
                    </h1>
                    <p class="text-sm text-zinc-500">Gérez l'ensemble des organisations que vous avez inscrites ou auxquelles vous êtes rattaché.</p>
                </div>
                <div>
                    <Link 
                        href="/rao/join" 
                        class="flex items-center gap-2 bg-raosc-green text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#006b40] transition-all shadow-lg shadow-raosc-green/10"
                    >
                        <PlusCircle class="w-4 h-4" />
                        Inscrire une nouvelle OSC
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Structure Cards -->
                <div 
                    v-for="org in organizations" 
                    :key="org.id"
                    class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-6 shadow-sm flex flex-col hover:border-raosc-green/30 transition-all group"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="h-14 w-14 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 flex items-center justify-center flex-shrink-0">
                            <Building2 class="w-6 h-6 text-raosc-green" />
                        </div>
                        <span :class="['text-[10px] font-bold px-2.5 py-1 rounded-lg tracking-tight', getStatusClass(org.status)]">
                            {{ getStatusLabel(org.status) }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 line-clamp-1 group-hover:text-raosc-green transition-colors">{{ org.name }}</h3>
                    
                    <div class="flex items-center gap-2 text-[11px] font-medium text-zinc-400 mb-4 bg-zinc-50 dark:bg-zinc-800/50 px-3 py-1.5 rounded-lg w-fit border border-zinc-100 dark:border-zinc-800">
                        <Globe class="w-3.5 h-3.5" />
                        {{ org.city }}, {{ org.country }}
                    </div>

                    <p class="text-[13px] text-zinc-500 line-clamp-2 mb-6 flex-grow">
                        {{ org.short_description || 'Aucune description courte disponible.' }}
                    </p>

                    <div class="flex gap-3 mt-auto pt-6 border-t border-zinc-100 dark:border-zinc-800">
                        <Link 
                            :href="`/rao/orga/${org.slug}/edit`" 
                            class="flex-1 text-center bg-zinc-900 dark:bg-zinc-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-zinc-800 transition-all flex items-center justify-center gap-2"
                        >
                            <Edit class="w-3.5 h-3.5" />
                            Éditer
                        </Link>
                        <Link 
                            :href="`/rao/orga/${org.slug}`" 
                            class="flex-1 text-center bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-zinc-50 transition-all flex items-center justify-center gap-2"
                        >
                            Détails
                            <ArrowRight class="w-3.5 h-3.5" />
                        </Link>
                    </div>
                </div>

                <!-- Empty State if no organizations -->
                <div v-if="organizations.length === 0" class="col-span-full bg-zinc-50 dark:bg-zinc-900/50 rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800 p-12 text-center">
                    <div class="h-16 w-16 bg-white dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-zinc-100 dark:border-zinc-700">
                        <Building2 class="text-zinc-400 w-8 h-8" />
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Aucune structure</h3>
                    <p class="text-sm text-zinc-500 max-w-sm mx-auto mb-6">Vous n'avez pas encore inscrit d'organisation sur la plateforme RAOSC.</p>
                    <Link href="/rao/join" class="bg-raosc-green text-white px-6 py-2.5 rounded-xl text-sm font-bold inline-flex items-center gap-2 hover:opacity-90 transition-opacity">
                        <PlusCircle class="w-4 h-4" />
                        Créer une organisation
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
