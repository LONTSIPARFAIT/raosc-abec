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
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="h-8 w-8 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                            <Bell class="h-5 w-5" />
                        </div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Vos Notifications</h1>
                    </div>
                    <p class="text-sm text-zinc-500 ml-10">Consultez toutes les alertes et mises à jour importantes.</p>
                </div>
                
                <button 
                    @click="markAllAsRead"
                    class="inline-flex items-center gap-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 px-5 py-2.5 rounded-full text-sm font-semibold text-zinc-600 hover:text-raosc-green hover:border-raosc-green/30 transition-all shadow-sm"
                >
                    <CheckCircle2 class="w-4 h-4" />
                    Tout marquer comme lu
                </button>
            </div>

            <!-- Notifications List -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                <div v-if="notificationsList.length === 0" class="py-16 text-center">
                    <div class="h-16 w-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <Bell class="h-8 w-8 text-zinc-400 dark:text-zinc-600" />
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-1">Aucune notification</h3>
                    <p class="text-sm text-zinc-500">Vous êtes à jour, aucune notification pour le moment.</p>
                </div>

                <div v-else class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    <div 
                        v-for="notif in notificationsList" 
                        :key="notif.id" 
                        class="group p-5 transition-all duration-200 flex items-start gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/30"
                        :class="!notif.read_at ? 'bg-emerald-50/40 dark:bg-emerald-900/5' : ''"
                    >
                        <!-- Icon -->
                        <div 
                            class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center"
                            :class="!notif.read_at ? 'bg-raosc-green/10 text-raosc-green' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500'"
                        >
                            <Bell v-if="!notif.data.message?.toLowerCase().includes('approuvée') && !notif.data.message?.toLowerCase().includes('validée')" class="h-5 w-5" />
                            <CheckCircle2 v-else class="h-5 w-5" />
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-white" :class="!notif.read_at ? 'text-raosc-green' : ''">
                                {{ notif.data.message || 'Nouvelle notification' }}
                            </h3>
                            <p v-if="notif.data.reason" class="text-xs text-red-500 mt-1.5 font-medium">
                                Motif : {{ notif.data.reason }}
                            </p>
                            <div class="flex items-center gap-1.5 mt-1.5 text-[11px] text-zinc-400">
                                <Clock class="h-3 w-3" />
                                <span>{{ new Date(notif.created_at).toLocaleString('fr-FR') }}</span>
                            </div>
                        </div>

                        <!-- Action -->
                        <button 
                            v-if="!notif.read_at"
                            @click="markAsRead(notif.id)"
                            class="h-8 w-8 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm flex items-center justify-center text-zinc-400 hover:text-raosc-green hover:border-raosc-green/30 transition-all hover:scale-105 active:scale-95"
                            title="Marquer comme lu"
                        >
                            <Check class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>