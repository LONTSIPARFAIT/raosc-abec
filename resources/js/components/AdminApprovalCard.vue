<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Check, X, Eye, Trash2, Building2, MapPin, Mail, Globe, PhoneCall, Calendar } from 'lucide-vue-next';
import { ref, reactive } from 'vue';
import { updateStatus as updateStatusAction, destroy as destroyAction } from '@/actions/App/Http/Controllers/Admin/OrganizationManagementController';

interface Organization {
    id: number;
    name: string;
    slug: string;
    status: string;
    city?: string;
    country?: string;
    logo?: string;
    cover_image?: string;
    short_description?: string;
    description?: string;
    email?: string;
    phone?: string;
    website?: string;
    address?: string;
    registration_number?: string;
    member_count?: number;
    presentation_doc?: string;
    legal_docs?: string[];
    responsible_name?: string;
    responsible_email?: string;
    responsible_phone?: string;
    responsible_photo?: string;
    responsible_id_doc?: string;
    categories?: { id: number, name: string }[];
    members?: { user: { name: string, email: string } }[];
    gallery?: string[];
}

const {
    organization
} = defineProps<{
    organization: Organization;
}>();

const showingRejectInput = ref(false);
const showingDetailsModal = ref(false);

const rejectionData = reactive({
    status: 'rejected',
    rejection_reason: '',
});

const onSuccess = () => {
    showingRejectInput.value = false;
    showingDetailsModal.value = false;
    rejectionData.rejection_reason = '';
};

const confirmDelete = () => {
    if (window.confirm('Êtes-vous sûr de vouloir supprimer définitivement cette organisation ?')) {
        router.delete(destroyAction(organization.id).url);
    }
};
</script>

