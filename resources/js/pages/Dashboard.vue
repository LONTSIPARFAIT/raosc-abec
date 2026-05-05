<!-- DashboardUser.vue - Tableau de Bord Membre -->
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Bell,
    Building2, 
    Check,
    CheckCircle2, 
    Globe, 
    PlusCircle, 
    Search,
    ChevronRight,
    MapPin,
    Calendar,
    FileText,
    Clock,
    Award,
    AlertCircle,
    XCircle,
    Edit
} from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

interface Stats {
    total_orgs: number;
    pending_orgs: number;
    total_users: number;
    my_orgs: number;
    rejected_orgs: number;
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
    logo?: string;
}

defineProps<{
    stats: Stats;
    userOrganization: Organization | null;
    recentOrgs: Organization[];
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
        default: return null;
    }
};
</script>

<template>
    <Head title="Tableau de Bord" />

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
                                    <Building2 class="h-5 w-5 text-raosc-green" />
                                </div>
                                <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">
                                    Bonjour, {{ $page.props.auth.user.name }}
                                </h1>
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-raosc-green/10 text-raosc-green">
                                    Membre
                                </span>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 ml-13">
                                Bienvenue sur votre espace RAOSC. Gérez vos organisations et suivez l'activité du réseau.
                            </p>
                        </div>
                        
                        <div class="flex gap-3">
                            <Link 
                                href="/rao" 
                                class="inline-flex items-center gap-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all hover:scale-105"
                            >
                                <Search class="w-4 h-4 text-zinc-400" />
                                Annuaire
                            </Link>
                            <Link 
                                v-if="!userOrganization"
                                href="/rao/join" 
                                class="inline-flex items-center gap-2 bg-raosc-green text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-raosc-green/90 transition-all hover:scale-105 shadow-sm"
                            >
                                <PlusCircle class="w-4 h-4" />
                                Inscrire mon OSC
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- ALERTE REJET (ATTENTION) -->
            <!-- ============================================ -->
            <div v-if="stats.rejected_orgs > 0" class="container mx-auto px-6 lg:px-12 pt-8">
                <div class="relative overflow-hidden bg-white dark:bg-zinc-900 border-2 border-red-500/30 rounded-3xl p-6 shadow-xl shadow-red-500/10">
                    <!-- Décoration -->
                    <div class="absolute -right-4 -top-4 opacity-5">
                        <XCircle class="w-32 h-32 text-red-600" />
                    </div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                        <div class="h-16 w-16 rounded-2xl bg-red-100 dark:bg-red-950/50 flex items-center justify-center shrink-0 animate-pulse">
                            <AlertCircle class="h-8 w-8 text-red-600" />
                        </div>
                        
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-xl font-black text-red-700 dark:text-red-400 mb-1">
                                Action requise : {{ stats.rejected_orgs }} demande(s) rejetée(s)
                            </h2>
                            <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed max-w-2xl">
                                L'administration a examiné vos demandes d'inscription et certaines nécessitent des corrections avant d'être validées. Veuillez consulter les motifs de rejet pour soumettre à nouveau vos informations.
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                            <Link 
                                href="/rao/my-organizations" 
                                class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-sm font-bold shadow-lg shadow-red-600/20 transition-all hover:scale-105"
                            >
                                <Edit class="w-4 h-4" />
                                Voir et Corriger
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU PRINCIPAL -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-8">
                
                <!-- ============================================ -->
                <!-- STATS CARDS - 2 COLONNES -->
                <!-- ============================================ -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                    
                    <!-- OSC référencées -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center">
                                <Building2 class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                        </div>
                        <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.total_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">OSC référencées</div>
                    </div>

                    <!-- Mes organisations -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-11 w-11 rounded-xl bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                                <CheckCircle2 class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                            </div>
                        </div>
                        <div class="text-3xl font-black text-zinc-900 dark:text-white">{{ stats.my_orgs }}</div>
                        <div class="text-xs font-medium text-zinc-400 uppercase tracking-wide mt-1">Mes organisations</div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- GRILLE PRINCIPALE - 2 COLONNES -->
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

                        <!-- Section Ma Structure -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <Building2 class="h-5 w-5 text-raosc-green" />
                                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ma structure</h2>
                                </div>
                                <Link v-if="userOrganization" :href="`/rao/orga/${userOrganization.slug}`" class="text-xs font-semibold text-raosc-green hover:underline">
                                    Voir profil public
                                </Link>
                            </div>
                            
                            <div class="p-6">
                                <div v-if="userOrganization" class="flex flex-col md:flex-row gap-6">
                                    <div class="h-24 w-24 rounded-xl bg-gradient-to-br from-raosc-green/10 to-raosc-yellow/10 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center flex-shrink-0">
                                        <img v-if="userOrganization.logo" :src="userOrganization.logo" class="h-full w-full object-cover rounded-xl" />
                                        <Building2 v-else class="w-10 h-10 text-raosc-green" />
                                    </div>
                                    <div class="flex-1 space-y-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">{{ userOrganization.name }}</h3>
                                            <div class="flex flex-wrap items-center gap-3">
                                                <span :class="['inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full', getStatusClass(userOrganization.status)]">
                                                    <component :is="getStatusIcon(userOrganization.status)" v-if="getStatusIcon(userOrganization.status)" class="w-3 h-3" />
                                                    {{ getStatusLabel(userOrganization.status) }}
                                                </span>
                                                <span class="text-[10px] font-medium text-zinc-500 flex items-center gap-1 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-full">
                                                    <MapPin class="w-3 h-3" />
                                                    {{ userOrganization.city }}, {{ userOrganization.country }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-zinc-50 dark:bg-zinc-800/30 rounded-xl border border-zinc-100 dark:border-zinc-700">
                                            <div>
                                                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">N° Enregistrement</p>
                                                <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ userOrganization.registration_number || 'Non renseigné' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Date de création</p>
                                                <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ userOrganization.founded_date || 'Inconnue' }}</p>
                                            </div>
                                        </div>

                                        <div v-if="userOrganization.status === 'rejected' && userOrganization.rejection_reason" class="mb-4 p-4 bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-900 rounded-xl">
                                            <p class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                                <AlertCircle class="w-3.5 h-3.5" /> Motif du rejet :
                                            </p>
                                            <p class="text-sm text-red-700 dark:text-red-300 italic leading-relaxed">
                                                "{{ userOrganization.rejection_reason }}"
                                            </p>
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-3 pt-2">
                                            <Link 
                                                :href="`/rao/orga/${userOrganization.slug}/edit`" 
                                                :class="[
                                                    'px-5 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105 shadow-sm',
                                                    userOrganization.status === 'rejected' 
                                                        ? 'bg-raosc-green text-white hover:bg-raosc-green/90' 
                                                        : 'bg-raosc-green text-white hover:bg-raosc-green/90'
                                                ]"
                                            >
                                                {{ userOrganization.status === 'rejected' ? 'Corriger & Renvoyer' : 'Éditer le profil' }}
                                            </Link>
                                            <Link v-if="userOrganization.status === 'approved'" :href="`/dashboard/projects`" class="bg-indigo-600 dark:bg-indigo-500 text-white px-5 py-2 rounded-xl text-xs font-semibold hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-all hover:scale-105 shadow-sm">
                                                Gérer Projets
                                            </Link>
                                            <button class="border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 px-5 py-2 rounded-xl text-xs font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all">
                                                Médiathèque
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="text-center py-10">
                                    <div class="h-20 w-20 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <PlusCircle class="w-10 h-10 text-raosc-green" />
                                    </div>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Vous n'avez pas encore d'organisation</h3>
                                    <p class="text-sm text-zinc-500 max-w-sm mx-auto mb-6">Rejoignez le réseau RAOSC en inscrivant votre association ou ONG dès aujourd'hui.</p>
                                    <Link href="/rao/join" class="inline-flex items-center gap-2 bg-raosc-green text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-raosc-green/90 transition-all hover:scale-105 shadow-sm">
                                        Démarrer l'inscription
                                        <ChevronRight class="w-4 h-4" />
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- COLONNE DROITE (4/12) - SIDEBAR -->
                    <!-- ============================================ -->
                    <div class="lg:col-span-4 space-y-6">
                        
                        <!-- Derniers inscrits -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-5">
                                <Globe class="h-5 w-5 text-raosc-green" />
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Derniers inscrits</h3>
                            </div>
                            <div class="space-y-4">
                                <div v-for="org in recentOrgs.slice(0, 5)" :key="org.id" class="flex items-center gap-3 group">
                                    <div class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center font-bold text-raosc-green text-sm group-hover:bg-raosc-green group-hover:text-white transition-all">
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

                        <!-- Section Aide / Support -->
                        <div class="bg-gradient-to-br from-raosc-green/10 to-raosc-yellow/10 rounded-2xl p-6 border border-raosc-green/20 shadow-sm">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="h-10 w-10 rounded-xl bg-raosc-green/20 flex items-center justify-center">
                                    <HelpCircle class="h-5 w-5 text-raosc-green" />
                                </div>
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Besoin d'aide ?</h3>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                                Notre équipe est là pour vous accompagner dans l'utilisation de la plateforme et la gestion de votre organisation.
                            </p>
                            <Link href="/contact" class="inline-flex items-center gap-2 text-raosc-green font-semibold text-sm hover:gap-3 transition-all">
                                Contacter le support
                                <ChevronRight class="w-4 h-4" />
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