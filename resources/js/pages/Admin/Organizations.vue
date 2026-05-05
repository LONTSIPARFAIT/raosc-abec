<!-- AdminOrganizationValidation.vue - Validation des OSC -->
<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { 
    Building2, CheckCircle2, ShieldAlert, Search, SearchX, 
    Clock, Trash2, Eye, XCircle, MapPin, Calendar, Mail, Phone,
    ChevronLeft, ChevronRight, AlertTriangle, Award, Users
} from 'lucide-vue-next';
import AdminApprovalCard from '@/components/AdminApprovalCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { ref, computed } from 'vue';
import { index as dashboardIndex } from '@/actions/App/Http/Controllers/DashboardController';
import { index as orgsIndex, destroy as destroyAction } from '@/actions/App/Http/Controllers/Admin/OrganizationManagementController';
import { dashboard } from '@/routes';

interface Organization {
    id: number;
    name: string;
    slug: string;
    status: string;
    city?: string;
    country?: string;
    logo?: string;
    short_description?: string;
    created_at: string;
    categories?: any[];
}

const {
    pending = [],
    recent = []
} = defineProps<{
    pending?: Organization[];
    recent?: Organization[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tableau de Bord',
        href: dashboard(),
    },
    {
        title: 'Validation OSC',
        href: '/admin/organizations',
    },
];

const searchQuery = ref('');
const filterStatus = ref<'all' | 'pending' | 'approved' | 'rejected'>('all');

