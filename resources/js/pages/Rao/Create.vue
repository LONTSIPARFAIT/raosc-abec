<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Building2, Info, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
    categories: Array
});

const form = useForm({
    name: '',
    short_description: '',
    description: '',
    email: '',
    phone: '',
    country: '',
    city: '',
    address: '',
    categories: [] as number[],
});

const submit = () => {
    form.post(route('rao.store'));
};

const toggleCategory = (id: number) => {
    const index = form.categories.indexOf(id);
    if (index === -1) {
        form.categories.push(id);
    } else {
        form.categories.splice(index, 1);
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Enregistrer une organisation - RAO" />

        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <Badge variant="outline" class="mb-4 bg-blue-50 text-blue-700 border-blue-200">Inscription RAO</Badge>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Soumettre votre Organisation
                </h1>
                <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
                    Rejoignez le Réseau Africain des Organisations et amplifiez votre impact. Votre dossier sera étudié par l'équipe ABEC.
                </p>
            </div>

            <Card class="shadow-xl border-slate-200/50 dark:border-slate-800/50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl">
                <CardContent class="p-8">
                    <form @submit.prevent="submit" class="space-y-8">
                        
                        <!-- Informations Générales -->
                        <div>
                            <div class="flex items-center gap-2 border-b dark:border-slate-800 pb-2 mb-6 text-slate-900 dark:text-white">
                                <Building2 class="w-5 h-5 text-blue-600" />
                                <h2 class="text-xl font-semibold">Informations Générales</h2>
                            </div>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nom officiel de l'organisation <span class="text-red-500">*</span></label>
                                    <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white" />
                                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Domaines d'intervention (Catégories) <span class="text-red-500">*</span></label>
                                    <p class="text-xs text-slate-500 mb-3">Sélectionnez les domaines pertinents pour votre structure.</p>
                                    <div class="flex flex-wrap gap-2">
                                        <div 
                                            v-for="cat in categories" 
                                            :key="cat.id"
                                            @click="toggleCategory(cat.id)"
                                            class="cursor-pointer px-4 py-2 rounded-full border text-sm transition-all select-none"
                                            :class="form.categories.includes(cat.id) ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300'"
                                        >
                                            {{ cat.name }}
                                        </div>
                                    </div>
                                    <div v-if="form.errors.categories" class="text-red-500 text-sm mt-1">{{ form.errors.categories }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Résumé bref <span class="text-red-500">*</span></label>
                                    <p class="text-xs text-slate-500 mb-2">Une phrase ou deux décrivant votre mission (visible sur l'annuaire).</p>
                                    <textarea v-model="form.short_description" required rows="2" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white resize-none"></textarea>
                                    <div v-if="form.errors.short_description" class="text-red-500 text-sm mt-1">{{ form.errors.short_description }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description détaillée</label>
                                    <textarea v-model="form.description" rows="5" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white resize-y"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Coordonnées -->
                        <div>
                            <div class="flex items-center gap-2 border-b dark:border-slate-800 pb-2 mb-6 mt-8 text-slate-900 dark:text-white">
                                <Info class="w-5 h-5 text-blue-600" />
                                <h2 class="text-xl font-semibold">Localisation & Contact</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email de l'organisation <span class="text-red-500">*</span></label>
                                    <input v-model="form.email" type="email" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white" />
                                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Téléphone</label>
                                    <input v-model="form.phone" type="text" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pays <span class="text-red-500">*</span></label>
                                    <input v-model="form.country" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white" />
                                    <div v-if="form.errors.country" class="text-red-500 text-sm mt-1">{{ form.errors.country }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ville <span class="text-red-500">*</span></label>
                                    <input v-model="form.city" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white" />
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Adresse complète</label>
                                    <input v-model="form.address" type="text" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-transparent focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t dark:border-slate-800 flex justify-end gap-4">
                            <Link :href="route('rao.index')">
                                <Button type="button" variant="outline" class="px-6">Annuler</Button>
                            </Link>
                            <Button type="submit" :disabled="form.processing" class="px-8 bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-500/20">
                                <span v-if="form.processing">Traitement...</span>
                                <span v-else class="flex items-center gap-2">Soumettre la demande <ArrowRight class="w-4 h-4" /></span>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
