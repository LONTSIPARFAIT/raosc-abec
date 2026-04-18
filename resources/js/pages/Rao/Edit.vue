<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import { Building2, Info, ArrowRight, CheckCircle2 } from 'lucide-vue-next';
import CountryPhoneInput from '@/components/CountryPhoneInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { update, index as raoIndex } from '@/actions/App/Http/Controllers/RaoController';
import { index as dashboardRao } from '@/actions/App/Http/Controllers/DashboardController';

interface Organization {
    id: number;
    name: string;
    slug: string;
    short_description: string | null;
    description: string | null;
    website: string | null;
    email: string | null;
    phone: string | null;
    country: string | null;
    city: string | null;
    address: string | null;
    registration_number: string | null;
    founded_date: string | null;
    categories?: { id: number }[];
}

const {
    categories = [],
    organization,
    isPublic = false
} = defineProps<{
    categories?: { id: number, name: string }[];
    organization: { data: Organization } | Organization;
    isPublic?: boolean;
}>();

const org = ('data' in organization) ? organization.data : organization;

const formData = useForm({
    _method: 'PUT',
    name: org.name || '',
    short_description: org.short_description || '',
    description: org.description || '',
    website: org.website || '',
    email: org.email || '',
    phone: org.phone || '',
    country: org.country || '',
    city: org.city || '',
    address: org.address || '',
    registration_number: org.registration_number || '',
    founded_date: org.founded_date || '',
    categories: (org.categories || []).map((c: any) => c.id),
});

const toggleCategory = (id: number) => {
    const index = formData.categories.indexOf(id);
    if (index === -1) {
        formData.categories.push(id);
    } else {
        formData.categories.splice(index, 1);
    }
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Éditer votre organisation - RAOSC" />

        <div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 border border-white/20">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Adhésion Réseau</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        Modifier votre <span class="text-raosc-yellow">Organisation</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                        Mettez à jour les informations de votre structure pour rester visible auprès des partenaires.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-4xl px-6 -mt-12 sm:-mt-16 relative z-20">
                <Card class="shadow-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden">
                    <CardContent class="p-8 sm:p-10">
                        <form 
                            @submit.prevent="formData.post(update(org.slug).url)"
                            class="space-y-10"
                        >
                            
                            <!-- Informations Générales -->
                            <section>
                                <div class="flex items-center gap-4 mb-8 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                                    <div class="h-10 w-10 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                                        <Building2 class="h-5 w-5" />
                                    </div>
                                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Identité de l'OSC</h2>
                                </div>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Nom officiel de l'OSC <span class="text-raosc-red">*</span></label>
                                        <input 
                                            v-model="formData.name" 
                                            type="text" 
                                            required 
                                            placeholder="Ex: Développement Pour Tous" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="formData.errors.name" class="text-raosc-red text-xs mt-1">{{ formData.errors.name }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Domaines d'intervention <span class="text-raosc-red">*</span></label>
                                        <div class="flex flex-wrap gap-2 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                            <div 
                                                v-for="cat in categories" 
                                                :key="cat.id"
                                                @click="toggleCategory(cat.id)"
                                                class="cursor-pointer px-4 py-2 rounded-full text-xs font-semibold transition-all select-none border"
                                                :class="formData.categories.includes(cat.id) ? 'bg-raosc-green text-white border-raosc-green shadow-sm' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:border-raosc-green/50'"
                                            >
                                                {{ cat.name }}
                                            </div>
                                        </div>
                                        <div v-if="formData.errors.categories" class="text-raosc-red text-xs mt-1">{{ formData.errors.categories }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Résumé de mission <span class="text-raosc-red">*</span></label>
                                        <textarea 
                                            v-model="formData.short_description" 
                                            required 
                                            rows="2" 
                                            placeholder="Décrivez en quelques mots l'essence de votre engagement..." 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white resize-none"
                                        ></textarea>
                                        <div v-if="formData.errors.short_description" class="text-raosc-red text-xs mt-1">{{ formData.errors.short_description }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Description détaillée</label>
                                        <textarea 
                                            v-model="formData.description" 
                                            rows="4" 
                                            placeholder="Objectifs, historique, réalisations majeures..." 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white resize-y"
                                        ></textarea>
                                        <div v-if="formData.errors.description" class="text-raosc-red text-xs mt-1">{{ formData.errors.description }}</div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">N° Enregistrement Officiel</label>
                                            <input 
                                                v-model="formData.registration_number" 
                                                type="text" 
                                                placeholder="Ex: 2024/001/MISP/..." 
                                                class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Date de Fondation</label>
                                            <input 
                                                v-model="formData.founded_date" 
                                                type="date" 
                                                class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Coordonnées -->
                            <section>
                                <div class="flex items-center gap-4 mb-8 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                                    <div class="h-10 w-10 rounded-lg bg-raosc-yellow/10 flex items-center justify-center text-raosc-yellow">
                                        <Info class="h-5 w-5" />
                                    </div>
                                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Localisation & Contact</h2>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Email Professionnel <span class="text-raosc-red">*</span></label>
                                        <input 
                                            v-model="formData.email" 
                                            type="email" 
                                            required 
                                            placeholder="contact@votre-ong.org" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="formData.errors.email" class="text-raosc-red text-xs mt-1">{{ formData.errors.email }}</div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Téléphone</label>
                                        <CountryPhoneInput v-model="formData.phone" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Site Web</label>
                                        <input 
                                            v-model="formData.website" 
                                            type="url" 
                                            placeholder="https://www.mon-ong.org" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="formData.errors.website" class="text-raosc-red text-xs mt-1">{{ formData.errors.website }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Pays <span class="text-raosc-red">*</span></label>
                                        <input 
                                            v-model="formData.country" 
                                            type="text" 
                                            required 
                                            placeholder="Bénin" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="formData.errors.country" class="text-raosc-red text-xs mt-1">{{ formData.errors.country }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Ville <span class="text-raosc-red">*</span></label>
                                        <input 
                                            v-model="formData.city" 
                                            type="text" 
                                            required 
                                            placeholder="Cotonou" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Adresse détaillée</label>
                                        <input 
                                            v-model="formData.address" 
                                            type="text" 
                                            placeholder="Rue, Quartier, Porte..." 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                    </div>
                                </div>
                            </section>

                            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row justify-end gap-4">
                                <Link :href="isPublic ? raoIndex().url : dashboardRao().url">
                                    <Button type="button" variant="outline" class="w-full sm:w-auto rounded-full px-6 py-2.5 text-xs font-semibold border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                        Annuler
                                    </Button>
                                </Link>
                                <Button 
                                    type="submit" 
                                    :disabled="formData.processing" 
                                    class="w-full sm:w-auto bg-raosc-green hover:bg-raosc-green/90 text-white rounded-full px-8 py-2.5 text-xs font-semibold shadow-md hover:shadow-lg transition-all"
                                >
                                    <span v-if="formData.processing" class="flex items-center gap-2">Enregistrement...</span>
                                    <span v-else class="flex items-center gap-2">Enregistrer les modifications <ArrowRight class="w-4 h-4" /></span>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>

                <div class="mt-12 text-center flex flex-col items-center">
                    <div class="h-8 w-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-raosc-green mb-4">
                        <CheckCircle2 class="h-4 w-4" />
                    </div>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-zinc-400 uppercase mb-1">Charte de confiance</p>
                    <p class="text-xs text-zinc-500 max-w-lg leading-relaxed">En soumettant ce formulaire, vous certifiez que l'organisation existe légalement et que vous avez l'autorité pour l'inscrire au RAOSC.</p>
                </div>
            </div>
        </div>
    </component>
</template>