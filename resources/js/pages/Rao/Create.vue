<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Building2, Info, ArrowRight, CheckCircle2, X } from 'lucide-vue-next';
import CountryPhoneInput from '@/components/CountryPhoneInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

const props = defineProps<{
    categories: any[];
    isPublic?: boolean;
}>();

const form = useForm({
    name: '',
    short_description: '',
    description: '',
    website: '',
    email: '',
    phone: '',
    country: '',
    city: '',
    address: '',
    registration_number: '',
    founded_date: '',
    categories: [] as number[],
    logo: null as File | null,
    gallery: [] as File[],
});

const logoPreview = ref<string | null>(null);
const galleryPreviews = ref<{file: File, url: string}[]>([]);

const handleLogoUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.logo = target.files[0];
        logoPreview.value = URL.createObjectURL(target.files[0]);
    }
};

const removeLogo = () => {
    form.logo = null;
    logoPreview.value = null;
    const input = document.getElementById('logo-upload') as HTMLInputElement;
    if (input) input.value = '';
};

const handleGalleryUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const newFiles = Array.from(target.files);
        for(const file of newFiles) {
            form.gallery.push(file);
            galleryPreviews.value.push({ file, url: URL.createObjectURL(file) });
        }
        // clear input to allow same file selection again if needed
        target.value = '';
    }
};

const removeGalleryImage = (index: number) => {
    form.gallery.splice(index, 1);
    galleryPreviews.value.splice(index, 1);
};

