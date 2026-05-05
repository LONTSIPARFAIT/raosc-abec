<!-- AdminSettings.vue - Paramètres Généraux -->
<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Settings, Save, Globe, Paintbrush, BellRing, Upload, X, CheckCircle2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { ref } from 'vue';

const breadcrumbs = [
    { title: 'Tableau de Bord', href: dashboard() },
    { title: 'Paramètres', href: '/admin/settings' },
];

const activeTab = ref('general');

const form = useForm({
    site_name: 'RAOSC - Réseau Africain des Organisations de la Société Civile',
    site_tagline: 'Portail central pour toutes les organisations de la société civile en Afrique.',
    contact_email: 'contact@raosc.org',
    contact_phone: '+237 600 000 000',
    maintenance_mode: false,
    logo_preview: null as string | null,
});

const saveSettings = () => {
    alert("Paramètres sauvegardés avec succès! (Fonctionnalité en démo)");
};

const tabs = [
    { id: 'general', label: 'Général', icon: Globe },
    { id: 'appearance', label: 'Apparence', icon: Paintbrush },
    { id: 'notifications', label: 'Notifications', icon: BellRing },
];
</script>

<template>
    <Head title="Paramètres Généraux" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION -->
            <!-- ============================================ -->
            <div class="border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                <div class="container mx-auto px-6 lg:px-12 py-6">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                            <Settings class="h-5 w-5 text-purple-600 dark:text-purple-400" />
                        </div>
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">Paramètres Généraux</h1>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Gérez la configuration globale de la plateforme RAOSC</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- TABS NAVIGATION -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 pt-6">
                <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-800">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        :class="[
                            'flex items-center gap-2 px-5 py-3 text-sm font-semibold transition-all border-b-2 -mb-px',
                            activeTab === tab.id 
                                ? 'border-raosc-green text-raosc-green' 
                                : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'
                        ]"
                    >
                        <component :is="tab.icon" class="w-4 h-4" />
                        {{ tab.label }}
                    </button>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU DES TABS -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-8 pb-16">
                
                <!-- TAB GÉNÉRAL -->
                <div v-if="activeTab === 'general'" class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Informations générales</h2>
                    
                    <form @submit.prevent="saveSettings" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                Nom de la plateforme
                            </label>
                            <input 
                                v-model="form.site_name"
                                type="text" 
                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                Slogan / Tagline
                            </label>
                            <input 
                                v-model="form.site_tagline"
                                type="text" 
                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                            />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Email de contact
                                </label>
                                <input 
                                    v-model="form.contact_email"
                                    type="email" 
                                    class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Téléphone de contact
                                </label>
                                <input 
                                    v-model="form.contact_phone"
                                    type="tel" 
                                    class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input 
                                    v-model="form.maintenance_mode"
                                    type="checkbox" 
                                    class="w-4 h-4 rounded border-zinc-300 text-raosc-green focus:ring-raosc-green"
                                />
                                <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Mode maintenance</span>
                            </label>
                            <p class="text-xs text-zinc-500 mt-1 ml-7">Activez pour restreindre l'accès aux administrateurs uniquement</p>
                        </div>

                        <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex justify-end">
                            <button type="submit" class="flex items-center gap-2 bg-raosc-green hover:bg-raosc-green/90 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-all hover:scale-105 shadow-md">
                                <Save class="w-4 h-4" />
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>

                <!-- TAB APPARENCE -->
                <div v-if="activeTab === 'appearance'" class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Personnalisation de l'apparence</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                Logo de la plateforme
                            </label>
                            <div class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-xl p-6 text-center hover:border-raosc-green transition-colors cursor-pointer">
                                <div class="flex flex-col items-center gap-2">
                                    <Upload class="w-8 h-8 text-zinc-400" />
                                    <p class="text-sm text-zinc-500">Cliquez ou glissez une image (PNG, JPG, SVG)</p>
                                    <p class="text-xs text-zinc-400">Format recommandé : 200x200px</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">
                                Couleur principale
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="color" value="#008751" class="w-12 h-12 rounded-lg border border-zinc-200 cursor-pointer" />
                                <input type="text" value="#008751" class="flex-1 h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-mono" />
                            </div>
                        </div>

                        <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex justify-end">
                            <button type="button" class="flex items-center gap-2 bg-raosc-green hover:bg-raosc-green/90 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-all hover:scale-105 shadow-md">
                                <Save class="w-4 h-4" />
                                Sauvegarder
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB NOTIFICATIONS -->
                <div v-if="activeTab === 'notifications'" class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Configuration des notifications</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-zinc-100 dark:border-zinc-800">
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Notifications email</p>
                                <p class="text-xs text-zinc-500">Recevoir les alertes par email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-raosc-green/20 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-raosc-green"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-zinc-100 dark:border-zinc-800">
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Nouveaux utilisateurs</p>
                                <p class="text-xs text-zinc-500">Être notifié lors d'une nouvelle inscription</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-raosc-green peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-raosc-green/20 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-raosc-green"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Demandes de validation</p>
                                <p class="text-xs text-zinc-500">Être notifié lors de nouvelles inscriptions d'organisations</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-raosc-green peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-raosc-green/20 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-raosc-green"></div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex justify-end mt-6">
                        <button type="button" class="flex items-center gap-2 bg-raosc-green hover:bg-raosc-green/90 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-all hover:scale-105 shadow-md">
                            <Save class="w-4 h-4" />
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>