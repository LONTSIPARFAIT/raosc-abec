<!-- MyOrganizations.vue - Refonte Full Width -->
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
    FileText,
    TrendingUp,
    Users,
    Award,
    Shield,
    HelpCircle
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

const stats = {
    total: organizations.length,
    approved: organizations.filter(o => o.status === 'approved').length,
    pending: organizations.filter(o => o.status === 'pending').length,
    rejected: organizations.filter(o => o.status === 'rejected').length
};
</script>

<template>
    <Head title="Mes Structures - RAOSC" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION - FULL WIDTH -->
            <!-- ============================================ -->
            <div class="border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 sticky top-0 z-20">
                <div class="container mx-auto px-6 lg:px-12 py-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-5">
                        
                        <!-- Titre et description -->
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="h-10 w-10 rounded-xl bg-raosc-green/10 flex items-center justify-center">
                                    <Building2 class="h-5 w-5 text-raosc-green" />
                                </div>
                                <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">
                                    Mes Structures
                                </h1>
                                <span class="px-2.5 py-0.5 text-xs font-bold bg-raosc-green/10 text-raosc-green rounded-full">
                                    {{ stats.total }}
                                </span>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 ml-13">
                                Gérez l'ensemble des organisations que vous avez inscrites ou auxquelles vous êtes rattaché.
                            </p>
                        </div>
                        
                        <!-- Bouton inscription -->
                        <Link 
                            :href="create().url" 
                            class="group shrink-0 inline-flex items-center gap-2 bg-raosc-green text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300"
                        >
                            <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                            Inscrire une organisation
                        </Link>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- STATS CARDS - 4 COLONNES -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 pt-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Carte Total -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-zinc-400 uppercase tracking-wider">Total</span>
                            <div class="h-8 w-8 rounded-lg bg-raosc-green/10 flex items-center justify-center">
                                <Building2 class="h-4 w-4 text-raosc-green" />
                            </div>
                        </div>
                        <div class="text-2xl font-black text-zinc-900 dark:text-white">{{ stats.total }}</div>
                        <div class="text-[10px] text-zinc-400 mt-1">organisation(s)</div>
                    </div>
                    
                    <!-- Carte Approuvées -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-zinc-400 uppercase tracking-wider">Approuvées</span>
                            <div class="h-8 w-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center">
                                <CheckCircle2 class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                            </div>
                        </div>
                        <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ stats.approved }}</div>
                        <div class="text-[10px] text-zinc-400 mt-1">structure(s) validée(s)</div>
                    </div>
                    
                    <!-- Carte En attente -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-zinc-400 uppercase tracking-wider">En attente</span>
                            <div class="h-8 w-8 rounded-lg bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                                <Clock class="h-4 w-4 text-amber-600 dark:text-amber-400" />
                            </div>
                        </div>
                        <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ stats.pending }}</div>
                        <div class="text-[10px] text-zinc-400 mt-1">structure(s) en vérification</div>
                    </div>
                    
                    <!-- Carte Rejetées -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-zinc-400 uppercase tracking-wider">Rejetées</span>
                            <div class="h-8 w-8 rounded-lg bg-red-100 dark:bg-red-500/10 flex items-center justify-center">
                                <XCircle class="h-4 w-4 text-red-600 dark:text-red-400" />
                            </div>
                        </div>
                        <div class="text-2xl font-black text-red-600 dark:text-red-400">{{ stats.rejected }}</div>
                        <div class="text-[10px] text-zinc-400 mt-1">structure(s) non validée(s)</div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- FILTRES -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 pt-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-2 text-sm font-medium bg-raosc-green text-white rounded-lg shadow-sm hover:shadow-md transition-all">
                            Toutes
                        </button>
                        <button class="px-4 py-2 text-sm font-medium bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg text-emerald-600 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-950/20 transition-all">
                            Approuvées
                        </button>
                        <button class="px-4 py-2 text-sm font-medium bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg text-amber-600 hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-amber-950/20 transition-all">
                            En attente
                        </button>
                        <button class="px-4 py-2 text-sm font-medium bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg text-red-600 hover:border-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 transition-all">
                            Rejetées
                        </button>
                    </div>
                    
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                        <span class="font-medium">{{ organizations.length }}</span> organisation(s) au total
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- ORGANISATIONS GRID - 3 COLONNES -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-8 pb-16">
                
                <!-- Grille des cartes -->
                <div v-if="organizations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="org in organizations" 
                        :key="org.id"
                        class="group relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                    >
                        <!-- En-tête de la carte -->
                        <div class="p-5 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                            <div class="flex items-start justify-between mb-3">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-raosc-green/10 to-raosc-yellow/10 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <Building2 class="w-6 h-6 text-raosc-green" />
                                </div>
                                <span :class="['inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full', getStatusClass(org.status)]">
                                    <component :is="getStatusIcon(org.status)" v-if="getStatusIcon(org.status)" class="w-3 h-3" />
                                    {{ getStatusLabel(org.status) }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-1 line-clamp-1 group-hover:text-raosc-green transition-colors">
                                {{ org.name }}
                            </h3>
                            
                            <div class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400">
                                <MapPin class="w-3.5 h-3.5 shrink-0" />
                                <span class="truncate">{{ org.city || 'Ville non renseignée' }}{{ org.country ? `, ${org.country}` : '' }}</span>
                            </div>
                        </div>
                        
                        <!-- Corps de la carte -->
                        <div class="p-5 pt-3">
                            <div v-if="org.registration_number" class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 mb-2">
                                <FileText class="w-3.5 h-3.5 shrink-0" />
                                <span class="truncate">N°: {{ org.registration_number }}</span>
                            </div>
                            
                            <div v-if="org.founded_date" class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                                <Calendar class="w-3.5 h-3.5 shrink-0" />
                                <span>Fondée en {{ new Date(org.founded_date).getFullYear() }}</span>
                            </div>
                            
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mb-4 min-h-[40px]">
                                {{ org.short_description || 'Aucune description courte disponible.' }}
                            </p>
                            
                            <!-- Rejection Alert -->
                            <div v-if="org.status === 'rejected' && org.rejection_reason" class="mx-5 mb-4 p-3 bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-900 rounded-xl">
                                <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                    <AlertCircle class="w-3 h-3" /> Motif du rejet :
                                </p>
                                <p class="text-xs text-red-700 dark:text-red-300 leading-relaxed italic">
                                    "{{ org.rejection_reason }}"
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                                <Link 
                                    :href="edit(org.slug).url" 
                                    :class="[
                                        'group/btn flex-1 inline-flex items-center justify-center gap-2 text-xs font-semibold py-2.5 rounded-xl transition-all duration-300 hover:scale-105',
                                        org.status === 'rejected' 
                                            ? 'bg-raosc-green text-white hover:bg-raosc-green/90 shadow-md shadow-raosc-green/20' 
                                            : 'bg-zinc-900 dark:bg-zinc-800 text-white hover:bg-zinc-800 dark:hover:bg-zinc-700'
                                    ]"
                                >
                                    <Edit class="w-3.5 h-3.5 group-hover/btn:rotate-12 transition-transform duration-300" />
                                    {{ org.status === 'rejected' ? 'Corriger & Renvoyer' : 'Éditer' }}
                                </Link>
                                <Link 
                                    v-if="org.status === 'approved'"
                                    :href="show(org.slug).url" 
                                    class="group/btn flex-1 inline-flex items-center justify-center gap-2 border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 text-xs font-semibold py-2.5 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:border-raosc-green/50 transition-all duration-300 hover:scale-105"
                                >
                                    Détails
                                    <ArrowRight class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform duration-300" />
                                </Link>
                                <div v-else class="flex-1"></div>
                            </div>
                        </div>
                        
                        <!-- Effet de bordure au hover -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none border-2 border-raosc-green" 
                             style="box-shadow: inset 0 0 0 2px var(--raosc-green)"></div>
                    </div>
                </div>

                <!-- État vide -->
                <div v-else class="bg-white dark:bg-zinc-900 rounded-2xl border-2 border-dashed border-zinc-200 dark:border-zinc-800 p-12 text-center">
                    <div class="h-20 w-20 bg-zinc-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <Building2 class="h-10 w-10 text-zinc-400 dark:text-zinc-500" />
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

            <!-- ============================================ -->
            <!-- SECTION AIDE - BANDE INFO -->
            <!-- ============================================ -->
            <div v-if="organizations.length > 0" class="border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 sticky bottom-0">
                <div class="container mx-auto px-6 lg:px-12 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-raosc-green/10 flex items-center justify-center shrink-0">
                                <HelpCircle class="h-5 w-5 text-raosc-green" />
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Besoin d'aide ?</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Contactez notre équipe pour toute question sur vos inscriptions</p>
                            </div>
                        </div>
                        <Link href="/contact" class="text-sm font-semibold text-raosc-green hover:underline flex items-center gap-1 shrink-0">
                            Contacter le support
                            <ArrowRight class="w-3.5 h-3.5" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>