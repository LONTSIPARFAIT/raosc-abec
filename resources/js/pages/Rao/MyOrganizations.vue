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
import { create, show, edit, myOrganizations } from '@/actions/App/Http/Controllers/RaoController';
import { index as dashboardIndex } from '@/actions/App/Http/Controllers/DashboardController';

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

const {
    organizations = []
} = defineProps<{
    organizations?: Organization[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tableau de bord',
        href: dashboardIndex().url,
    },
    {
        title: 'Mes structures',
        href: myOrganizations().url,
    },
];

const getStatusClass = (status: string) => {
    switch (status) {
        case 'approved': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'pending': return 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400';
        case 'rejected': return 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-emerald-400'; // Typo in original emerald? fixing to red-400
        default: return 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/10 dark:text-zinc-400';
    }
};

// Fix typo from original if any
const getStatusClassFixed = (status: string) => {
    if (status === 'rejected') return 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400';
    return getStatusClass(status);
}

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
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="h-8 w-8 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                            <Building2 class="h-5 w-5" />
                        </div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Mes Structures</h1>
                    </div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 ml-11">Gérez l'ensemble des organisations que vous avez inscrites ou auxquelles vous êtes rattaché.</p>
                </div>
                <Link 
                    :href="create().url" 
                    class="inline-flex items-center gap-2 bg-raosc-green text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-raosc-green/90 transition-all shadow-md"
                >
                    <PlusCircle class="w-4 h-4" />
                    Inscrire une ONG 
                </Link>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="org in organizations" 
                    :key="org.id"
                    class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-raosc-green/30 transition-all flex flex-col"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center flex-shrink-0">
                            <Building2 class="w-6 h-6 text-raosc-green" />
                        </div>
                        <span :class="['text-[10px] font-semibold px-2.5 py-1 rounded-full', getStatusClassFixed(org.status)]">
                            {{ getStatusLabel(org.status) }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 line-clamp-1 group-hover:text-raosc-green transition-colors">
                        {{ org.name }}
                    </h3>
                    
                    <div class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 mb-4">
                        <Globe class="w-3.5 h-3.5" />
                        <span>{{ org.city }}, {{ org.country }}</span>
                    </div>

                    <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mb-6 flex-grow">
                        {{ org.short_description || 'Aucune description courte disponible.' }}
                    </p>

                    <div class="flex gap-3 mt-auto pt-5 border-t border-zinc-100 dark:border-zinc-800">
                        <Link 
                            :href="edit(org.slug).url" 
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-zinc-900 dark:bg-zinc-800 text-white text-xs font-semibold py-2.5 rounded-lg hover:bg-zinc-800 dark:hover:bg-zinc-700 transition-colors"
                        >
                            <Edit class="w-3.5 h-3.5" />
                            Éditer
                        </Link>
                        <Link 
                            :href="show(org.slug).url" 
                            class="flex-1 inline-flex items-center justify-center gap-2 border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 text-xs font-semibold py-2.5 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                        >
                            Détails
                            <ArrowRight class="w-3.5 h-3.5" />
                        </Link>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="organizations.length === 0" class="col-span-full bg-white dark:bg-zinc-900 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-12 text-center">
                    <div class="h-16 w-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <Building2 class="h-8 w-8 text-zinc-400 dark:text-zinc-500" />
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Aucune structure</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                        Vous n'avez pas encore inscrit d'organisation sur la plateforme RAOSC.
                    </p>
                    <Link 
                        :href="create().url" 
                        class="inline-flex items-center gap-2 bg-raosc-green text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-raosc-green/90 transition-colors"
                    >
                        <PlusCircle class="w-4 h-4" />
                        Créer une organisation
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>