<template>
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 flex flex-col gap-4 shadow-sm hover:border-raosc-green/30 transition-all">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div v-if="organization.logo" class="h-10 w-10 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden shrink-0">
                    <img :src="organization.logo.startsWith('http') ? organization.logo : '/storage/' + organization.logo" class="w-full h-full object-cover" />
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
                    type="button"
                    class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-all"
                    title="Voir les détails complets"
                >
                    <Eye class="w-4 h-4" />
                </button>
                
                <Link 
                    :href="updateStatusAction(organization.id).url" 
                    method="post"
                    :data="{ status: 'approved' }"
                    @success="onSuccess"
                    as="button"
                    class="h-8 w-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 flex items-center justify-center hover:bg-emerald-100 transition-all"
                    title="Approuver l'OSC"
                >
                    <Check class="w-4 h-4" />
                </Link>

                <button 
                    @click="showingRejectInput = !showingRejectInput"
                    type="button"
                    class="h-8 w-8 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 flex items-center justify-center hover:bg-red-100 transition-all"
                    title="Rejeter la demande"
                >
                    <X class="w-4 h-4" />
                </button>

                <button 
                    @click="confirmDelete"
                    type="button"
                    class="h-8 w-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"
                    title="Supprimer définitivement"
                >
                    <Trash2 class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div v-if="showingRejectInput" class="animate-in fade-in slide-in-from-top-2 mt-2 border-t border-zinc-100 dark:border-zinc-800 pt-4">
            <form 
                @submit.prevent="router.post(updateStatusAction(organization.id).url, rejectionData, { onSuccess })"
                class="space-y-3"
            >
                <textarea 
                    v-model="rejectionData.rejection_reason"
                    placeholder="Précisez le motif du rejet pour informer l'organisation..."
                    required
                    class="w-full text-xs p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-1 focus:ring-red-500 outline-none min-h-[80px] dark:text-zinc-200"
                ></textarea>
                <div class="flex justify-end gap-2">
                    <button @click="showingRejectInput = false" type="button" class="text-[10px] font-bold text-zinc-500 px-3 py-1.5 hover:text-zinc-700 transition">Annuler</button>
                    <button 
                        type="submit"
                        class="bg-red-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-lg hover:bg-red-700 transition-all"
                    >
                        Confirmer le rejet
                    </button>
                </div>
            </form>
        </div>

        <!-- Details Modal Overlay -->
        <teleport to="body">
            <div v-if="showingDetailsModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div class="bg-white dark:bg-zinc-950 rounded-2xl shadow-xl w-full max-w-5xl max-h-[90vh] overflow-hidden flex flex-col border border-zinc-200 dark:border-zinc-800 animate-in zoom-in-95">
                    <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50">
                        <div class="flex items-center gap-3">
                            <div v-if="organization.logo" class="h-10 w-10 rounded-lg overflow-hidden shrink-0 border border-zinc-200 dark:border-zinc-800">
                                <img :src="organization.logo.startsWith('http') ? organization.logo : '/storage/' + organization.logo" class="h-full w-full object-cover">
                            </div>
                            <div v-else class="h-10 w-10 rounded-lg bg-raosc-green/10 text-raosc-green flex items-center justify-center font-bold">
                                {{ organization.name.charAt(0) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-900 dark:text-white">{{ organization.name }}</h3>
                                <p class="text-xs text-zinc-500">Validation de la demande d'adhésion</p>
                            </div>
                        </div>
                        <button @click="showingDetailsModal = false" class="h-8 w-8 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center justify-center text-zinc-500">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                    
                    <div class="p-6 overflow-y-auto flex-1 space-y-10">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <!-- Left Column: Primary Info -->
                            <div class="md:col-span-2 space-y-8">
                                <div>
                                    <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-4">Présentation</h4>
                                    <div class="p-5 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                        <p class="text-base text-zinc-700 dark:text-zinc-300 font-medium mb-4">{{ organization.short_description }}</p>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 whitespace-pre-line leading-relaxed">{{ organization.description }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div v-if="organization.categories && organization.categories.length > 0">
                                        <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-3">Secteurs</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <span v-for="cat in organization.categories" :key="cat.id" class="text-[10px] font-bold bg-raosc-green/10 text-raosc-green px-3 py-1 rounded-full border border-raosc-green/10">
                                                {{ cat.name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-3">Statistiques</h4>
                                        <div class="text-sm font-bold text-zinc-700 dark:text-zinc-300 flex items-center gap-2">
                                            <div class="h-2 w-2 rounded-full bg-raosc-green"></div>
                                            {{ organization.member_count || '0' }} membres déclarés
                                        </div>
                                    </div>
                                </div>

                                <!-- Responsible Info -->
                                <div>
                                    <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-4">Responsable de l'organisation</h4>
                                    <div class="flex items-start gap-6 p-5 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                        <div class="h-24 w-24 rounded-2xl overflow-hidden bg-zinc-200 dark:bg-zinc-800 shrink-0 border border-zinc-200 dark:border-zinc-700">
                                            <img v-if="organization.responsible_photo" :src="organization.responsible_photo" class="w-full h-full object-cover">
                                            <div v-else class="w-full h-full flex items-center justify-center text-zinc-400">Photo</div>
                                        </div>
                                        <div class="flex-1 space-y-2">
                                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ organization.responsible_name || 'Non renseigné' }}</p>
                                            <div class="flex items-center gap-3 text-sm text-zinc-500">
                                                <Mail class="w-4 h-4" /> {{ organization.responsible_email }}
                                            </div>
                                            <div class="flex items-center gap-3 text-sm text-zinc-500">
                                                <PhoneCall class="w-4 h-4" /> {{ organization.responsible_phone }}
                                            </div>
                                            <div v-if="organization.responsible_id_doc" class="pt-2">
                                                <a :href="organization.responsible_id_doc" target="_blank" class="text-xs font-bold text-raosc-green hover:underline flex items-center gap-1.5">
                                                    <Eye class="w-3 h-3" /> Voir la pièce d'identité
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Contact & Docs -->
                            <div class="space-y-8">
                                <div>
                                    <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-4">Contact & Légal</h4>
                                    <div class="space-y-4 p-5 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                        <div class="space-y-3">
                                            <div class="flex items-center gap-3 text-sm">
                                                <Mail class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ organization.email }}</span>
                                            </div>
                                            <div class="flex items-center gap-3 text-sm">
                                                <Globe class="w-4 h-4 text-zinc-400" /> <span class="text-zinc-700 dark:text-zinc-300 truncate">{{ organization.website || 'Aucun site' }}</span>
                                            </div>
                                            <div class="flex items-start gap-3 text-sm">
                                                <MapPin class="w-4 h-4 text-zinc-400 mt-0.5" /> 
                                                <span class="text-zinc-700 dark:text-zinc-300">{{ organization.address || '' }}<br>{{ organization.city }}, {{ organization.country }}</span>
                                            </div>
                                            <div class="flex items-center gap-3 text-sm">
                                                <Calendar class="w-4 h-4 text-zinc-400" /> 
                                                <span class="text-zinc-700 dark:text-zinc-300">Enreg: {{ organization.registration_number || 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documents -->
                                <div>
                                    <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-4">Documents fournis</h4>
                                    <div class="space-y-3">
                                        <a v-if="organization.presentation_doc" :href="organization.presentation_doc" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-800 hover:border-raosc-green transition-colors group">
                                            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">Document de présentation</span>
                                            <Eye class="w-4 h-4 text-zinc-400 group-hover:text-raosc-green" />
                                        </a>
                                        <div v-if="organization.legal_docs && organization.legal_docs.length > 0" class="space-y-2">
                                            <a v-for="(doc, i) in organization.legal_docs" :key="i" :href="doc" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-800 hover:border-raosc-green transition-colors group">
                                                <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">Statuts / Document Légal {{ i + 1 }}</span>
                                                <Eye class="w-4 h-4 text-zinc-400 group-hover:text-raosc-green" />
                                            </a>
                                        </div>
                                        <p v-else class="text-[10px] text-zinc-500 italic">Aucun document légal joint</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div v-if="organization.gallery && organization.gallery.length > 0">
                            <h4 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-4">Galerie photos</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                                <div v-for="(img, idx) in organization.gallery" :key="idx" class="aspect-square rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-sm">
                                    <img :src="img.startsWith('http') ? img : '/storage/' + img" class="w-full h-full object-cover hover:scale-110 transition duration-700">
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
                        
                        <Link 
                            :href="updateStatusAction(organization.id).url" 
                            method="post"
                            :data="{ status: 'approved' }"
                            @success="onSuccess"
                            as="button"
                            class="px-6 py-2 rounded-xl bg-raosc-green text-white font-bold hover:bg-emerald-600 text-sm shadow-md transition-all flex items-center gap-2"
                        >
                            <Check class="w-4 h-4" /> Approuver l'OSC
                        </Link>
                    </div>
                </div>
            </div>
        </teleport>
    </div>
</template>

