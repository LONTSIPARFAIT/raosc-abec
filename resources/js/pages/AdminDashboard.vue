<!-- DashboardAdmin.vue - Tableau de Bord Administrateur -->
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
    LayoutDashboard,
    Bell,
    Check,
    PlusCircle,
    Globe,
    ChevronRight,
    TrendingUp,
    Shield,
    Calendar,
    MapPin,
    XCircle,
    Award,
    AlertTriangle,
    BarChart3
} from 'lucide-vue-next';
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
    pendingOrgsList?: Organization[];
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
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'approved': return CheckCircle2;
        case 'pending': return Clock;
        case 'rejected': return XCircle;
        default: return null;
    }
};
</script>

<template>
    <Head title="Tableau de Bord Administrateur" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION -->
            <!-- ============================================ -->
            <div class="sticky top-0 z-30 border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                <div class="container mx-auto px-6 lg:px-12 py-5">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                        
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="h-10 w-10 rounded-xl bg-raosc-green/10 flex items-center justify-center">
                                    <LayoutDashboard class="h-5 w-5 text-raosc-green" />
                                </div>
                                <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">
                                    Bonjour, {{ $page.props.auth.user.name }}
                                </h1>
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400">
                                    Administrateur
                                </span>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 ml-13">
                                Bienvenue sur votre espace d'administration. Gérez l'ensemble du réseau RAOSC.
                            </p>
                        </div>
                        
                        <Link 
                            href="/rao" 
                            class="inline-flex items-center gap-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all hover:scale-105"
                        >
                            <Search class="w-4 h-4 text-zinc-400" />
                            Gérer Annuaire
                        </Link>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU PRINCIPAL -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-8">
                
                <!-- ============================================ -->
                <!-- STATS CARDS - 4 COLONNES -->
                <!-- ============================================ -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    
                    <!-- OSC approuvées -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center">
                                <Building2 class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-500/20 px-2 py-1 rounded-full">Actif</span>
                        </div>
                        <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">OSC approuvées</div>
                    </div>

                    <!-- Demandes en attente (cliquable) -->
                    <Link href="/admin/organizations" class="group bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-raosc-green/50 transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all">
                                <Clock class="w-5 h-5 text-amber-600 dark:text-amber-400 group-hover:text-white" />
                            </div>
                            <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-500/20 px-2 py-1 rounded-full group-hover:bg-amber-500 group-hover:text-white transition-all">Alerte</span>
                        </div>
                        <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.pending_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Demandes en attente</div>
                    </Link>

                    <!-- Utilisateurs inscrits -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                                <Users class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-500/20 px-2 py-1 rounded-full">Total</span>
                        </div>
                        <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.total_users }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Utilisateurs inscrits</div>
                    </div>

                    <!-- Mes organisations -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                                <Award class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                            </div>
                        </div>
                        <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.my_orgs || 0 }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Mes organisations</div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- GRILLE PRINCIPALE - 2 COLONNES (8/4) -->
                <!-- ============================================ -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- ============================================ -->
                    <!-- COLONNE GAUCHE (8/12) -->
                    <!-- ============================================ -->
                    <div class="lg:col-span-8 space-y-8">
                        
                        <!-- Section Notifications -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <Bell class="h-5 w-5 text-zinc-500" />
                                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Notifications</h2>
                                    <span v-if="$page.props.auth.notifications?.length" class="px-2 py-0.5 text-xs font-bold bg-raosc-red text-white rounded-full">
                                        {{ $page.props.auth.notifications.length }}
                                    </span>
                                </div>
                                <Link href="/dashboard/notifications" class="text-xs font-semibold text-raosc-green hover:underline">Voir tout</Link>
                            </div>
                            
                            <div class="p-6">
                                <div v-if="$page.props.auth.notifications && $page.props.auth.notifications.length > 0" class="space-y-3">
                                    <div v-for="notif in $page.props.auth.notifications.slice(0, 4)" :key="notif.id" 
                                         class="p-4 bg-zinc-50 dark:bg-zinc-800/30 rounded-xl border border-zinc-100 dark:border-zinc-700 flex items-start gap-3 transition-all hover:shadow-sm"
                                         :class="{ 'border-l-4 border-l-raosc-green': !notif.read_at }">
                                        <div class="h-8 w-8 rounded-full flex items-center justify-center shrink-0"
                                             :class="!notif.read_at ? 'bg-raosc-green/10 text-raosc-green' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500'">
                                            <component :is="getStatusIcon(notif.data.status) || Check" class="w-4 h-4" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium" :class="!notif.read_at ? 'text-raosc-green' : 'text-zinc-900 dark:text-white'">
                                                {{ notif.data.message }}
                                            </p>
                                            <p v-if="notif.data.reason" class="text-xs text-red-500 mt-1">{{ notif.data.reason }}</p>
                                            <p class="text-[10px] text-zinc-400 mt-1 font-medium">
                                                {{ new Date(notif.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                                            </p>
                                        </div>
                                        <div v-if="!notif.read_at" class="h-2 w-2 rounded-full bg-raosc-green animate-pulse"></div>
                                    </div>
                                </div>
                                <div v-else class="text-center py-10">
                                    <Bell class="h-12 w-12 text-zinc-300 dark:text-zinc-600 mx-auto mb-3" />
                                    <p class="text-sm text-zinc-500">Vous n'avez pas de notifications récentes.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Graphiques Analytics -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                    <BarChart3 class="w-4 h-4 text-raosc-green" />
                                    Répartition par secteur
                                </h3>
                                <div class="h-64">
                                    <StatsChart type="pie" :data="chartData.categories" />
                                </div>
                            </div>
                            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                    <TrendingUp class="w-4 h-4 text-raosc-green" />
                                    Tendances d'inscription
                                </h3>
                                <div class="h-64">
                                    <StatsChart type="line" :data="chartData.registrations" />
                                </div>
                            </div>
                        </div>

                        <!-- Actions rapides Admin -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                            <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                <Shield class="w-4 h-4 text-raosc-green" />
                                Actions rapides
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <Link href="/admin/users" class="group flex flex-col items-center gap-2 p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800 hover:bg-raosc-green/10 transition-all hover:scale-105">
                                    <div class="h-10 w-10 rounded-full bg-white dark:bg-zinc-700 flex items-center justify-center text-zinc-600 group-hover:bg-raosc-green group-hover:text-white transition-all">
                                        <Users class="w-5 h-5" />
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Utilisateurs</span>
                                </Link>
                                <Link href="/admin/categories" class="group flex flex-col items-center gap-2 p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800 hover:bg-raosc-green/10 transition-all hover:scale-105">
                                    <div class="h-10 w-10 rounded-full bg-white dark:bg-zinc-700 flex items-center justify-center text-zinc-600 group-hover:bg-raosc-green group-hover:text-white transition-all">
                                        <FileText class="w-5 h-5" />
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Catégories</span>
                                </Link>
                                <Link href="/admin/coming-soon" class="group flex flex-col items-center gap-2 p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800 hover:bg-raosc-green/10 transition-all hover:scale-105">
                                    <div class="h-10 w-10 rounded-full bg-white dark:bg-zinc-700 flex items-center justify-center text-zinc-600 group-hover:bg-raosc-green group-hover:text-white transition-all">
                                        <Download class="w-5 h-5" />
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Exporter</span>
                                </Link>
                                <Link href="/admin/settings" class="group flex flex-col items-center gap-2 p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800 hover:bg-raosc-green/10 transition-all hover:scale-105">
                                    <div class="h-10 w-10 rounded-full bg-white dark:bg-zinc-700 flex items-center justify-center text-zinc-600 group-hover:bg-raosc-green group-hover:text-white transition-all">
                                        <Settings class="w-5 h-5" />
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Paramètres</span>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- COLONNE DROITE (4/12) - SIDEBAR -->
                    <!-- ============================================ -->
                    <div class="lg:col-span-4 space-y-6">
                        
                        <!-- Demandes en attente (liste) -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-5">
                                <AlertTriangle class="h-5 w-5 text-amber-500" />
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Demandes en attente</h3>
                            </div>
                            <div class="space-y-4">
                                <div v-for="org in pendingOrgsList?.slice(0, 5)" :key="org.id" class="flex items-center gap-3 group">
                                    <div class="h-9 w-9 rounded-lg bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center font-bold text-amber-600 text-sm">
                                        {{ org.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-white truncate">{{ org.name }}</h4>
                                        <p class="text-[10px] text-zinc-500">{{ org.city }}, {{ org.country }}</p>
                                    </div>
                                    <Link href="/admin/organizations" class="text-zinc-300 group-hover:text-raosc-green transition-all">
                                        <ChevronRight class="w-4 h-4" />
                                    </Link>
                                </div>
                                <div v-if="!pendingOrgsList?.length" class="text-center py-6">
                                    <CheckCircle2 class="h-10 w-10 text-emerald-500 mx-auto mb-2" />
                                    <p class="text-sm text-zinc-500">Aucune demande en attente</p>
                                </div>
                            </div>
                            <Link href="/admin/organizations" class="block text-center mt-5 pt-4 border-t border-zinc-100 dark:border-zinc-800 text-xs font-semibold text-zinc-500 hover:text-raosc-green transition-colors">
                                Voir toutes les demandes →
                            </Link>
                        </div>

                        <!-- Derniers inscrits -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-5">
                                <Globe class="h-5 w-5 text-raosc-green" />
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Derniers inscrits</h3>
                            </div>
                            <div class="space-y-4">
                                <div v-for="org in recentOrgs.slice(0, 5)" :key="org.id" class="flex items-center gap-3 group">
                                    <div class="h-9 w-9 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center font-bold text-raosc-green text-sm group-hover:bg-raosc-green group-hover:text-white transition-all">
                                        {{ org.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-white truncate">{{ org.name }}</h4>
                                        <p class="text-[10px] text-zinc-500">{{ org.city }}, {{ org.country }}</p>
                                    </div>
                                    <Link :href="`/rao/orga/${org.slug}`" class="text-zinc-300 group-hover:text-raosc-green transition-all hover:translate-x-0.5">
                                        <ChevronRight class="w-4 h-4" />
                                    </Link>
                                </div>
                            </div>
                            <Link href="/rao" class="block text-center mt-5 pt-4 border-t border-zinc-100 dark:border-zinc-800 text-xs font-semibold text-zinc-500 hover:text-raosc-green transition-colors">
                                Voir tout l'annuaire →
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>