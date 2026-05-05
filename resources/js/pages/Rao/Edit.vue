<!-- OrganizationEdit.vue - Refonte Full Width -->
<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { 
    Building2, Info, ArrowRight, CheckCircle2, Save, X, 
    Calendar, MapPin, Phone, Mail, Globe, FileText, Briefcase, 
    AlertCircle, Upload, Users, Shield, Award, Camera, Image as ImageIcon,
    Trash2, Plus, ChevronDown, ChevronUp, HelpCircle
} from 'lucide-vue-next';
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
    logo?: string | null;
    member_count?: number | null;
    presentation_doc?: string | null;
    legal_docs?: string[] | null;
    responsible_name?: string | null;
    responsible_email?: string | null;
    responsible_phone?: string | null;
    responsible_photo?: string | null;
    responsible_id_doc?: string | null;
    vice_responsible_name?: string | null;
    vice_responsible_email?: string | null;
    vice_responsible_phone?: string | null;
    vice_responsible_photo?: string | null;
    vice_responsible_id_doc?: string | null;
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

// États
const logoPreview = ref<string | null>(org.logo ? (org.logo.startsWith('http') ? org.logo : `/storage/${org.logo}`) : null);
const galleryPreviews = ref<{file: File | null, url: string}[]>([]);
const isDragging = ref(false);
const showOtherCategory = ref(false);
const logoInput = ref<HTMLInputElement | null>(null);
const activeSection = ref('general');
const isSubmitting = ref(false);

// Navigation sections
const sections = [
    { id: 'general', label: 'Informations générales', icon: Building2 },
    { id: 'documents', label: 'Documents officiels', icon: FileText },
    { id: 'leadership', label: 'Équipe dirigeante', icon: Briefcase },
    { id: 'contact', label: 'Localisation & contact', icon: MapPin }
];

const scrollToSection = (sectionId: string) => {
    activeSection.value = sectionId;
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};

// Formulaire
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
    other_category: '',
    logo: null as File | null,
    gallery: [] as File[],
    member_count: org.member_count || null,
    presentation_doc: null as File | null,
    legal_docs: [] as File[],
    responsible_name: org.responsible_name || '',
    responsible_email: org.responsible_email || '',
    responsible_phone: org.responsible_phone || '',
    responsible_photo: null as File | null,
    responsible_id_doc: null as File | null,
    vice_responsible_name: org.vice_responsible_name || '',
    vice_responsible_email: org.vice_responsible_email || '',
    vice_responsible_phone: org.vice_responsible_phone || '',
    vice_responsible_photo: null as File | null,
    vice_responsible_id_doc: null as File | null,
});

// Computed
const hasChanges = computed(() => formData.isDirty);
const stats = computed(() => ({
    totalCategories: formData.categories.length,
    hasLogo: !!logoPreview.value,
    hasResponsible: !!formData.responsible_name
}));

// Méthodes
const triggerLogoUpload = () => {
    logoInput.value?.click();
};

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
    if (logoPreview.value && logoPreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(logoPreview.value);
    }
    logoPreview.value = null;
    if (logoInput.value) logoInput.value.value = '';
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
    const preview = galleryPreviews.value[index];
    if (preview.url.startsWith('blob:')) {
        URL.revokeObjectURL(preview.url);
    }
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

