<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Settings, Save, Globe, Paintbrush, BellRing } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';

const breadcrumbs = [
    { title: 'Tableau de Bord', href: dashboard() },
    { title: 'Paramètres du Site', href: '/admin/settings' },
];

const saveSettings = () => {
    alert("Paramètres sauvegardés avec succès! (Fonctionnalité en démo)");
};
</script>

<template>
    <Head title="Paramètres du Site" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 bg-zinc-50 dark:bg-zinc-950 p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-600">
                    <Settings class="w-5 h-5" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Paramètres Généraux</h1>
                    <p class="text-xs text-zinc-500">Gérez la configuration globale de la plateforme RAOSC</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar Nav -->
                <div class="lg:col-span-1 space-y-2">
                    <button class="w-full flex items-center gap-3 p-4 rounded-xl bg-white dark:bg-zinc-900 border border-raosc-green shadow-sm text-left">
                        <Globe class="w-5 h-5 text-raosc-green" />
                        <div>
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Général</h4>
                            <p class="text-[10px] text-zinc-500">Nom du site, contact, devise</p>
                        </div>
                    </button>
                    <button class="w-full flex items-center gap-3 p-4 rounded-xl bg-transparent hover:bg-white dark:hover:bg-zinc-900 border border-transparent hover:border-zinc-200 dark:hover:border-zinc-800 text-left transition-colors">
                        <Paintbrush class="w-5 h-5 text-zinc-400" />
                        <div>
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Apparence</h4>
                            <p class="text-[10px] text-zinc-500">Logos, couleurs principales</p>
                        </div>
                    </button>
                    <button class="w-full flex items-center gap-3 p-4 rounded-xl bg-transparent hover:bg-white dark:hover:bg-zinc-900 border border-transparent hover:border-zinc-200 dark:hover:border-zinc-800 text-left transition-colors">
                        <BellRing class="w-5 h-5 text-zinc-400" />
                        <div>
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Notifications</h4>
                            <p class="text-[10px] text-zinc-500">Préférences email et système</p>
                        </div>
                    </button>
                </div>

                <!-- Forms -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Paramètres de base</h2>
                        
                        <form @submit.prevent="saveSettings" class="space-y-6">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Nom de la Plateforme</label>
                                <input type="text" value="RAOSC - Réseau Africain des OSC" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-raosc-green outline-none dark:text-white" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Description / Slogan</label>
                                <textarea rows="3" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-raosc-green outline-none dark:text-white">Portail central pour toutes les organisations de la société civile en Afrique.</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Email de Contact Principal</label>
                                    <input type="email" value="contact@raosc.org" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-raosc-green outline-none dark:text-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Mode Maintenance</label>
                                    <select class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-raosc-green outline-none dark:text-white">
                                        <option value="0">Désactivé (Plateforme Publique)</option>
                                        <option value="1">Activé (Admins Uniquement)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex justify-end">
                                <button type="submit" class="flex items-center gap-2 bg-raosc-green hover:bg-emerald-600 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-all shadow-md">
                                    <Save class="w-4 h-4" />
                                    Sauvegarder les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
