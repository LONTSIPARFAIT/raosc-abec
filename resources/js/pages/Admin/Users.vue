<!-- AdminUsers.vue - Gestion des Utilisateurs -->
<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { Users, Shield, Trash2, ShieldAlert, BadgeInfo, Search, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { ref, computed } from 'vue';

const props = defineProps<{
    users: {
        data: any[];
        current_page: number;
        last_page: number;
        links: { url: string | null; label: string; active: boolean }[];
    };
}>();

const breadcrumbs = [
    { title: 'Tableau de Bord', href: dashboard() },
    { title: 'Utilisateurs', href: '/admin/users' },
];

const searchQuery = ref('');

const filteredUsers = computed(() => {
    if (!searchQuery.value) return props.users.data;
    return props.users.data.filter(user =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const updateRole = (userId: number, currentRole: string) => {
    const newRole = currentRole === 'admin' ? 'user' : 'admin';
    router.put(`/admin/users/${userId}/role`, { role: newRole }, { preserveScroll: true });
};

const deleteUser = (userId: number) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur définitivement ? (Cela supprimera également ses données liées)")) {
        router.delete(`/admin/users/${userId}`, { preserveScroll: true });
    }
};

const formatLabel = (label: string) => {
    return label
        .replace('&laquo;', '«')
        .replace('&raquo;', '»')
        .replace('Previous', '‹')
        .replace('Next', '›');
};
</script>

<template>
    <Head title="Gestion des Utilisateurs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION -->
            <!-- ============================================ -->
            <div class="sticky top-0 z-30 border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                <div class="container mx-auto px-6 lg:px-12 py-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                                <Users class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">Gestion des Utilisateurs</h1>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Gérez les comptes et les droits d'accès des utilisateurs</p>
                            </div>
                        </div>
                        
                        <div class="relative w-full lg:w-80">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" />
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Rechercher un utilisateur..."
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
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800">
                        <div class="text-2xl font-black text-zinc-900 dark:text-white">{{ users.data.length }}</div>
                        <div class="text-xs text-zinc-500">Utilisateurs total</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800">
                        <div class="text-2xl font-black text-purple-600">{{ users.data.filter(u => u.role === 'admin').length }}</div>
                        <div class="text-xs text-zinc-500">Administrateurs</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-xl p-4 border border-zinc-200 dark:border-zinc-800">
                        <div class="text-2xl font-black text-emerald-600">{{ users.data.filter(u => u.role === 'user').length }}</div>
                        <div class="text-xs text-zinc-500">Utilisateurs standards</div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- TABLEAU DES UTILISATEURS -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-6 pb-16">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 text-xs text-zinc-500 uppercase tracking-wider font-bold">
                                    <th class="px-6 py-4">Utilisateur</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Rôle</th>
                                    <th class="px-6 py-4">Date d'inscription</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-raosc-green to-raosc-yellow flex items-center justify-center text-white font-bold text-sm">
                                                {{ user.name.charAt(0).toUpperCase() }}
                                            </div>
                                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ user.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span v-if="user.role === 'admin'" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <ShieldAlert class="w-3 h-3" /> Administrateur
                                        </span>
                                        <span v-else class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                            <BadgeInfo class="w-3 h-3" /> Utilisateur
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-zinc-500">
                                        {{ new Date(user.created_at).toLocaleDateString('fr-FR') }}
                                     </td>
                                    <td class="px-6 py-4 flex items-center justify-end gap-2">
                                        <button 
                                            @click="updateRole(user.id, user.role)"
                                            class="p-2 rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-400 transition hover:scale-105"
                                            :title="user.role === 'admin' ? 'Rétrograder en utilisateur' : 'Promouvoir administrateur'"
                                        >
                                            <Shield class="w-4 h-4" />
                                        </button>
                                        <button 
                                            @click="deleteUser(user.id)"
                                            class="p-2 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 text-red-600 transition hover:scale-105"
                                            title="Supprimer"
                                            :disabled="user.id === $page.props.auth.user.id"
                                        >
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                     </td>
                                 </tr>
                                <tr v-if="filteredUsers.length === 0">
                                    <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                        <Users class="h-10 w-10 mx-auto mb-3 text-zinc-300" />
                                        Aucun utilisateur trouvé
                                     </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div v-if="users.links && users.links.length > 3" class="p-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-center gap-2">
                        <Link 
                            v-for="(link, i) in users.links" 
                            :key="i"
                            :href="link.url"
                            class="min-w-[36px] h-9 px-3 rounded-lg text-sm font-medium transition-all flex items-center justify-center"
                            :class="[
                                link.active ? 'bg-raosc-green text-white shadow-md' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:scale-105',
                                !link.url ? 'opacity-50 cursor-not-allowed' : ''
                            ]"
                        >
                            <span v-if="link.label === 'Previous'"><ChevronLeft class="w-4 h-4" /></span>
                            <span v-else-if="link.label === 'Next'"><ChevronRight class="w-4 h-4" /></span>
                            <span v-else>{{ formatLabel(link.label) }}</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>