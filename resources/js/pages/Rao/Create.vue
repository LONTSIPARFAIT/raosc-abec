<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Building2, Info, ArrowRight, CheckCircle2, X, Upload, Calendar, MapPin, Phone, Mail, Globe, FileText, Briefcase } from 'lucide-vue-next';
import CountryPhoneInput from '@/components/CountryPhoneInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { store, index as raoIndex } from '@/actions/App/Http/Controllers/RaoController';
import { index as dashboardRao } from '@/actions/App/Http/Controllers/DashboardController';

interface Category {
    id: number;
    name: string;
}

const {
    categories = [],
    isPublic = false
} = defineProps<{
    categories?: Category[];
    isPublic?: boolean;
}>();

const logoPreview = ref<string | null>(null);
const galleryPreviews = ref<{file: File, url: string}[]>([]);
const isDragging = ref(false);

const formData = useForm({
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

const handleLogoUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        formData.logo = target.files[0];
        logoPreview.value = URL.createObjectURL(target.files[0]);
    }
};

const handleLogoDrop = (e: DragEvent) => {
    e.preventDefault();
    isDragging.value = false;
    const files = e.dataTransfer?.files;
    if (files && files.length > 0) {
        formData.logo = files[0];
        logoPreview.value = URL.createObjectURL(files[0]);
    }
};

const removeLogo = () => {
    formData.logo = null;
    if (logoPreview.value) {
        URL.revokeObjectURL(logoPreview.value);
        logoPreview.value = null;
    }
    const input = document.getElementById('logo-upload') as HTMLInputElement;
    if (input) input.value = '';
};

const handleGalleryUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const newFiles = Array.from(target.files);
        const maxFiles = 10 - formData.gallery.length;
        const filesToAdd = newFiles.slice(0, maxFiles);
        
        for(const file of filesToAdd) {
            formData.gallery.push(file);
            galleryPreviews.value.push({ file, url: URL.createObjectURL(file) });
        }
        target.value = '';
    }
};

const removeGalleryImage = (index: number) => {
    URL.revokeObjectURL(galleryPreviews.value[index].url);
    formData.gallery.splice(index, 1);
    galleryPreviews.value.splice(index, 1);
};

const toggleCategory = (id: number) => {
    const index = formData.categories.indexOf(id);
    if (index === -1) {
        formData.categories.push(id);
    } else {
        formData.categories.splice(index, 1);
    }
};

