<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Building2,
    CheckCircle2,
    ShieldAlert,
    LayoutDashboard,
    Search,
    ChevronRight,
    SearchX,
    Clock
} from 'lucide-vue-next';
import AdminApprovalCard from '@/components/AdminApprovalCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';
import { ref, computed } from 'vue';

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

const props = defineProps<{
    pending: Organization[];
    recent: Organization[];
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

const filteredPending = computed(() => {
    if (!searchQuery.value) return props.pending;
    return props.pending.filter(org =>
        org.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        org.city?.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const getStatusClass = (status: string) => {
    switch (status) {
        case 'approved': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'rejected': return 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400';
        default: return 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/10 dark:text-zinc-400';
    }
};
</script>

<template>
    <Head title="Validation des OSC - RAOSC" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight flex items-center gap-3">
                        <ShieldAlert class="h-8 w-8 text-amber-500" />
                        Validation des OSC
                    </h1>
                    <p class="text-zinc-500 mt-2 font-medium">Gérez et validez les demandes d'inscription des organisations sur la plateforme.</p>
                </div>

                <div class="relative w-full md:w-72">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" />
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Rechercher une demande..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green transition-all"
                    />
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-[2rem] border border-zinc-100 dark:border-zinc-800 shadow-sm flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500">
                        <Clock class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-[12px] font-bold text-zinc-400 tracking-widest">En attente</p>
                        <p class="text-2xl font-black text-zinc-900 dark:text-white">{{ pending.length }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-[2rem] border border-zinc-100 dark:border-zinc-800 shadow-sm flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-raosc-green">
                        <CheckCircle2 class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-[12px] font-bold text-zinc-400 tracking-widest">Dernières approbations</p>
                        <p class="text-2xl font-black text-zinc-900 dark:text-white">{{ recent.filter(o => o.status === 'approved').length }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Main: Pending Requests -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                            Demandes Actuelles
                            <span class="text-xs bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full">{{ filteredPending.length }}</span>
                        </h2>
                    </div>

                    <div v-if="filteredPending.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <AdminApprovalCard v-for="org in filteredPending" :key="org.id" :organization="org" />
                    </div>

                    <div v-else class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-100 dark:border-zinc-800 p-12 text-center">
                        <div class="h-20 w-20 bg-zinc-50 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <SearchX v-if="searchQuery" class="h-10 w-10 text-zinc-300" />
                            <CheckCircle2 v-else class="h-10 w-10 text-raosc-green/30" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">
                            {{ searchQuery ? 'Aucun résultat trouvé' : 'Parfait ! Tout est à jour' }}
                        </h3>
                        <p class="text-zinc-500 max-w-xs mx-auto">
                            {{ searchQuery ? 'Essayez de modifier vos termes de recherche.' : 'Il n\'y a aucune demande d\'inscription en attente de validation.' }}
                        </p>
                    </div>
                </div>

                <!-- Sidebar: Recent History -->
                <div class="lg:col-span-4 bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-100 dark:border-zinc-800 p-8 shadow-sm">
                    <h3 class="text-lg font-black text-zinc-900 dark:text-white mb-6 tracking-tighter">Historique Récent</h3>

                    <div class="space-y-6">
                        <div v-for="org in recent" :key="org.id" class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-xl bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center shrink-0 border border-zinc-100 dark:border-zinc-700 overflow-hidden">
                                <img v-if="org.logo" :src="org.logo" class="h-full w-full object-cover" />
                                <Building2 v-else class="h-5 w-5 text-zinc-400" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ org.name }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span :class="['text-[8px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded', getStatusClass(org.status)]">
                                        {{ org.status === 'approved' ? 'Approuvé' : 'Rejeté' }}
                                    </span>
                                    <span class="text-[9px] text-zinc-400 font-bold uppercase">{{ new Date(org.created_at).toLocaleDateString() }}</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="recent.length === 0" class="text-center py-6 text-zinc-400 text-sm">
                            Aucun historique disponible.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
