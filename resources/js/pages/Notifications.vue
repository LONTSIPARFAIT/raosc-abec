<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Bell, Check, CheckCircle2, Clock } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps<{
    notificationsList: any[];
}>();

const markAsRead = (id: string) => {
    router.put(`/dashboard/notifications/${id}/read`, {}, { preserveScroll: true });
};

const markAllAsRead = () => {
    router.put('/dashboard/notifications/read-all', {}, { preserveScroll: true });
};
</script>

<template>
    <Head title="Notifications - RAOSC" />

    <AppLayout :breadcrumbs="[{ title: 'Notifications', href: '/dashboard/notifications' }]">
        <div class="flex h-full flex-1 flex-col gap-8 p-6 lg:p-10 bg-zinc-50/50 dark:bg-zinc-950">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <Bell class="w-6 h-6 text-raosc-green" />
                        Vos Notifications
                    </h1>
                    <p class="text-sm text-zinc-500 mt-1">Consultez toutes les alertes et mises à jour importantes.</p>
                </div>
                
                <button 
                    @click="markAllAsRead"
                    class="flex items-center gap-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 px-4 py-2 rounded-xl text-sm font-bold text-zinc-600 hover:text-raosc-green hover:border-raosc-green/30 transition-all shadow-sm"
                >
                    <CheckCircle2 class="w-4 h-4" />
                    Tout marquer comme lu
                </button>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden shadow-sm">
                <div v-if="notificationsList.length === 0" class="p-12 text-center text-zinc-500">
                    <Bell class="w-12 h-12 mx-auto mb-4 text-zinc-300 dark:text-zinc-700" />
                    <p class="text-lg font-bold text-zinc-900 dark:text-white mb-1">Aucune notification</p>
                    <p class="text-sm">Vous êtes à jour, aucune notification pour le moment.</p>
                </div>

                <div v-else class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                    <div 
                        v-for="notif in notificationsList" 
                        :key="notif.id" 
                        class="p-6 transition-colors flex items-start sm:items-center justify-between gap-6"
                        :class="!notif.read_at ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50'"
                    >
                        <div class="flex items-start gap-4 flex-grow min-w-0">
                            <div 
                                class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center border"
                                :class="!notif.read_at ? 'bg-raosc-green/10 text-raosc-green border-raosc-green/20' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 border-zinc-200 dark:border-zinc-700'"
                            >
                                <Bell v-if="!notif.type.includes('Approved')" class="w-5 h-5" />
                                <CheckCircle2 v-else class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-white" :class="!notif.read_at ? 'text-raosc-green' : ''">
                                    {{ notif.data.message || 'Nouvelle notification' }}
                                </h3>
                                <p v-if="notif.data.reason" class="text-xs text-red-500 mt-1.5 font-medium bg-red-50 border border-red-100 inline-block px-2 py-0.5 rounded-md">
                                    Motif: {{ notif.data.reason }}
                                </p>
                                <p class="text-xs text-zinc-500 mt-1.5 flex items-center gap-1.5">
                                    <Clock class="w-3.5 h-3.5" />
                                    {{ new Date(notif.created_at).toLocaleString('fr-FR') }}
                                </p>
                            </div>
                        </div>

                        <div class="shrink-0 flex items-center">
                            <button 
                                v-if="!notif.read_at"
                                @click="markAsRead(notif.id)"
                                class="h-8 w-8 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm flex items-center justify-center text-zinc-400 hover:text-raosc-green hover:border-raosc-green/30 transition-all custom-tooltip group relative"
                                title="Marquer comme lu"
                            >
                                <Check class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