const resetForm = () => {
    formData.reset();
    removeLogo();
    galleryPreviews.value.forEach(p => URL.revokeObjectURL(p.url));
    galleryPreviews.value = [];
    formData.categories = [];
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Enregistrer une organisation - RAOSC" />

        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 pb-24">
            
            <!-- Effets de fond subtils -->
            <div class="fixed inset-0 pointer-events-none opacity-20 dark:opacity-5">
                <div class="absolute top-20 -left-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-green)"></div>
                <div class="absolute bottom-20 -right-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-yellow)"></div>
            </div>

            <!-- Header Section -->
            <div class="relative bg-zinc-950 py-16 sm:py-20 lg:py-24 px-6 overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-10 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-6 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/10 backdrop-blur-sm px-4 py-2 border border-white/20">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Adhésion Réseau</span>
                        </div>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight mb-4">
                        Inscrire votre <span class="text-raosc-yellow">Organisation</span>
                    </h1>
                    <p class="text-sm sm:text-base text-zinc-400 max-w-2xl mx-auto font-medium">
                        Rejoignez le Réseau Africain pour amplifier votre impact et accéder à des partenariats stratégiques.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-4xl px-4 sm:px-6 -mt-8 sm:-mt-10 relative z-20">
                <Card class="shadow-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl sm:rounded-3xl overflow-hidden">
                    <CardContent class="p-6 sm:p-8 lg:p-10">
                        <form @submit.prevent="formData.post(store().url)" class="space-y-8 sm:space-y-10">
                            
                            <!-- Erreurs globales -->
                            <div v-if="Object.keys(formData.errors).length > 0" class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl">
                                <div class="flex items-center gap-2 text-raosc-red font-semibold text-sm mb-2">
                                    <span class="text-base">⚠️</span>
                                    Veuillez corriger les erreurs
                                </div>
                                <ul class="text-xs text-raosc-red/80 space-y-1 ml-6 list-disc">
                                    <li v-for="(error, field) in formData.errors" :key="field">{{ error }}</li>
                                </ul>
                            </div>

                            <!-- Informations Générales -->
                            <section>
                                <div class="flex items-center gap-3 mb-6 pb-3 border-b border-zinc-200 dark:border-zinc-800">
                                    <div class="h-9 w-9 rounded-lg bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                                        <Building2 class="h-4 w-4" />
                                    </div>
                                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Identité de l'OSC</h2>
                                </div>

                                <div class="space-y-5">
                                    <!-- Nom -->
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            Nom officiel <span class="text-raosc-red">*</span>
                                        </label>
                                        <input
                                            v-model="formData.name"
                                            type="text"
                                            required
                                            placeholder="Ex: Développement Pour Tous"
                                            class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                            :class="{ 'border-raosc-red': formData.errors.name }"
                                        />
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.name" class="text-raosc-red text-xs mt-1">{{ formData.errors.name }}</p>
                                        </Transition>
                                    </div>

                                    <!-- Domaines d'intervention -->
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            Domaines d'intervention <span class="text-raosc-red">*</span>
                                        </label>
                                        <div class="flex flex-wrap gap-2 p-4 bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                            <button
                                                v-for="cat in categories"
                                                :key="cat.id"
                                                type="button"
                                                @click="toggleCategory(cat.id)"
                                                class="px-3 py-1.5 rounded-full text-[11px] font-semibold transition-all duration-300 border"
                                                :class="formData.categories.includes(cat.id) 
                                                    ? 'bg-raosc-green text-white border-raosc-green shadow-sm' 
                                                    : 'bg-white dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-600 hover:border-raosc-green/50 hover:scale-105'"
                                            >
                                                {{ cat.name }}
                                            </button>
                                        </div>
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.categories" class="text-raosc-red text-xs mt-1">{{ formData.errors.categories }}</p>
                                        </Transition>
                                    </div>

                                    <!-- Résumé -->
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            Résumé de mission <span class="text-raosc-red">*</span>
                                        </label>
                                        <textarea
                                            v-model="formData.short_description"
                                            required
                                            rows="2"
                                            placeholder="Décrivez en quelques mots l'essence de votre engagement..."
                                            class="w-full px-4 py-2.5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300 resize-none"
                                            :class="{ 'border-raosc-red': formData.errors.short_description }"
                                        ></textarea>
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.short_description" class="text-raosc-red text-xs mt-1">{{ formData.errors.short_description }}</p>
                                        </Transition>
                                    </div>

                                    <!-- Description détaillée -->
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            <FileText class="w-3 h-3 inline mr-1" /> Description détaillée
                                        </label>
                                        <textarea
                                            v-model="formData.description"
                                            rows="4"
                                            placeholder="Objectifs, historique, réalisations majeures..."
                                            class="w-full px-4 py-2.5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300 resize-y"
                                        ></textarea>
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.description" class="text-raosc-red text-xs mt-1">{{ formData.errors.description }}</p>
                                        </Transition>
                                    </div>

                                    <!-- Enregistrement et Date -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                                N° Enregistrement Officiel
                                            </label>
                                            <input
                                                v-model="formData.registration_number"
                                                type="text"
                                                placeholder="Ex: 2024/001/MISP/..."
                                                class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                                <Calendar class="w-3 h-3 inline mr-1" /> Date de Fondation
                                            </label>
                                            <input
                                                v-model="formData.founded_date"
                                                type="date"
                                                class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                            />
                                        </div>
                                    </div>

                                    <!-- Logo et Galerie -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <!-- Logo -->
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                                <Upload class="w-3 h-3 inline mr-1" /> Logo <span class="text-raosc-red">*</span>
                                            </label>
                                            <div 
                                                @dragover.prevent="isDragging = true"
                                                @dragleave.prevent="isDragging = false"
                                                @drop.prevent="handleLogoDrop"
                                                :class="['border-2 border-dashed rounded-xl p-4 text-center transition-all duration-300 cursor-pointer',
                                                    logoPreview ? 'border-raosc-green bg-raosc-green/5' : 'border-zinc-300 dark:border-zinc-600 hover:border-raosc-green hover:bg-raosc-green/5',
                                                    isDragging ? 'border-raosc-green bg-raosc-green/10 scale-[0.99]' : '']"
                                                @click="() => document.getElementById('logo-upload')?.click()">
                                                <div v-if="logoPreview" class="relative inline-block">
                                                    <img :src="logoPreview" class="h-24 w-full object-cover rounded-lg" />
                                                    <button type="button" @click.stop="removeLogo" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                                        <X class="w-3 h-3" />
                                                    </button>
                                                </div>
                                                <div v-else class="flex flex-col items-center gap-2">
                                                    <Upload class="w-6 h-6 text-zinc-400" />
                                                    <p class="text-xs text-zinc-500">Glissez ou cliquez</p>
                                                    <p class="text-[10px] text-zinc-400">PNG, JPG, WEBP</p>
                                                </div>
                                                <input id="logo-upload" type="file" accept="image/jpeg, image/png, image/webp" :required="formData.logo === null" @change="handleLogoUpload" class="hidden" />
                                            </div>
                                            <Transition name="slide-down">
                                                <p v-if="formData.errors.logo" class="text-raosc-red text-xs mt-1">{{ formData.errors.logo }}</p>
                                            </Transition>
                                        </div>

                                        <!-- Galerie -->
                                        <div>
                                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                                <Upload class="w-3 h-3 inline mr-1" /> Galerie photos <span class="text-raosc-red">*</span>
                                            </label>
                                            <input
                                                id="gallery-upload"
                                                type="file"
                                                accept="image/jpeg, image/png, image/webp"
                                                multiple
                                                :required="formData.gallery.length === 0"
                                                @change="handleGalleryUpload"
                                                class="w-full text-xs text-zinc-500 dark:text-zinc-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-raosc-green/10 file:text-raosc-green hover:file:bg-raosc-green/20 border-2 border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800"
                                            />
                                            <div v-if="galleryPreviews.length > 0" class="flex flex-wrap gap-2 mt-3">
                                                <div v-for="(preview, idx) in galleryPreviews" :key="idx" class="relative w-14 h-14 group">
                                                    <img :src="preview.url" class="w-full h-full object-cover rounded-lg border border-zinc-200 dark:border-zinc-700" />
                                                    <button type="button" @click="removeGalleryImage(idx)" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                                                        <X class="w-2.5 h-2.5" />
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-zinc-400 mt-1">Jusqu'à 10 images</p>
                                            <Transition name="slide-down">
                                                <p v-if="formData.errors.gallery" class="text-raosc-red text-xs mt-1">{{ formData.errors.gallery }}</p>
                                            </Transition>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Coordonnées -->
                            <section>
                                <div class="flex items-center gap-3 mb-6 pb-3 border-b border-zinc-200 dark:border-zinc-800">
                                    <div class="h-9 w-9 rounded-lg bg-raosc-yellow/10 flex items-center justify-center text-raosc-yellow">
                                        <Info class="h-4 w-4" />
                                    </div>
                                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Localisation & Contact</h2>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            <Mail class="w-3 h-3 inline mr-1" /> Email <span class="text-raosc-red">*</span>
                                        </label>
                                        <input
                                            v-model="formData.email"
                                            type="email"
                                            required
                                            placeholder="contact@votre-ong.org"
                                            class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                            :class="{ 'border-raosc-red': formData.errors.email }"
                                        />
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.email" class="text-raosc-red text-xs mt-1">{{ formData.errors.email }}</p>
                                        </Transition>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            <Phone class="w-3 h-3 inline mr-1" /> Téléphone
                                        </label>
                                        <CountryPhoneInput v-model="formData.phone" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            <Globe class="w-3 h-3 inline mr-1" /> Site Web
                                        </label>
                                        <input
                                            v-model="formData.website"
                                            type="url"
                                            placeholder="https://www.mon-ong.org"
                                            class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        />
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.website" class="text-raosc-red text-xs mt-1">{{ formData.errors.website }}</p>
                                        </Transition>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            <MapPin class="w-3 h-3 inline mr-1" /> Pays <span class="text-raosc-red">*</span>
                                        </label>
                                        <input
                                            v-model="formData.country"
                                            type="text"
                                            required
                                            placeholder="Bénin"
                                            class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                            :class="{ 'border-raosc-red': formData.errors.country }"
                                        />
                                        <Transition name="slide-down">
                                            <p v-if="formData.errors.country" class="text-raosc-red text-xs mt-1">{{ formData.errors.country }}</p>
                                        </Transition>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            Ville <span class="text-raosc-red">*</span>
                                        </label>
                                        <input
                                            v-model="formData.city"
                                            type="text"
                                            required
                                            placeholder="Cotonou"
                                            class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        />
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                                            <MapPin class="w-3 h-3 inline mr-1" /> Adresse détaillée
                                        </label>
                                        <input
                                            v-model="formData.address"
                                            type="text"
                                            placeholder="Rue, Quartier, Porte..."
                                            class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        />
                                    </div>
                                </div>
                            </section>

                            <!-- Actions -->
                            <div class="pt-6 border-t-2 border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row justify-end gap-3">
                                <Link :href="isPublic ? raoIndex().url : dashboardRao().url">
                                    <Button type="button" variant="outline" class="w-full sm:w-auto rounded-xl px-6 py-2.5 text-xs font-semibold border-2 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all duration-300">
                                        Annuler
                                    </Button>
                                </Link>
                                <Button
                                    type="submit"
                                    :disabled="formData.processing"
                                    class="w-full sm:w-auto bg-raosc-green hover:bg-raosc-green/90 text-white rounded-xl px-8 py-2.5 text-xs font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-60 disabled:hover:scale-100"
                                >
                                    <span v-if="formData.processing" class="flex items-center gap-2">
                                        <span class="animate-pulse">⏳</span> Traitement...
                                    </span>
                                    <span v-else class="flex items-center gap-2">
                                        Soumettre <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" />
                                    </span>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>

                <!-- Charte -->
                <div class="mt-10 text-center flex flex-col items-center">
                    <div class="h-8 w-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-raosc-green mb-3">
                        <CheckCircle2 class="h-4 w-4" />
                    </div>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-zinc-400 uppercase mb-1">Charte de confiance</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 max-w-lg leading-relaxed">En soumettant ce formulaire, vous certifiez que l'organisation existe légalement et que vous avez l'autorité pour l'inscrire au RAOSC.</p>
                </div>
            </div>
        </div>
    </component>
</template>

<style scoped>
.slide-down-enter-active {
    transition: all 0.2s ease-out;
}

.slide-down-leave-active {
    transition: all 0.15s ease-in;
}

.slide-down-enter-from {
    transform: translateY(-10px);
    opacity: 0;
}

.slide-down-leave-to {
    transform: translateY(-5px);
    opacity: 0;
}
</style>