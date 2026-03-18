<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Check, X } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    organization: any;
}>();

const showingRejectInput = ref(false);
const rejectionReason = ref('');

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
            rejectionReason.value = '';
        }
    });
};
</script>

<template>
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 flex flex-col gap-4 shadow-sm hover:border-[#008751]/30 transition-all">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center font-bold text-[#008751]">
                    {{ organization.name.charAt(0) }}
                </div>
                <div>
                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white">{{ organization.name }}</h4>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-widest">{{ organization.city }}, {{ organization.country }}</p>
                </div>
            </div>
            <div class="flex gap-2">
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

        <div v-if="showingRejectInput" class="space-y-3 animate-in fade-in slide-in-from-top-2">
            <textarea 
                v-model="rejectionReason"
                placeholder="Motif du rejet..."
                class="w-full text-xs p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-1 focus:ring-red-500 outline-none min-h-[80px]"
            ></textarea>
            <div class="flex justify-end gap-2">
                <button @click="showingRejectInput = false" class="text-[10px] font-bold text-zinc-500 px-3 py-1.5">Annuler</button>
                <button 
                    @click="updateStatus('rejected')"
                    class="bg-red-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-lg hover:bg-red-700 transition-all"
                >
                    Confirmer le rejet
                </button>
            </div>
        </div>
    </div>
</template>
