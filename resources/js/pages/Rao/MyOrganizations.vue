<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Building2,
    PlusCircle,
    Globe,
    Edit,
    ArrowRight,
    CheckCircle2,
    Clock,
    XCircle,
    MapPin,
    Calendar,
    FileText
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
        case 'rejected': return 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400';
        default: return 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/10 dark:text-zinc-400';
    }
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'approved': return CheckCircle2;
        case 'pending': return Clock;
        case 'rejected': return XCircle;
        default: return null;
    }
};

const getStatusLabel = (status: string) => {
    switch (status) {
        case 'approved': return 'Approuvée';
        case 'pending': return 'En attente';
        case 'rejected': return 'Rejetée';
        default: return status;
    }
};
</script>

<template>
    <Head title="Mes Structures - RAOSC" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-4 sm:p-6 lg:p-8">
            
            <!-- Effets de fond subtils -->
            <div class="fixed inset-0 pointer-events-none opacity-20 dark:opacity-5">
                <div class="absolute top-20 -left-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-green)"></div>
                <div class="absolute bottom-20 -right-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-yellow)"></div>
            </div>

            <!-- Header -->
            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="h-9 w-9 rounded-xl bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                            <Building2 class="h-5 w-5" />
                        </div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Mes Structures</h1>
                    </div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 ml-12">Gérez l'ensemble des organisations que vous avez inscrites ou auxquelles vous êtes rattaché.</p>
                </div>
                <Link 
                    :href="create().url" 
                    class="group inline-flex items-center gap-2 bg-raosc-green text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:scale-105 hover:shadow-lg transition-all duration-300 shadow-md"
                >
                    <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                    Inscrire une ONG 
                </Link>
            </div>

            <!-- Cards Grid -->
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div 
                    v-for="org in organizations" 
                    :key="org.id"
                    class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:border-raosc-green/30 flex flex-col"
                >
                    <!-- Header with icon and status -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <Building2 class="w-6 h-6 text-raosc-green" />
                        </div>
                        <span :class="['inline-flex items-center gap-1.5 text-[10px] font-semibold px-2.5 py-1 rounded-full', getStatusClass(org.status)]">
                            <component :is="getStatusIcon(org.status)" v-if="getStatusIcon(org.status)" class="w-3 h-3" />
                            {{ getStatusLabel(org.status) }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 line-clamp-1 group-hover:text-raosc-green transition-colors duration-300">
                        {{ org.name }}
                    </h3>
                    
                    <!-- Location -->
                    <div class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                        <MapPin class="w-3.5 h-3.5" />
                        <span>{{ org.city || 'Ville non renseignée' }}, {{ org.country || 'Pays non renseigné' }}</span>
                    </div>

                    <!-- Registration info (optional) -->
                    <div v-if="org.registration_number" class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 mb-2">
                        <FileText class="w-3.5 h-3.5" />
                        <span>N°: {{ org.registration_number }}</span>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mb-5 flex-grow">
                        {{ org.short_description || 'Aucune description courte disponible.' }}
                    </p>

                    <!-- Actions -->
                    <div class="flex gap-3 mt-auto pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <Link 
                            :href="edit(org.slug).url" 
                            class="group/btn flex-1 inline-flex items-center justify-center gap-2 bg-zinc-900 dark:bg-zinc-800 text-white text-xs font-semibold py-2 rounded-xl hover:bg-zinc-800 dark:hover:bg-zinc-700 transition-all duration-300 hover:scale-105"
                        >
                            <Edit class="w-3.5 h-3.5 group-hover/btn:rotate-12 transition-transform duration-300" />
                            Éditer
                        </Link>
                        <Link 
                            :href="show(org.slug).url" 
                            class="group/btn flex-1 inline-flex items-center justify-center gap-2 border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 text-xs font-semibold py-2 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:border-raosc-green/50 transition-all duration-300 hover:scale-105"
                        >
                            Détails
                            <ArrowRight class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform duration-300" />
                        </Link>
                    </div>

                    <!-- Hover border effect -->
                    <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" 
                         :style="{ boxShadow: 'inset 0 0 0 2px var(--raosc-green)' }"></div>
                </div>

                <!-- Empty State -->
                <div v-if="organizations.length === 0" class="col-span-full bg-white dark:bg-zinc-900 rounded-2xl border-2 border-dashed border-zinc-200 dark:border-zinc-800 p-10 text-center hover:border-raosc-green/50 transition-all duration-300">
                    <div class="h-16 w-16 bg-zinc-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <Building2 class="h-8 w-8 text-zinc-400 dark:text-zinc-500" />
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Aucune structure</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">
                        Vous n'avez pas encore inscrit d'organisation sur la plateforme RAOSC.
                    </p>
                    <Link 
                        :href="create().url" 
                        class="group inline-flex items-center gap-2 bg-raosc-green text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:scale-105 hover:shadow-lg transition-all duration-300"
                    >
                        <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                        Créer une organisation
                    </Link>
                </div>
            </div>

            <!-- Stats summary (optional) -->
            <div v-if="organizations.length > 0" class="relative z-10 flex justify-center gap-6 pt-4">
                <div class="text-center group cursor-pointer">
                    <div class="text-xl font-black text-raosc-green group-hover:scale-110 transition-transform duration-300">
                        {{ organizations.length }}
                    </div>
                    <div class="text-[10px] text-zinc-500">Structure(s)</div>
                </div>
                <div class="text-center group cursor-pointer">
                    <div class="text-xl font-black text-emerald-500 group-hover:scale-110 transition-transform duration-300">
                        {{ organizations.filter(o => o.status === 'approved').length }}
                    </div>
                    <div class="text-[10px] text-zinc-500">Approuvée(s)</div>
                </div>
                <div class="text-center group cursor-pointer">
                    <div class="text-xl font-black text-amber-500 group-hover:scale-110 transition-transform duration-300">
                        {{ organizations.filter(o => o.status === 'pending').length }}
                    </div>
                    <div class="text-[10px] text-zinc-500">En attente</div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>