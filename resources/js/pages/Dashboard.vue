<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Bell,
    Building2, 
    Check,
    CheckCircle2, 
    ChevronRight,
    Clock, 
    Globe, 
    PlusCircle, 
    Search,
    Users
} from 'lucide-vue-next';
import AdminApprovalCard from '@/components/AdminApprovalCard.vue';
import StatsChart from '@/components/StatsChart.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

interface Stats {
    total_orgs: number;
    pending_orgs: number;
    total_users: number;
    my_orgs: number;
}

interface Organization {
    id: number;
    name: string;
    slug: string;
    status: string;
    city?: string;
    country?: string;
    registration_number?: string;
    founded_date?: string;
}

defineProps<{
    stats: Stats;
    userOrganization: Organization | null;
    recentOrgs: Organization[];
    pendingOrgsList: Organization[];
    chartData: {
        categories: any;
        registrations: any;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tableau de Bord',
        href: dashboard(),
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
    <Head title="Tableau de Bord" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 p-6 lg:p-10 bg-zinc-50/50 dark:bg-zinc-950">
            
            <!-- Header Welcome -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Bonjour, {{ $page.props.auth.user.name }} 👋</h1>
                    <p class="text-sm text-zinc-500">Bienvenue sur votre espace RAOSC. Voici un aperçu de l'activité.</p>
                </div>
                <div class="flex gap-3">
                    <Link 
                        href="/rao" 
                        class="flex items-center gap-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 px-4 py-2 rounded-xl text-sm font-bold hover:bg-zinc-50 transition-all"
                    >
                        <Search class="w-4 h-4 text-zinc-400" />
                        Annuaire
                    </Link>
                    <Link 
                        v-if="!userOrganization"
                        href="/rao/join" 
                        class="flex items-center gap-2 bg-[#008751] text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-[#006b40] transition-all shadow-lg shadow-[#008751]/10"
                    >
                        <PlusCircle class="w-4 h-4" />
                        Inscrire mon ONG
                    </Link>
                </div>
            </div>

            <!-- Stats Grid -->
            <div v-if="$page.props.auth.user.role === 'admin'" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Admin specific stats or same stats -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-[#008751]">
                            <Building2 class="w-6 h-6" />
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">Actif</span>
                    </div>
                    <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                    <div class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-1">Total OSC Approuvées</div>
                </div>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500">
                            <Clock class="w-6 h-6" />
                        </div>
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">Alerte</span>
                    </div>
                    <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.pending_orgs }}</div>
                    <div class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-1">Demandes en attente</div>
                </div>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                            <Users class="w-6 h-6" />
                        </div>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 dark:bg-blue-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">Total</span>
                    </div>
                    <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.total_users }}</div>
                    <div class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-1">Utilisateurs inscrits</div>
                </div>
            </div>

            <div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- User standard stats... -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-[#008751]">
                            <Building2 class="w-6 h-6" />
                        </div>
                    </div>
                    <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                    <div class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-1">Organisations OSC</div>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-500">
                            <CheckCircle2 class="w-6 h-6" />
                        </div>
                    </div>
                    <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.my_orgs }}</div>
                    <div class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-1">Mes organisations</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    <!-- Notifications Section (for both but different content maybe) -->
                    <div v-if="$page.props.auth.notifications && $page.props.auth.notifications.length > 0" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                            <Bell class="w-5 h-5 text-red-500" />
                            Notifications
                        </h2>
                        <div class="space-y-4">
                            <div v-for="notif in $page.props.auth.notifications" :key="notif.id" class="p-4 bg-zinc-50 dark:bg-zinc-800/20 rounded-2xl border border-zinc-100 dark:border-zinc-800 flex items-start gap-4">
                                <div class="h-8 w-8 rounded-full bg-[#008751]/10 flex items-center justify-center text-[#008751] shrink-0">
                                    <Check class="w-4 h-4" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ notif.data.message }}</p>
                                    <p v-if="notif.data.reason" class="text-xs text-red-500 mt-1">Motif: {{ notif.data.reason }}</p>
                                    <p class="text-[10px] text-zinc-400 mt-1 uppercase tracking-widest font-bold">{{ new Date(notif.created_at).toLocaleDateString() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin: Analytics & Validation -->
                    <div v-if="$page.props.auth.user.role === 'admin'" class="space-y-6">
                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-sm">
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-6 uppercase tracking-widest">Répartition par secteur</h3>
                                <div class="h-64">
                                    <StatsChart type="pie" :data="chartData.categories" />
                                </div>
                            </div>
                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-sm">
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-6 uppercase tracking-widest">Tendances d'inscription</h3>
                                <div class="h-64">
                                    <StatsChart type="line" :data="chartData.registrations" />
                                </div>
                            </div>
                        </div>

                        <!-- Validation Area -->
                        <div class="bg-amber-50 dark:bg-amber-500/5 border border-amber-100 dark:border-amber-500/10 rounded-3xl p-8 shadow-sm">
                            <div class="flex items-center justify-between mb-8">
                                <h2 class="text-xl font-bold text-amber-900 dark:text-amber-400">Demandes d'inscription</h2>
                                <span class="text-xs font-bold text-amber-600 bg-amber-100 dark:bg-amber-500/10 px-3 py-1 rounded-full">{{ pendingOrgsList.length }} en attente</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <AdminApprovalCard v-for="org in pendingOrgsList" :key="org.id" :organization="org" />
                            </div>
                            <div v-if="pendingOrgsList.length === 0" class="text-center py-12">
                                <CheckCircle2 class="w-12 h-12 text-amber-200 mx-auto mb-4" />
                                <p class="text-sm text-zinc-500">Toutes les demandes ont été traitées.</p>
                            </div>
                        </div>
                    </div>

                    <!-- User: My Structure -->
                    <div v-if="$page.props.auth.user.role !== 'admin'" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Ma Structure</h2>
                            <Link v-if="userOrganization" :href="`/rao/orga/${userOrganization.slug}`" class="text-xs font-bold text-[#008751] hover:underline">Voir mon profil public</Link>
                        </div>

                        <div v-if="userOrganization" class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="h-24 w-24 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 flex items-center justify-center flex-shrink-0">
                                <Building2 class="w-10 h-10 text-[#008751]" />
                            </div>
                            <div class="flex-grow space-y-6">
                                <div>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-1">{{ userOrganization.name }}</h3>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span :class="['text-[10px] font-bold px-2.5 py-1 rounded-lg tracking-tight transition-all', getStatusClass(userOrganization.status)]">
                                            {{ getStatusLabel(userOrganization.status) }}
                                        </span>
                                        <span class="text-[11px] font-medium text-zinc-400 flex items-center gap-1 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1.5 rounded-lg border border-zinc-200/50 dark:border-zinc-700/50 tracking-tight">
                                            <Globe class="w-3.5 h-3.5" />
                                            {{ userOrganization.city }}, {{ userOrganization.country }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 bg-zinc-50 dark:bg-zinc-800/30 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-bold text-zinc-400 tracking-tight">N° Enregistrement</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ userOrganization.registration_number || 'Non renseigné' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-bold text-zinc-400 tracking-tight">Date de création</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ userOrganization.founded_date || 'Inconnue' }}</p>
                                    </div>
                                </div>
                                <div class="pt-4 flex flex-wrap gap-4">
                                    <button class="bg-zinc-900 dark:bg-zinc-800 text-white px-8 py-3 rounded-xl text-xs font-bold hover:bg-zinc-800 transition-all shadow-lg active:scale-95">Éditer le profil</button>
                                    <button class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 px-8 py-3 rounded-xl text-xs font-bold hover:bg-zinc-50 transition-all active:scale-95">Médiathèque</button>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <div class="h-20 w-20 bg-emerald-50 dark:bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                <PlusCircle class="w-10 h-10 text-[#008751]" />
                            </div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Vous n'avez pas encore d'organisation</h3>
                            <p class="text-sm text-zinc-500 max-w-sm mx-auto mb-8">Rejoignez le réseau RAOSC en inscrivant votre association ou ONG dès aujourd'hui.</p>
                            <Link href="/rao/join" class="bg-[#008751] text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-[#006b40] transition-all shadow-lg shadow-[#008751]/10">Démarrer l'inscription</Link>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Activity/Announcements) -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                            <Globe class="w-5 h-5 text-[#008751]" />
                            Derniers inscrits
                        </h3>
                        <div class="space-y-6">
                            <div v-for="org in recentOrgs" :key="org.id" class="flex items-center gap-4 group cursor-pointer">
                                <div class="h-10 w-10 rounded-lg bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center font-bold text-[#008751] group-hover:bg-[#008751] group-hover:text-white transition-all">
                                    {{ org.name.charAt(0) }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ org.name }}</h4>
                                    <p class="text-[10px] text-zinc-500 uppercase tracking-widest">{{ org.city }}, {{ org.country }}</p>
                                </div>
                                <Link :href="`/rao/orga/${org.slug}`" class="text-zinc-300 group-hover:text-[#008751] transition-all">
                                    <ChevronRight class="w-4 h-4" />
                                </Link>
                            </div>
                        </div>
                        <Link href="/rao" class="block text-center mt-8 pt-6 border-t border-zinc-50 dark:border-zinc-800 text-[10px] font-bold text-zinc-500 hover:text-[#008751] transition-all uppercase tracking-widest">Voir tout l'annuaire</Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
