<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Check, X, Eye, Building2, MapPin, Mail, Globe, PhoneCall, Calendar } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    organization: any;
}>();

const showingRejectInput = ref(false);
const rejectionReason = ref('');
const showingDetailsModal = ref(false);

const updateStatus = (status: string) => {
    if (status === 'rejected' && !rejectionReason.value) {
        showingRejectInput.value = true;
        return;
    }

    router.post(`/admin/organizations/${props.organization.id}/status`, {
        status,
        rejection_reason: rejectionReason.value
    }, {
        onSuccess: () => {
            showingRejectInput.value = false;
            showingDetailsModal.value = false;
            rejectionReason.value = '';
        }
    });
};
</script>

<template>
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 flex flex-col gap-4 shadow-sm hover:border-raosc-green/30 transition-all">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div v-if="organization.logo" class="h-10 w-10 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden shrink-0">
                    <img :src="'/storage/' + organization.logo" class="w-full h-full object-cover" />
                </div>
                <div v-else class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center font-bold text-raosc-green overflow-hidden shrink-0">
                    {{ organization.name.charAt(0) }}
                </div>
                <div>
                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white line-clamp-1">{{ organization.name }}</h4>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-widest truncate max-w-[120px]">{{ organization.city }}, {{ organization.country }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button 
                    @click="showingDetailsModal = true"
                    class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-all"
                    title="Voir les détails"
                >
                    <Eye class="w-4 h-4" />
                </button>
                <button 
                    @click="updateStatus('approved')"
                    class="h-8 w-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 flex items-center justify-center hover:bg-emerald-100 transition-all"
                    title="Approuver"
                >
                    <Check class="w-4 h-4" />
                </button>
                <button 
                    @click="showingRejectInput = !showingRejectInput"
                    class="h-8 w-8 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 flex items-center justify-center hover:bg-red-100 transition-all"
                    title="Rejeter"
                >
                    <X class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div v-if="showingRejectInput" class="space-y-3 animate-in fade-in slide-in-from-top-2 mt-2 border-t border-zinc-100 dark:border-zinc-800 pt-4">
            <textarea 
                v-model="rejectionReason"
                placeholder="Motif du rejet..."
                class="w-full text-xs p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-1 focus:ring-red-500 outline-none min-h-[80px] dark:text-zinc-200"
            ></textarea>
            <div class="flex justify-end gap-2">
                <button @click="showingRejectInput = false" class="text-[10px] font-bold text-zinc-500 px-3 py-1.5 hover:text-zinc-700 transition">Annuler</button>
                <button 
                    @click="updateStatus('rejected')"
                    class="bg-red-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-lg hover:bg-red-700 transition-all"
                >
                    Confirmer le rejet
                </button>
            </div>
        </div>

        <!-- Details Modal Overlay -->
        <teleport to="body">
            <div v-if="showingDetailsModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div class="bg-white dark:bg-zinc-950 rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col border border-zinc-200 dark:border-zinc-800 animate-in zoom-in-95">
                    <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50">
                        <div class="flex items-center gap-3">
                            <div v-if="organization.logo" class="h-10 w-10 rounded-lg overflow-hidden shrink-0 border border-zinc-200 dark:border-zinc-800">
                                <img :src="'/storage/' + organization.logo" class="h-full w-full object-cover">
                            </div>
                            <div v-else class="h-10 w-10 rounded-lg bg-raosc-green/10 text-raosc-green flex items-center justify-center">
                                <Building2 class="h-5 w-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-900 dark:text-white">{{ organization.name }}</h3>
                                <p class="text-xs text-zinc-500">Demande d'inscription</p>
                            </div>
                        </div>
                        <button @click="showingDetailsModal = false" class="h-8 w-8 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center justify-center text-zinc-500">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                    
                    <div class="p-6 overflow-y-auto flex-1 space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column (Infos) -->
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">À propos</h4>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 capitalize whitespace-pre-line">{{ organization.short_description || organization.description }}</p>
                                </div>
                                <div v-if="organization.categories && organization.categories.length > 0">
                                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Secteurs d'intervention</h4>
                                    <div class="flex flex-wrap gap-2">
                                        <span v-for="cat in organization.categories" :key="cat.id" class="text-[10px] font-semibold bg-raosc-green/10 text-raosc-green px-2.5 py-1 rounded-full border border-raosc-green/20">
                                            {{ cat.name }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Créateur du compte</h4>
                                    <div v-if="organization.members && organization.members.length > 0" class="flex gap-2">
                                        <div class="text-sm px-3 py-2 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                                            {{ organization.members[0].user?.name }} ({{ organization.members[0].user?.email }})
                                        </div>
                                    </div>
                                    <div v-else class="text-xs text-zinc-500">Inconnu</div>
                                </div>
                            </div>

                            <!-- Right Column (Contact & Technique) -->
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Contact & Localisation</h4>
                                    <div class="space-y-3 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800">
                                        <div class="flex items-center gap-3 text-sm">
                                            <Mail class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300">{{ organization.email }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm">
                                            <PhoneCall class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300">{{ organization.phone || 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm">
                                            <Globe class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300">{{ organization.website || 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm border-t border-zinc-200 dark:border-zinc-800 pt-3">
                                            <MapPin class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300">{{ organization.address || '' }} {{ organization.city }}, {{ organization.country }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm">
                                            <Calendar class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300">N° d'enreg: {{ organization.registration_number || 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Photos -->
                        <div v-if="organization.gallery && organization.gallery.length > 0">
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Images et Actions</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                <div v-for="(img, idx) in organization.gallery" :key="idx" class="h-32 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
                                    <img :src="'/storage/' + img" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="p-5 border-t border-zinc-100 dark:border-zinc-800 flex justify-between bg-zinc-50 dark:bg-zinc-900/50">
                        <button 
                            @click="showingDetailsModal = false; showingRejectInput = true"
                            class="px-5 py-2 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-600 font-bold hover:bg-red-100 dark:hover:bg-red-500/20 text-sm transition-all flex items-center gap-2"
                        >
                            <X class="w-4 h-4" /> Rejeter
                        </button>
                        <button 
                            @click="updateStatus('approved')"
                            class="px-6 py-2 rounded-xl bg-raosc-green text-white font-bold hover:bg-emerald-600 text-sm shadow-md transition-all flex items-center gap-2"
                        >
                            <Check class="w-4 h-4" /> Approuver l'OSC
                        </button>
                    </div>
                </div>
            </div>
        </teleport>
    </div>
</template>