const onSubmit = () => {
    isSubmitting.value = true;
    formData.post(update(org.slug).url, {
        onFinish: () => {
            isSubmitting.value = false;
        }
    });
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Éditer votre organisation - RAOSC" />

        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION - MODERNE -->
            <!-- ============================================ -->
            <div class="relative bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 py-16 lg:py-20 overflow-hidden">
                <div class="absolute inset-0">
                    <div class="absolute top-0 left-1/4 w-96 h-96 bg-raosc-green opacity-20 rounded-full blur-[120px]"></div>
                    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-raosc-yellow opacity-10 rounded-full blur-[120px]"></div>
                </div>

                <div class="container mx-auto px-6 lg:px-12 relative z-10">
                    <div class="max-w-3xl mx-auto text-center">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
                            <Award class="w-4 h-4 text-raosc-yellow" />
                            <span class="text-[10px] font-bold tracking-wider text-raosc-yellow uppercase">Modification</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight mb-4">
                            Modifier <span class="text-raosc-yellow">{{ org.name }}</span>
                        </h1>
                        <p class="text-sm sm:text-base text-zinc-300 max-w-2xl mx-auto">
                            Mettez à jour les informations de votre structure pour rester visible auprès des partenaires.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- NAVIGATION PAR SECTIONS (STICKY) -->
            <!-- ============================================ -->
            <div class="sticky top-0 z-30 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="flex items-center justify-between overflow-x-auto py-3 gap-2">
                        <button
                            v-for="section in sections"
                            :key="section.id"
                            @click="scrollToSection(section.id)"
                            :class="[
                                'flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 whitespace-nowrap',
                                activeSection === section.id 
                                    ? 'bg-raosc-green text-white shadow-md' 
                                    : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800'
                            ]"
                        >
                            <component :is="section.icon" class="w-4 h-4" />
                            {{ section.label }}
                            <span v-if="section.id === 'general' && stats.totalCategories > 0" class="ml-1 text-xs">({{ stats.totalCategories }})</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- FORMULAIRE PRINCIPAL -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-10 pb-20">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Indicateur de modifications non sauvegardées -->
                    <div v-if="hasChanges" class="sticky top-16 z-20 mb-6 p-3 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-2 text-amber-700 dark:text-amber-400 text-sm">
                            <AlertCircle class="w-4 h-4" />
                            <span>Vous avez des modifications non enregistrées</span>
                        </div>
                        <Button type="button" @click="scrollToSection('general')" variant="outline" size="sm" class="text-xs">
                            Continuer l'édition
                        </Button>
                    </div>
                    
                    <form @submit.prevent="onSubmit" class="space-y-8">
                        
                        <!-- Erreurs globales -->
                        <div v-if="Object.keys(formData.errors).length > 0" class="p-5 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800 rounded-2xl">
                            <div class="flex items-center gap-2 text-red-600 font-semibold text-sm mb-3">
                                <AlertCircle class="w-5 h-5" />
                                Veuillez corriger les erreurs suivantes
                            </div>
                            <ul class="text-sm text-red-600/80 space-y-1 ml-6 list-disc">
                                <li v-for="(error, field) in formData.errors" :key="field">{{ error }}</li>
                            </ul>
                        </div>

                        <!-- ======================================== -->
                        <!-- SECTION 1: INFORMATIONS GÉNÉRALES -->
                        <!-- ======================================== -->
                        <section id="general" class="scroll-mt-24">
                            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                                <div class="px-6 py-4 bg-gradient-to-r from-raosc-green/5 to-transparent border-b border-zinc-200 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-raosc-green/10 flex items-center justify-center">
                                            <Building2 class="h-5 w-5 text-raosc-green" />
                                        </div>
                                        <div>
                                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Informations générales</h2>
                                            <p class="text-xs text-zinc-500">Identité et présentation de votre organisation</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6 space-y-5">
                                    <!-- Nom -->
                                    <div>
                                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                            Nom officiel <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            v-model="formData.name"
                                            type="text"
                                            required
                                            class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            :class="{ 'border-red-500': formData.errors.name }"
                                        />
                                        <p v-if="formData.errors.name" class="text-red-500 text-xs mt-1">{{ formData.errors.name }}</p>
                                    </div>

                                    <!-- Grille 2 colonnes -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <!-- N° enregistrement -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                N° Enregistrement
                                            </label>
                                            <input
                                                v-model="formData.registration_number"
                                                type="text"
                                                placeholder="Ex: 2024/001/MISP"
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            />
                                        </div>

                                        <!-- Date de fondation -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <Calendar class="w-4 h-4 inline mr-1" /> Date de fondation
                                            </label>
                                            <input
                                                v-model="formData.founded_date"
                                                type="date"
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            />
                                        </div>

                                        <!-- Nombre de membres -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <Users class="w-4 h-4 inline mr-1" /> Nombre de membres <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                v-model="formData.member_count"
                                                type="number"
                                                required
                                                min="1"
                                                placeholder="Ex: 25"
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            />
                                            <p v-if="formData.errors.member_count" class="text-red-500 text-xs mt-1">{{ formData.errors.member_count }}</p>
                                        </div>
                                    </div>

                                    <!-- Domaines d'intervention -->
                                    <div>
                                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                            Domaines d'intervention <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex flex-wrap gap-2 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                            <button
                                                v-for="cat in categories" 
                                                :key="cat.id"
                                                type="button"
                                                @click="toggleCategory(cat.id)"
                                                class="px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-300 border"
                                                :class="formData.categories.includes(cat.id) 
                                                    ? 'bg-raosc-green text-white border-raosc-green shadow-sm' 
                                                    : 'bg-white dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-600 hover:border-raosc-green/50 hover:scale-105'"
                                            >
                                                {{ cat.name }}
                                            </button>
                                            <button
                                                type="button"
                                                @click="showOtherCategory = !showOtherCategory"
                                                class="px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-300 border"
                                                :class="showOtherCategory || formData.other_category 
                                                    ? 'bg-raosc-yellow text-zinc-900 border-raosc-yellow shadow-sm' 
                                                    : 'bg-white dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-600 hover:border-raosc-yellow/50 hover:scale-105'"
                                            >
                                                Autre <Plus v-if="!showOtherCategory && !formData.other_category" class="w-3 h-3 inline ml-1" />
                                            </button>
                                        </div>
                                        <div v-if="showOtherCategory" class="mt-3">
                                            <input 
                                                v-model="formData.other_category" 
                                                type="text" 
                                                placeholder="Saisissez votre catégorie..." 
                                                class="w-full h-10 px-4 rounded-xl border-2 border-raosc-yellow/30 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-yellow outline-none transition-all"
                                            />
                                        </div>
                                        <p v-if="formData.errors.categories" class="text-red-500 text-xs mt-1">{{ formData.errors.categories }}</p>
                                    </div>

                                    <!-- Résumé -->
                                    <div>
                                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                            Résumé de mission <span class="text-red-500">*</span>
                                        </label>
                                        <textarea
                                            v-model="formData.short_description"
                                            required
                                            rows="2"
                                            placeholder="Décrivez en quelques mots l'essence de votre engagement..."
                                            class="w-full px-4 py-3 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all resize-none"
                                            :class="{ 'border-red-500': formData.errors.short_description }"
                                        ></textarea>
                                        <p v-if="formData.errors.short_description" class="text-red-500 text-xs mt-1">{{ formData.errors.short_description }}</p>
                                    </div>

                                    <!-- Description détaillée -->
                                    <div>
                                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                            <FileText class="w-4 h-4 inline mr-1" /> Description détaillée
                                        </label>
                                        <textarea
                                            v-model="formData.description"
                                            rows="4"
                                            placeholder="Objectifs, historique, réalisations majeures..."
                                            class="w-full px-4 py-3 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all resize-y"
                                        ></textarea>
                                    </div>

                                    <!-- Logo et galerie -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <!-- Logo -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <Camera class="w-4 h-4 inline mr-1" /> Logo
                                            </label>
                                            <div 
                                                @dragover.prevent="isDragging = true"
                                                @dragleave.prevent="isDragging = false"
                                                @drop.prevent="handleLogoDrop"
                                                @click="triggerLogoUpload"
                                                :class="[
                                                    'border-2 border-dashed rounded-xl p-4 text-center transition-all duration-300 cursor-pointer',
                                                    logoPreview ? 'border-raosc-green bg-raosc-green/5' : 'border-zinc-300 dark:border-zinc-600 hover:border-raosc-green hover:bg-raosc-green/5',
                                                    isDragging ? 'border-raosc-green bg-raosc-green/10 scale-[0.99]' : ''
                                                ]"
                                            >
                                                <div v-if="logoPreview" class="relative inline-block">
                                                    <img :src="logoPreview" class="h-24 w-auto max-w-full object-contain rounded-lg mx-auto" />
                                                    <button type="button" @click.stop="removeLogo" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                                        <Trash2 class="w-3 h-3" />
                                                    </button>
                                                </div>
                                                <div v-else class="flex flex-col items-center gap-2">
                                                    <Upload class="w-8 h-8 text-zinc-400" />
                                                    <p class="text-xs text-zinc-500">Glissez ou cliquez</p>
                                                    <p class="text-[10px] text-zinc-400">PNG, JPG, WEBP (max 2MB)</p>
                                                </div>
                                                <input ref="logoInput" type="file" accept="image/jpeg, image/png, image/webp" @change="handleLogoUpload" class="hidden" />
                                            </div>
                                            <p v-if="org.logo" class="text-xs text-raosc-green mt-1 flex items-center gap-1">
                                                <CheckCircle2 class="w-3 h-3" /> Logo actuel conservé
                                            </p>
                                            <p v-if="formData.errors.logo" class="text-red-500 text-xs mt-1">{{ formData.errors.logo }}</p>
                                        </div>

                                        <!-- Galerie -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <ImageIcon class="w-4 h-4 inline mr-1" /> Ajouter à la galerie
                                            </label>
                                            <input
                                                type="file"
                                                accept="image/jpeg, image/png, image/webp"
                                                multiple
                                                @change="handleGalleryUpload"
                                                class="w-full text-sm text-zinc-500 dark:text-zinc-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-raosc-green/10 file:text-raosc-green hover:file:bg-raosc-green/20 border-2 border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 p-2"
                                            />
                                            <div v-if="galleryPreviews.length > 0" class="flex flex-wrap gap-2 mt-3">
                                                <div v-for="(preview, idx) in galleryPreviews.slice(0, 8)" :key="idx" class="relative w-16 h-16 group">
                                                    <img :src="preview.url" class="w-full h-full object-cover rounded-lg border border-zinc-200 dark:border-zinc-700" />
                                                    <button type="button" @click="removeGalleryImage(idx)" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                                                        <Trash2 class="w-2.5 h-2.5" />
                                                    </button>
                                                </div>
                                                <div v-if="galleryPreviews.length > 8" class="w-16 h-16 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                                                    +{{ galleryPreviews.length - 8 }}
                                                </div>
                                            </div>
                                            <p class="text-xs text-zinc-400 mt-1">Nouvelles images à ajouter (max 10)</p>
                                            <p v-if="formData.errors.gallery" class="text-red-500 text-xs mt-1">{{ formData.errors.gallery }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- ======================================== -->
                        <!-- SECTION 2: DOCUMENTS OFFICIELS -->
                        <!-- ======================================== -->
                        <section id="documents" class="scroll-mt-24">
                            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                                <div class="px-6 py-4 bg-gradient-to-r from-blue-500/5 to-transparent border-b border-zinc-200 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                                            <FileText class="h-5 w-5 text-blue-500" />
                                        </div>
                                        <div>
                                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Documents officiels</h2>
                                            <p class="text-xs text-zinc-500">Justificatifs de l'existence légale de votre organisation</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6 space-y-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <!-- Document de présentation -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                Document de présentation
                                            </label>
                                            <input
                                                type="file"
                                                accept=".pdf,.doc,.docx"
                                                @input="formData.presentation_doc = ($event.target as HTMLInputElement).files?.[0] || null"
                                                class="w-full text-sm text-zinc-500 dark:text-zinc-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500/10 file:text-blue-600 hover:file:bg-blue-500/20 border-2 border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 p-2"
                                            />
                                            <p v-if="org.presentation_doc" class="text-xs text-raosc-green mt-1 flex items-center gap-1">
                                                <CheckCircle2 class="w-3 h-3" /> Document déjà présent
                                            </p>
                                            <p class="text-xs text-zinc-400 mt-1">📄 Visible par le public sur votre profil</p>
                                        </div>

                                        <!-- Documents légaux -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                Preuves d'existence légale <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="file"
                                                multiple
                                                required
                                                accept=".pdf,.doc,.docx,image/*"
                                                @input="formData.legal_docs = Array.from(($event.target as HTMLInputElement).files || [])"
                                                class="w-full text-sm text-zinc-500 dark:text-zinc-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-600/10 file:text-zinc-600 hover:file:bg-zinc-600/20 border-2 border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 p-2"
                                            />
                                            <p class="text-xs text-zinc-400 mt-1">🔒 Privé : Statuts, récépissé, etc.</p>
                                            <p v-if="formData.errors.legal_docs" class="text-red-500 text-xs mt-1">{{ formData.errors.legal_docs }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- ======================================== -->
                        <!-- SECTION 3: ÉQUIPE DIRIGEANTE -->
                        <!-- ======================================== -->
                        <section id="leadership" class="scroll-mt-24">
                            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                                <div class="px-6 py-4 bg-gradient-to-r from-red-500/5 to-transparent border-b border-zinc-200 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-red-500/10 flex items-center justify-center">
                                            <Briefcase class="h-5 w-5 text-red-500" />
                                        </div>
                                        <div>
                                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Équipe dirigeante</h2>
                                            <p class="text-xs text-zinc-500">Informations sur les responsables légaux</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6 space-y-6">
                                    <!-- Responsable principal -->
                                    <div class="p-5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                        <h3 class="text-base font-bold text-raosc-green mb-4 flex items-center gap-2">
                                            <Shield class="w-4 h-4" /> Responsable principal <span class="text-red-500 text-sm">*</span>
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Nom complet</label>
                                                <input v-model="formData.responsible_name" type="text" required class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-green outline-none transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Email (privé)</label>
                                                <input v-model="formData.responsible_email" type="email" required class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-green outline-none transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Téléphone (privé)</label>
                                                <input v-model="formData.responsible_phone" type="tel" required class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-green outline-none transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Photo (publique)</label>
                                                <input type="file" accept="image/*" @input="formData.responsible_photo = ($event.target as HTMLInputElement).files?.[0] || null" class="w-full text-sm border-2 border-zinc-200 dark:border-zinc-700 rounded-xl p-1.5 bg-white dark:bg-zinc-800" />
                                                <p v-if="org.responsible_photo" class="text-[10px] text-raosc-green mt-1">Photo déjà présente</p>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Pièce d'identité (privé)</label>
                                                <input type="file" accept=".pdf,image/*" @input="formData.responsible_id_doc = ($event.target as HTMLInputElement).files?.[0] || null" class="w-full text-sm border-2 border-zinc-200 dark:border-zinc-700 rounded-xl p-1.5 bg-white dark:bg-zinc-800" />
                                                <p v-if="org.responsible_id_doc" class="text-[10px] text-raosc-green mt-1 flex items-center gap-1">
                                                    <CheckCircle2 class="w-2.5 h-2.5" /> Document déjà présent
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vice-responsable (optionnel) -->
                                    <div class="p-5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                        <h3 class="text-base font-bold text-zinc-500 mb-4 flex items-center gap-2">
                                            <Users class="w-4 h-4" /> Vice-responsable (optionnel)
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Nom complet</label>
                                                <input v-model="formData.vice_responsible_name" type="text" class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-green outline-none transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Email (privé)</label>
                                                <input v-model="formData.vice_responsible_email" type="email" class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-green outline-none transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Téléphone (privé)</label>
                                                <input v-model="formData.vice_responsible_phone" type="tel" class="w-full h-11 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:border-raosc-green outline-none transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Photo (publique)</label>
                                                <input type="file" accept="image/*" @input="formData.vice_responsible_photo = ($event.target as HTMLInputElement).files?.[0] || null" class="w-full text-sm border-2 border-zinc-200 dark:border-zinc-700 rounded-xl p-1.5 bg-white dark:bg-zinc-800" />
                                                <p v-if="org.vice_responsible_photo" class="text-[10px] text-raosc-green mt-1">Photo déjà présente</p>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-zinc-500 uppercase mb-1">Pièce d'identité (privé)</label>
                                                <input type="file" accept=".pdf,image/*" @input="formData.vice_responsible_id_doc = ($event.target as HTMLInputElement).files?.[0] || null" class="w-full text-sm border-2 border-zinc-200 dark:border-zinc-700 rounded-xl p-1.5 bg-white dark:bg-zinc-800" />
                                                <p v-if="org.vice_responsible_id_doc" class="text-[10px] text-raosc-green mt-1 flex items-center gap-1">
                                                    <CheckCircle2 class="w-2.5 h-2.5" /> Document déjà présent
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- ======================================== -->
                        <!-- SECTION 4: LOCALISATION & CONTACT -->
                        <!-- ======================================== -->
                        <section id="contact" class="scroll-mt-24">
                            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                                <div class="px-6 py-4 bg-gradient-to-r from-yellow-500/5 to-transparent border-b border-zinc-200 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                                            <MapPin class="h-5 w-5 text-yellow-600" />
                                        </div>
                                        <div>
                                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Localisation & contact</h2>
                                            <p class="text-xs text-zinc-500">Coordonnées de votre organisation</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <!-- Email -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <Mail class="w-4 h-4 inline mr-1" /> Email <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                v-model="formData.email"
                                                type="email"
                                                required
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                                :class="{ 'border-red-500': formData.errors.email }"
                                            />
                                            <p v-if="formData.errors.email" class="text-red-500 text-xs mt-1">{{ formData.errors.email }}</p>
                                        </div>

                                        <!-- Téléphone -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <Phone class="w-4 h-4 inline mr-1" /> Téléphone
                                            </label>
                                            <CountryPhoneInput v-model="formData.phone" />
                                        </div>

                                        <!-- Site web -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <Globe class="w-4 h-4 inline mr-1" /> Site web
                                            </label>
                                            <input
                                                v-model="formData.website"
                                                type="url"
                                                placeholder="https://www.mon-ong.org"
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            />
                                        </div>

                                        <!-- Pays -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                <MapPin class="w-4 h-4 inline mr-1" /> Pays <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                v-model="formData.country"
                                                type="text"
                                                required
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                                :class="{ 'border-red-500': formData.errors.country }"
                                            />
                                            <p v-if="formData.errors.country" class="text-red-500 text-xs mt-1">{{ formData.errors.country }}</p>
                                        </div>

                                        <!-- Ville -->
                                        <div>
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                Ville <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                v-model="formData.city"
                                                type="text"
                                                required
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            />
                                        </div>

                                        <!-- Adresse -->
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                                Adresse détaillée
                                            </label>
                                            <input
                                                v-model="formData.address"
                                                type="text"
                                                placeholder="Rue, quartier, numéro..."
                                                class="w-full h-12 px-4 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- ======================================== -->
                        <!-- BOUTONS D'ACTION -->
                        <!-- ======================================== -->
                        <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                            <Link :href="isPublic ? raoIndex().url : dashboardRao().url">
                                <Button type="button" variant="outline" class="w-full sm:w-auto rounded-xl px-8 py-6 text-sm font-semibold border-2 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all duration-300">
                                    Annuler
                                </Button>
                            </Link>
                            <Button
                                type="submit"
                                :disabled="formData.processing || isSubmitting"
                                class="w-full sm:w-auto bg-raosc-green hover:bg-raosc-green/90 text-white rounded-xl px-10 py-6 text-sm font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 disabled:opacity-60 disabled:hover:scale-100"
                            >
                                <span v-if="formData.processing || isSubmitting" class="flex items-center gap-2">
                                    <span class="animate-spin">⏳</span> Enregistrement...
                                </span>
                                <span v-else class="flex items-center gap-2">
                                    <Save class="w-4 h-4" />
                                    Enregistrer les modifications
                                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                                </span>
                            </Button>
                        </div>
                    </form>

                    <!-- Charte de confiance -->
                    <div class="mt-12 text-center">
                        <div class="inline-flex items-center justify-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-raosc-green">
                                <CheckCircle2 class="h-6 w-6" />
                            </div>
                        </div>
                        <p class="text-[11px] font-bold tracking-[0.2em] text-zinc-400 uppercase mb-2">Charte de confiance</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 max-w-lg mx-auto leading-relaxed">
                            En soumettant ce formulaire, vous certifiez que les informations fournies sont exactes et à jour.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>

<style scoped>
.scroll-mt-24 {
    scroll-margin-top: 100px;
}

/* Animations */
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

/* Spinner animation */
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>