const filteredPending = computed(() => {
    if (!searchQuery.value) return pending;
    return pending.filter(org =>
        org.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        org.city?.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const filteredRecent = computed(() => {
    let filtered = [...recent];
    if (filterStatus.value !== 'all') {
        filtered = filtered.filter(org => org.status === filterStatus.value);
    }
    if (searchQuery.value) {
        filtered = filtered.filter(org =>
            org.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }
    return filtered;
});

const getStatusClass = (status: string) => {
    switch (status) {
        case 'approved': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'rejected': return 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400';
        default: return 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/10 dark:text-zinc-400';
    }
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'approved': return CheckCircle2;
        case 'rejected': return XCircle;
        default: return Clock;
    }
};

const getStatusLabel = (status: string) => {
    switch (status) {
        case 'approved': return 'Approuvée';
        case 'rejected': return 'Rejetée';
        case 'pending': return 'En attente';
        default: return status;
    }
};

const deleteOrganization = (id: number) => {
    if (window.confirm('⚠️ Attention : Voulez-vous vraiment supprimer définitivement cette organisation ? Cette action est irréversible.')) {
        router.delete(destroyAction(id).url, { preserveScroll: true });
    }
};

const stats = computed(() => ({
    pending: pending.length,
    approved: recent.filter(o => o.status === 'approved').length,
    rejected: recent.filter(o => o.status === 'rejected').length,
    total: recent.length
}));
</script>

<template>
    <Head title="Validation des OSC - RAOSC" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION -->
            <!-- ============================================ -->
            <div class="sticky top-0 z-30 border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                <div class="container mx-auto px-6 lg:px-12 py-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                                <ShieldAlert class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                            </div>
                            <div>
                                <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">Validation des Organisations</h1>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Gérez et validez les demandes d'inscription des organisations sur la plateforme</p>
                            </div>
                        </div>
                        
                        <div class="relative w-full lg:w-80">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" />
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Rechercher une organisation..."
                                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green transition-all"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- STATS CARDS -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 flex items-center gap-4">
                        <div class="h-10 w-10 rounded-lg bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                            <Clock class="h-5 w-5 text-amber-600" />
                        </div>
                        <div>
                            <div class="text-2xl font-black text-zinc-900 dark:text-white">{{ stats.pending }}</div>
                            <div class="text-xs text-zinc-500">En attente</div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 flex items-center gap-4">
                        <div class="h-10 w-10 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center">
                            <CheckCircle2 class="h-5 w-5 text-emerald-600" />
                        </div>
                        <div>
                            <div class="text-2xl font-black text-emerald-600">{{ stats.approved }}</div>
                            <div class="text-xs text-zinc-500">Approuvées</div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 flex items-center gap-4">
                        <div class="h-10 w-10 rounded-lg bg-red-100 dark:bg-red-500/10 flex items-center justify-center">
                            <XCircle class="h-5 w-5 text-red-600" />
                        </div>
                        <div>
                            <div class="text-2xl font-black text-red-600">{{ stats.rejected }}</div>
                            <div class="text-xs text-zinc-500">Rejetées</div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 flex items-center gap-4">
                        <div class="h-10 w-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                            <Building2 class="h-5 w-5 text-purple-600" />
                        </div>
                        <div>
                            <div class="text-2xl font-black text-zinc-900 dark:text-white">{{ stats.total }}</div>
                            <div class="text-xs text-zinc-500">Total traitées</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU PRINCIPAL - 2 COLONNES -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-6 pb-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- ======================================== -->
                    <!-- COLONNE GAUCHE (8/12) - Demandes en attente -->
                    <!-- ======================================== -->
                    <div class="lg:col-span-8 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                <AlertTriangle class="h-5 w-5 text-amber-500" />
                                Demandes en attente
                                <span class="text-xs bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full">{{ filteredPending.length }}</span>
                            </h2>
                        </div>

                        <div v-if="filteredPending.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <AdminApprovalCard 
                                v-for="org in filteredPending" 
                                :key="org.id" 
                                :organization="org" 
                            />
                        </div>

                        <div v-else class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-12 text-center">
                            <div class="h-20 w-20 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <SearchX v-if="searchQuery" class="h-10 w-10 text-zinc-400" />
                                <CheckCircle2 v-else class="h-10 w-10 text-raosc-green/40" />
                            </div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">
                                {{ searchQuery ? 'Aucun résultat trouvé' : 'Aucune demande en attente' }}
                            </h3>
                            <p class="text-sm text-zinc-500 max-w-sm mx-auto">
                                {{ searchQuery ? 'Essayez de modifier vos termes de recherche.' : 'Toutes les demandes ont été traitées. Revenez plus tard.' }}
                            </p>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE (4/12) - Historique -->
                    <!-- ======================================== -->
                    <div class="lg:col-span-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                <Clock class="h-5 w-5 text-zinc-500" />
                                Historique récent
                                <span class="text-xs bg-zinc-100 text-zinc-600 px-2 py-0.5 rounded-full">{{ filteredRecent.length }}</span>
                            </h2>
                            
                            <div class="flex gap-1">
                                <button 
                                    @click="filterStatus = 'all'"
                                    :class="['px-2 py-1 text-[10px] font-semibold rounded transition-all', filterStatus === 'all' ? 'bg-raosc-green text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200']"
                                >
                                    Tous
                                </button>
                                <button 
                                    @click="filterStatus = 'approved'"
                                    :class="['px-2 py-1 text-[10px] font-semibold rounded transition-all', filterStatus === 'approved' ? 'bg-emerald-500 text-white' : 'bg-zinc-100 text-emerald-600 hover:bg-emerald-100']"
                                >
                                    Approuvés
                                </button>
                                <button 
                                    @click="filterStatus = 'rejected'"
                                    :class="['px-2 py-1 text-[10px] font-semibold rounded transition-all', filterStatus === 'rejected' ? 'bg-red-500 text-white' : 'bg-zinc-100 text-red-600 hover:bg-red-100']"
                                >
                                    Rejetés
                                </button>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                            <div v-if="filteredRecent.length > 0" class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                <div v-for="org in filteredRecent.slice(0, 8)" :key="org.id" class="p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 overflow-hidden">
                                            <img v-if="org.logo" :src="org.logo.startsWith('http') ? org.logo : '/storage/' + org.logo" class="h-full w-full object-cover" />
                                            <Building2 v-else class="h-5 w-5 text-zinc-400" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ org.name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span :class="['inline-flex items-center gap-1 text-[9px] font-bold px-1.5 py-0.5 rounded', getStatusClass(org.status)]">
                                                    <component :is="getStatusIcon(org.status)" class="w-2.5 h-2.5" />
                                                    {{ getStatusLabel(org.status) }}
                                                </span>
                                                <span class="text-[9px] text-zinc-400">{{ new Date(org.created_at).toLocaleDateString('fr-FR') }}</span>
                                            </div>
                                            <p class="text-[10px] text-zinc-500 mt-1 truncate">{{ org.city }}, {{ org.country }}</p>
                                        </div>
                                        <button 
                                            @click="deleteOrganization(org.id)"
                                            class="h-7 w-7 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shrink-0"
                                            title="Supprimer"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="p-8 text-center">
                                <div class="h-12 w-12 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <SearchX class="h-6 w-6 text-zinc-400" />
                                </div>
                                <p class="text-sm text-zinc-500">Aucun historique disponible</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>