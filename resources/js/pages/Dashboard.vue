<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Bell,
    Building2, 
    Check,
    CheckCircle2, 
    Globe, 
    PlusCircle, 
    Search
} from 'lucide-vue-next';
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
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">
            
            <!-- Header Welcome -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="h-8 w-8 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                            <Building2 class="h-5 w-5" />
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
                        Annuaire
                    </Link>
                    <Link 
                        v-if="!userOrganization"
                        href="/rao/join" 
                        class="inline-flex items-center gap-2 bg-raosc-green text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-raosc-green/90 transition-colors shadow-sm"
                    >
                        <PlusCircle class="w-4 h-4" />
                        Inscrire mon ONG
                    </Link>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="h-11 w-11 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-raosc-green">
                            <Building2 class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                    <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Organisations OSC</div>
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
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Notifications Section -->
                <div class="lg:w-1/2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
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

                <!-- My Structure Section -->
                <div class="lg:w-1/2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2">
                            <Building2 class="h-5 w-5 text-raosc-green" />
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Aperçu de vos structures</h2>
                        </div>
                        <div class="flex gap-4">
                            <Link v-if="userOrganization" :href="`/rao/orga/${userOrganization.slug}`" class="text-xs font-semibold text-raosc-green hover:underline">Voir profil public</Link>
                            <Link href="/rao/mes-structures" class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:text-raosc-green transition-colors">Gérer tout</Link>
                        </div>
                    </div>

                    <div v-if="userOrganization" class="flex flex-col sm:flex-row gap-5 items-start">
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
                                <Link :href="`/dashboard/projects`" class="bg-indigo-600 dark:bg-indigo-500 text-white px-6 py-2.5 rounded-xl text-xs font-semibold hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors shadow-sm">
                                    Gérer Projets & Bénévolat
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
                            <PlusCircle class="w-4 h-4" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>