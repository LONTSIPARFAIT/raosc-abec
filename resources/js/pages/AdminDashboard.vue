<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Building2, 
    CheckCircle2, 
    Clock, 
    Search,
    Users,
    Settings,
    Download,
    FileText,
    ShieldAlert,
    LayoutDashboard,
    Bell,
    Check,
    PlusCircle,
    Globe,
    ChevronRight
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
    <Head title="Tableau de Bord Administrateur" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">
            
            <!-- Header Welcome -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="h-8 w-8 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                            <LayoutDashboard class="h-5 w-5" />
                        </div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Bonjour, {{ $page.props.auth.user.name }} 👋</h1>
                    </div>
                    <p class="text-sm text-zinc-500 ml-10">Bienvenue sur votre espace RAOSC. Voici un aperçu de l'activité.</p>
                </div>
                <div class="flex gap-3">
                    <Link 
                        href="/rao" 
                        class="inline-flex items-center gap-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 px-4 py-2 rounded-full text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                    >
                        <Search class="w-4 h-4 text-zinc-400" />
                        Gérer Annuaire
                    </Link>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Admin specific stats -->
                <template v-if="$page.props.auth.user.role === 'admin'">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-raosc-green">
                                <Building2 class="w-5 h-5" />
                            </div>
                            <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-full">Actif</span>
                        </div>
                        <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">OSC approuvées</div>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500">
                                <Clock class="w-5 h-5" />
                            </div>
                            <span class="text-[10px] font-semibold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 px-2 py-1 rounded-full">Alerte</span>
                        </div>
                        <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ stats.pending_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Demandes en attente</div>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                                <Users class="w-5 h-5" />
                            </div>
                            <span class="text-[10px] font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 px-2 py-1 rounded-full">Total</span>
                        </div>
                        <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ stats.total_users }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Utilisateurs inscrits</div>
                    </div>
                </template>

                <!-- User standard stats -->
                <template v-else>
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-raosc-green">
                                <Building2 class="w-5 h-5" />
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">OSC référencées</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-500">
                                <CheckCircle2 class="w-5 h-5" />
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ stats.my_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Mes organisations</div>
                    </div>
                </template>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Notifications Section -->
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2">
                                <Bell class="h-5 w-5 text-zinc-500" />
                                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Notifications</h2>
                            </div>
                            <Link href="/dashboard/notifications" class="text-xs font-semibold text-raosc-green hover:underline">Voir tout</Link>
                        </div>
                        <div v-if="$page.props.auth.notifications && $page.props.auth.notifications.length > 0" class="space-y-3">
                            <div v-for="notif in $page.props.auth.notifications.slice(0, 3)" :key="notif.id" 
                                 class="p-4 bg-zinc-50 dark:bg-zinc-800/20 rounded-xl border border-zinc-100 dark:border-zinc-800 flex items-start gap-3"
                                 :class="{ 'bg-emerald-50/50 dark:bg-emerald-900/10': !notif.read_at }">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center shrink-0"
                                     :class="!notif.read_at ? 'bg-raosc-green/10 text-raosc-green' : 'bg-zinc-200 dark:bg-zinc-800 text-zinc-500'">
                                    <Check class="w-4 h-4" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white" :class="!notif.read_at ? 'text-raosc-green' : ''">{{ notif.data.message }}</p>
                                    <p v-if="notif.data.reason" class="text-xs text-red-500 mt-1 truncate">Motif: {{ notif.data.reason }}</p>
                                    <p class="text-[10px] text-zinc-400 mt-1 font-medium">{{ new Date(notif.created_at).toLocaleDateString() }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-6 text-zinc-500">
                            <p class="text-sm">Vous n'avez pas de notifications récentes.</p>
                        </div>
                    </div>

                    <!-- Admin: Analytics & Validation -->
                    <div v-if="$page.props.auth.user.role === 'admin'" class="space-y-6">
                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                    <LayoutDashboard class="w-4 h-4 text-zinc-400" />
                                    Répartition par secteur
                                </h3>
                                <div class="h-64">
                                    <StatsChart type="pie" :data="chartData.categories" />
                                </div>
                            </div>
                            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                    <Clock class="w-4 h-4 text-zinc-400" />
                                    Tendances d'inscription
                                </h3>
                                <div class="h-64">
                                    <StatsChart type="line" :data="chartData.registrations" />
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <Link href="/admin/users" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-raosc-green/50 p-4 rounded-2xl flex flex-col items-center gap-3 transition-all group">
                                <div class="h-10 w-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 group-hover:bg-raosc-green/10 group-hover:text-raosc-green transition-colors">
                                    <Users class="w-5 h-5" />
                                </div>
                                <span class="text-xs font-semibold text-zinc-900 dark:text-white text-center">Utilisateurs</span>
                            </Link>
                            <Link href="/admin/coming-soon" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-raosc-green/50 p-4 rounded-2xl flex flex-col items-center gap-3 transition-all group">
                                <div class="h-10 w-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 group-hover:bg-raosc-green/10 group-hover:text-raosc-green transition-colors">
                                    <FileText class="w-5 h-5" />
                                </div>
                                <span class="text-xs font-semibold text-zinc-900 dark:text-white text-center">Catégories</span>
                            </Link>
                            <Link href="/admin/coming-soon" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-raosc-green/50 p-4 rounded-2xl flex flex-col items-center gap-3 transition-all group">
                                <div class="h-10 w-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 group-hover:bg-raosc-green/10 group-hover:text-raosc-green transition-colors">
                                    <Download class="w-5 h-5" />
                                </div>
                                <span class="text-xs font-semibold text-zinc-900 dark:text-white text-center">Exporter</span>
                            </Link>
                            <Link href="/admin/settings" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-raosc-green/50 p-4 rounded-2xl flex flex-col items-center gap-3 transition-all group">
                                <div class="h-10 w-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 group-hover:bg-raosc-green/10 group-hover:text-raosc-green transition-colors">
                                    <Settings class="w-5 h-5" />
                                </div>
                                <span class="text-xs font-semibold text-zinc-900 dark:text-white text-center">Paramètres</span>
                            </Link>
                        </div>

                        <!-- Validation Area -->
                        <div class="bg-amber-50 dark:bg-amber-500/5 border border-amber-100 dark:border-amber-500/10 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-2">
                                    <ShieldAlert class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                                    <h2 class="text-lg font-bold text-amber-900 dark:text-amber-400">Demandes en attente</h2>
                                </div>
                                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-500/10 px-2.5 py-1 rounded-full">{{ pendingOrgsList.length }}</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <AdminApprovalCard v-for="org in pendingOrgsList" :key="org.id" :organization="org" />
                            </div>
                            <div v-if="pendingOrgsList.length === 0" class="text-center py-10">
                                <CheckCircle2 class="w-12 h-12 text-amber-200 mx-auto mb-3" />
                                <p class="text-sm text-zinc-500">Toutes les demandes ont été traitées.</p>
                            </div>
                        </div>
                    </div>

                    <!-- User: My Structure -->
                    <div v-if="$page.props.auth.user.role !== 'admin'" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <Building2 class="h-5 w-5 text-raosc-green" />
                                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ma Structure</h2>
                            </div>
                            <Link v-if="userOrganization" :href="`/rao/orga/${userOrganization.slug}`" class="text-xs font-semibold text-raosc-green hover:underline">Voir profil public</Link>
                        </div>

                        <div v-if="userOrganization" class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="h-20 w-20 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 flex items-center justify-center flex-shrink-0">
                                <Building2 class="w-8 h-8 text-raosc-green" />
                            </div>
                            <div class="flex-1 space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-1">{{ userOrganization.name }}</h3>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span :class="['text-[10px] font-semibold px-2.5 py-1 rounded-full', getStatusClass(userOrganization.status)]">
                                            {{ getStatusLabel(userOrganization.status) }}
                                        </span>
                                        <span class="text-[10px] font-medium text-zinc-500 flex items-center gap-1 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-full">
                                            <Globe class="w-3 h-3" />
                                            {{ userOrganization.city }}, {{ userOrganization.country }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-zinc-50 dark:bg-zinc-800/30 rounded-xl border border-zinc-100 dark:border-zinc-800">
                                    <div>
                                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">N° Enregistrement</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ userOrganization.registration_number || 'Non renseigné' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Date de création</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ userOrganization.founded_date || 'Inconnue' }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-3 pt-2">
                                    <Link :href="`/rao/orga/${userOrganization.slug}/edit`" class="bg-raosc-green text-white px-6 py-2.5 rounded-xl text-xs font-semibold hover:bg-raosc-green/90 transition-colors shadow-sm">
                                        Éditer le profil
                                    </Link>
                                    <button class="border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 px-6 py-2.5 rounded-xl text-xs font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                                        Médiathèque
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-10">
                            <div class="h-16 w-16 bg-emerald-50 dark:bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <PlusCircle class="w-8 h-8 text-raosc-green" />
                            </div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Vous n'avez pas encore d'organisation</h3>
                            <p class="text-sm text-zinc-500 max-w-sm mx-auto mb-6">Rejoignez le réseau RAOSC en inscrivant votre association ou ONG dès aujourd'hui.</p>
                            <Link href="/rao/join" class="inline-flex items-center gap-2 bg-raosc-green text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-raosc-green/90 transition-colors shadow-sm">
                                Démarrer l'inscription
                                <ChevronRight class="w-4 h-4" />
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Recent organizations) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-5">
                            <Globe class="h-5 w-5 text-raosc-green" />
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Derniers inscrits</h3>
                        </div>
                        <div class="space-y-5">
                            <div v-for="org in recentOrgs" :key="org.id" class="flex items-center gap-3 group">
                                <div class="h-9 w-9 rounded-lg bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center font-bold text-raosc-green text-sm group-hover:bg-raosc-green group-hover:text-white transition-colors">
                                    {{ org.name.charAt(0).toUpperCase() }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-zinc-900 dark:text-white truncate">{{ org.name }}</h4>
                                    <p class="text-[10px] text-zinc-500 uppercase tracking-wide">{{ org.city }}, {{ org.country }}</p>
                                </div>
                                <Link :href="`/rao/orga/${org.slug}`" class="text-zinc-300 group-hover:text-raosc-green transition-colors">
                                    <ChevronRight class="w-4 h-4" />
                                </Link>
                            </div>
                        </div>
                        <Link href="/rao" class="block text-center mt-6 pt-5 border-t border-zinc-100 dark:border-zinc-800 text-xs font-semibold text-zinc-500 hover:text-raosc-green transition-colors">
                            Voir tout l'annuaire
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>