const submit = () => {
    form.post('/rao/join');
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
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Enregistrer une organisation - RAOSC" />

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
                        Inscrire votre <span class="text-raosc-yellow">Organisation</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                        Rejoignez le Réseau Africain pour amplifier votre impact et accéder à des partenariats stratégiques.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-4xl px-6 -mt-12 sm:-mt-16 relative z-20">
                <Card class="shadow-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden">
                    <CardContent class="p-8 sm:p-10">
                        <form @submit.prevent="submit" class="space-y-10">
                            
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
                                            v-model="form.name" 
                                            type="text" 
                                            required 
                                            placeholder="Ex: Développement Pour Tous" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="form.errors.name" class="text-raosc-red text-xs mt-1">{{ form.errors.name }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Domaines d'intervention <span class="text-raosc-red">*</span></label>
                                        <div class="flex flex-wrap gap-2 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                            <div 
                                                v-for="cat in categories" 
                                                :key="cat.id"
                                                @click="toggleCategory(cat.id)"
                                                class="cursor-pointer px-4 py-2 rounded-full text-xs font-semibold transition-all select-none border"
                                                :class="form.categories.includes(cat.id) ? 'bg-raosc-green text-white border-raosc-green shadow-sm' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:border-raosc-green/50'"
                                            >
                                                {{ cat.name }}
                                            </div>
                                        </div>
                                        <div v-if="form.errors.categories" class="text-raosc-red text-xs mt-1">{{ form.errors.categories }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Résumé de mission <span class="text-raosc-red">*</span></label>
                                        <textarea 
                                            v-model="form.short_description" 
                                            required 
                                            rows="2" 
                                            placeholder="Décrivez en quelques mots l'essence de votre engagement..." 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white resize-none"
                                        ></textarea>
                                        <div v-if="form.errors.short_description" class="text-raosc-red text-xs mt-1">{{ form.errors.short_description }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Description détaillée</label>
                                        <textarea 
                                            v-model="form.description" 
                                            rows="4" 
                                            placeholder="Objectifs, historique, réalisations majeures..." 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white resize-y"
                                        ></textarea>
                                        <div v-if="form.errors.description" class="text-raosc-red text-xs mt-1">{{ form.errors.description }}</div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">N° Enregistrement Officiel</label>
                                            <input 
                                                v-model="form.registration_number" 
                                                type="text" 
                                                placeholder="Ex: 2024/001/MISP/..." 
                                                class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Date de Fondation</label>
                                            <input 
                                                v-model="form.founded_date" 
                                                type="date" 
                                                class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                            />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <!-- Logo Upload / Preview -->
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Logo de l'OSC <span class="text-raosc-red">*</span></label>
                                            <div v-if="!logoPreview">
                                                <input 
                                                    id="logo-upload"
                                                    type="file"
                                                    accept="image/jpeg, image/png, image/webp"
                                                    :required="form.logo === null"
                                                    @change="handleLogoUpload"
                                                    class="block w-full text-xs text-zinc-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-raosc-green/10 file:text-raosc-green hover:file:bg-raosc-green/20 border border-zinc-200 dark:border-zinc-700 rounded-xl bg-zinc-50 dark:bg-zinc-900"
                                                />
                                            </div>
                                            <div v-else class="relative w-24 h-24 mt-2">
                                                <img :src="logoPreview" class="w-full h-full object-cover rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm" />
                                                <button type="button" @click="removeLogo" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-colors">
                                                    <X class="w-3 h-3" />
                                                </button>
                                            </div>
                                            <div v-if="form.errors.logo" class="text-raosc-red text-xs mt-1">{{ form.errors.logo }}</div>
                                        </div>

                                        <!-- Gallery Upload / Previews -->
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Images / Actions de l'OSC <span class="text-raosc-red">*</span></label>
                                            <input 
                                                id="gallery-upload"
                                                type="file"
                                                accept="image/jpeg, image/png, image/webp"
                                                multiple
                                                :required="form.gallery.length === 0"
                                                @change="handleGalleryUpload"
                                                class="block w-full text-xs text-zinc-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-raosc-green/10 file:text-raosc-green hover:file:bg-raosc-green/20 border border-zinc-200 dark:border-zinc-700 rounded-xl bg-zinc-50 dark:bg-zinc-900 mb-3"
                                            />
                                            <div v-if="galleryPreviews.length > 0" class="flex flex-wrap gap-3 mt-2">
                                                <div v-for="(preview, idx) in galleryPreviews" :key="idx" class="relative w-16 h-16">
                                                    <img :src="preview.url" class="w-full h-full object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm" />
                                                    <button type="button" @click="removeGalleryImage(idx)" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full p-0.5 shadow-md hover:bg-red-600 transition-colors">
                                                        <X class="w-3 h-3" />
                                                    </button>
                                                </div>
                                            </div>
                                            <div v-if="form.errors.gallery" class="text-raosc-red text-xs mt-1">{{ form.errors.gallery }}</div>
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
                                            v-model="form.email" 
                                            type="email" 
                                            required 
                                            placeholder="contact@votre-ong.org" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="form.errors.email" class="text-raosc-red text-xs mt-1">{{ form.errors.email }}</div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Téléphone</label>
                                        <CountryPhoneInput v-model="form.phone" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Site Web</label>
                                        <input 
                                            v-model="form.website" 
                                            type="url" 
                                            placeholder="https://www.mon-ong.org" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="form.errors.website" class="text-raosc-red text-xs mt-1">{{ form.errors.website }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Pays <span class="text-raosc-red">*</span></label>
                                        <input 
                                            v-model="form.country" 
                                            type="text" 
                                            required 
                                            placeholder="Bénin" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                        <div v-if="form.errors.country" class="text-raosc-red text-xs mt-1">{{ form.errors.country }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Ville <span class="text-raosc-red">*</span></label>
                                        <input 
                                            v-model="form.city" 
                                            type="text" 
                                            required 
                                            placeholder="Cotonou" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-2">Adresse détaillée</label>
                                        <input 
                                            v-model="form.address" 
                                            type="text" 
                                            placeholder="Rue, Quartier, Porte..." 
                                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl px-5 py-3 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                    </div>
                                </div>
                            </section>

                            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row justify-end gap-4">
                                <Link :href="isPublic ? '/rao' : '/dashboard/rao'">
                                    <Button type="button" variant="outline" class="w-full sm:w-auto rounded-full px-6 py-2.5 text-xs font-semibold border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                        Annuler
                                    </Button>
                                </Link>
                                <Button 
                                    type="submit" 
                                    :disabled="form.processing" 
                                    class="w-full sm:w-auto bg-raosc-green hover:bg-raosc-green/90 text-white rounded-full px-8 py-2.5 text-xs font-semibold shadow-md hover:shadow-lg transition-all"
                                >
                                    <span v-if="form.processing" class="flex items-center gap-2">Traitement en cours...</span>
                                    <span v-else class="flex items-center gap-2">Soumettre mon Dossier <ArrowRight class="w-4 h-4" /></span>
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