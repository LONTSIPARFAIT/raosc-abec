<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { Users, Shield, Trash2, ShieldAlert, BadgeInfo } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';

defineProps<{
    users: any;
}>();

const breadcrumbs = [
    { title: 'Tableau de Bord', href: dashboard() },
    { title: 'Utilisateurs', href: '/admin/users' },
];

const updateRole = (userId: number, currentRole: string) => {
    const newRole = currentRole === 'admin' ? 'user' : 'admin';
    router.put(`/admin/users/${userId}/role`, { role: newRole }, { preserveScroll: true });
};

const deleteUser = (userId: number) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur définitivement ? (Cela supprimera également ses données liées)")) {
        router.delete(`/admin/users/${userId}`, { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Gestion des Utilisateurs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600">
                        <Users class="w-5 h-5" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Utilisateurs</h1>
                        <p class="text-xs text-zinc-500">Gérez les comptes et les droits d'accès</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 text-xs text-zinc-500 uppercase tracking-widest font-bold">
                                <th class="px-6 py-4">Nom</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Rôle</th>
                                <th class="px-6 py-4">Date d'inscription</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tr v-for="user in users.data" :key="user.id" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 font-bold text-zinc-700 dark:text-zinc-300 flex items-center justify-center text-xs">
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
                                        <ShieldAlert class="w-3 h-3" /> Admin
                                    </span>
                                    <span v-else class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                        <BadgeInfo class="w-3 h-3" /> Utilisateur
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-zinc-500">
                                    {{ new Date(user.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 flex items-center justify-end gap-2">
                                    <button 
                                        @click="updateRole(user.id, user.role)"
                                        class="p-2 rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-400 transition"
                                        title="Changer le rôle"
                                    >
                                        <Shield class="w-4 h-4" />
                                    </button>
                                    <button 
                                        @click="deleteUser(user.id)"
                                        class="p-2 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 text-red-600 transition"
                                        title="Supprimer"
                                        :disabled="user.id === $page.props.auth.user.id"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination simple -->
                <div v-if="users.links && users.links.length > 3" class="p-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-center gap-2">
                    <Component 
                        :is="link.url ? 'Link' : 'span'"
                        v-for="(link, i) in users.links" 
                        :key="i"
                        :href="link.url"
                        v-html="link.label"
                        class="px-3 py-1 text-xs font-semibold rounded-lg border transition-all"
                        :class="[
                            link.active ? 'bg-raosc-green text-white border-raosc-green' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
