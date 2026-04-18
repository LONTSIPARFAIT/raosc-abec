<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { 
    PlusCircle, Target, Users, Trash2, ShieldAlert, 
    Calendar, TrendingUp, Heart, Briefcase, Clock, X, 
    ArrowRight, Upload, Image, AlertCircle, CheckCircle,
    Filter, LayoutGrid, List
} from 'lucide-vue-next';
import { store, destroy } from '@/actions/App/Http/Controllers/Dashboard/ProjectController';
import { create as joinRao } from '@/actions/App/Http/Controllers/RaoController';

interface Project {
    id: number;
    title: string;
    type: 'projet' | 'benevolat';
    description: string;
    status: 'active' | 'completed';
    created_at?: string;
    cover_image?: string | null;
}

const {
    projects = [],
    organization = null,
    organizations = [],
    organizationId = null
} = defineProps<{
    projects?: Project[];
    organization?: any;
    organizations?: any[];
    organizationId?: number | null;
}>();

const isFormOpen = ref(false);
const isDeleting = ref<number | null>(null);
const activeFilter = ref<'all' | 'projet' | 'benevolat'>('all');
const viewMode = ref<'grid' | 'list'>('grid');

const filteredProjects = () => {
    if (activeFilter.value === 'all') return projects;
    return projects.filter(p => p.type === activeFilter.value);
};

const projectFormData = useForm({
    organization_id: organizationId || (organizations.length > 0 ? organizations[0].id : null),
    title: '',
    type: 'projet' as 'projet' | 'benevolat',
    description: '',
    status: 'active' as 'active' | 'completed',
    cover_image: null as File | null,
    gallery: [] as File[],
});

const coverPreview = ref<string | null>(null);
const galleryPreviews = ref<string[]>([]);
const isDragging = ref(false);

const handleImageUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        projectFormData.cover_image = target.files[0];
        coverPreview.value = URL.createObjectURL(target.files[0]);
    }
};

const handleDrop = (e: DragEvent) => {
    e.preventDefault();
    isDragging.value = false;
    const files = e.dataTransfer?.files;
    if (files && files.length > 0) {
        projectFormData.cover_image = files[0];
        coverPreview.value = URL.createObjectURL(files[0]);
    }
};

const handleGalleryUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        const files = Array.from(target.files);
        const maxFiles = 10 - projectFormData.gallery.length;
        const newFiles = files.slice(0, maxFiles);
        projectFormData.gallery.push(...newFiles);
        galleryPreviews.value.push(...newFiles.map(file => URL.createObjectURL(file)));
    }
};

const removeCoverImage = () => {
    projectFormData.cover_image = null;
    if (coverPreview.value) {
        URL.revokeObjectURL(coverPreview.value);
        coverPreview.value = null;
    }
};

const removeGalleryImage = (index: number) => {
    URL.revokeObjectURL(galleryPreviews.value[index]);
    projectFormData.gallery.splice(index, 1);
    galleryPreviews.value.splice(index, 1);
};

const resetForm = () => {
    isFormOpen.value = false;
    removeCoverImage();
    galleryPreviews.value.forEach(url => URL.revokeObjectURL(url));
    galleryPreviews.value = [];
    projectFormData.gallery = [];
    projectFormData.title = '';
    projectFormData.description = '';
    projectFormData.type = 'projet';
    projectFormData.status = 'active';
    projectFormData.errors = {};
};

const deleteProject = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir retirer cet engagement public ?')) {
        isDeleting.value = id;
        useForm({}).delete(destroy(id).url, {
            preserveScroll: true,
            onFinish: () => { isDeleting.value = null; }
        });
    }
};

const formatDate = (date?: string) => {
    if (!date) return 'Ajouté récemment';
    return new Date(date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
};

const stats = {
    total: projects.length,
    active: projects.filter(p => p.status === 'active').length,
    projets: projects.filter(p => p.type === 'projet').length,
    benevolats: projects.filter(p => p.type === 'benevolat').length
};
</script>

<template>
    <AppLayout>
        <Head title="Gestion Projets & Bénévolat" />

        <div class="min-h-screen bg-gradient-to-br from-zinc-50 via-white to-zinc-50 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 p-4 sm:p-6 lg:p-10">
            
            <!-- Effets de fond -->
            <div class="fixed inset-0 pointer-events-none opacity-30 dark:opacity-10">
                <div class="absolute top-20 -left-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-green)"></div>
                <div class="absolute bottom-20 -right-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-yellow)"></div>
            </div>

            <!-- Pas d'organisation -->
            <div v-if="organizations.length === 0" class="max-w-2xl mx-auto mt-10 animate-fade-in">
                <div class="backdrop-blur-xl bg-white/90 dark:bg-zinc-900/90 rounded-3xl p-10 sm:p-12 text-center shadow-2xl border border-red-200/50 dark:border-red-800/50">
                    <div class="h-20 w-20 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-500/20 dark:to-red-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <ShieldAlert class="w-10 h-10 text-raosc-red" />
                    </div>
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">Organisation Requise</h2>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-8">
                        Vous devez d'abord lier votre compte à une organisation civile valide avant de pouvoir publier des initiatives.
                    </p>
                    <Link :href="joinRao().url" 
                        class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-raosc-red to-red-600 text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-xl transition-all duration-300">
                        Inscrire mon organisation
                    </Link>
                </div>
            </div>

            <!-- Contenu principal -->
            <div v-else class="space-y-6 sm:space-y-8">
                <!-- En-tête -->
                <div class="sticky top-6 z-10 backdrop-blur-md bg-white/80 dark:bg-zinc-900/80 border border-zinc-200/50 dark:border-zinc-800/50 rounded-2xl sm:rounded-3xl p-5 sm:p-8 shadow-lg transition-all duration-300">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="h-px w-6 sm:w-8 bg-raosc-green"></div>
                                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-raosc-green">Initiatives d'impact</p>
                            </div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-zinc-900 dark:text-white">Projets & Bénévolats</h1>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <div v-if="organizations.length > 1" class="flex items-center gap-2">
                                    <Filter class="w-3.5 h-3.5 text-zinc-500" />
                                    <select 
                                        :value="organizationId" 
                                        @change="(e: any) => $inertia.visit(`?organization_id=${e.target.value}`, { preserveScroll: true })"
                                        class="text-xs font-medium bg-zinc-100 dark:bg-zinc-800 border-0 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-raosc-green"
                                    >
                                        <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                    </select>
                                </div>
                                <!-- Stats rapides -->
                                <div class="flex gap-3 text-[10px] sm:text-xs">
                                    <span class="px-2 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-full">{{ stats.total }} total</span>
                                    <span class="px-2 py-1 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-full">{{ stats.active }} actifs</span>
                                </div>
                            </div>
                        </div>
                        <button 
                            @click="isFormOpen = true" 
                            class="group flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm hover:scale-105 hover:shadow-xl transition-all duration-300 w-full sm:w-auto justify-center"
                        >
                            <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                            Nouvelle initiative
                        </button>
                    </div>
                </div>

                <!-- Formulaire -->
                <Transition name="slide-fade">
                    <div v-if="isFormOpen" class="backdrop-blur-md bg-white/95 dark:bg-zinc-900/95 border border-zinc-200/50 dark:border-zinc-800/50 rounded-2xl sm:rounded-3xl p-5 sm:p-8 lg:p-10 shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-raosc-green/5 rounded-full blur-[100px]"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-raosc-yellow/5 rounded-full blur-[100px]"></div>
                        
                        <div class="flex items-center justify-between mb-6 sm:mb-8 relative z-10">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white">Nouvelle initiative</h3>
                                <p class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1">Partagez votre projet ou appel à bénévoles</p>
                            </div>
                            <button @click="resetForm"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all duration-300 hover:scale-110 hover:rotate-90">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form @submit.prevent="projectFormData.post(store().url, { onSuccess: resetForm, preserveScroll: true })" class="space-y-6 relative z-10">
                            <!-- Erreurs -->
                            <div v-if="Object.keys(projectFormData.errors).length > 0" class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-2xl">
                                <div class="flex items-center gap-2 text-raosc-red font-bold text-sm mb-2">
                                    <AlertCircle class="w-4 h-4" />
                                    Veuillez corriger les erreurs
                                </div>
                                <ul class="text-xs text-raosc-red/80 space-y-1 ml-6 list-disc">
                                    <li v-for="(error, field) in projectFormData.errors" :key="field">{{ error }}</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">
                                <!-- Organisation (si multiple) -->
                                <div v-if="organizations.length > 1" class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Organisation <span class="text-raosc-red">*</span>
                                    </label>
                                    <select v-model="projectFormData.organization_id" required
                                        class="w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl sm:rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300">
                                        <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                    </select>
                                </div>

                                <!-- Titre -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Titre <span class="text-raosc-red">*</span>
                                    </label>
                                    <input 
                                        v-model="projectFormData.title" 
                                        type="text" 
                                        placeholder="Ex: Forage hydraulique dans la région de..." 
                                        required 
                                        class="w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl sm:rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        :class="{ 'border-raosc-red': projectFormData.errors.title }"
                                    />
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.title" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.title }}</p>
                                    </Transition>
                                </div>

                                <!-- Type -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Type d'action <span class="text-raosc-red">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <button type="button"
                                            :class="['flex items-center justify-center gap-2 p-2.5 sm:p-3 border-2 rounded-xl sm:rounded-2xl cursor-pointer transition-all duration-300 hover:scale-105', 
                                                projectFormData.type === 'projet' 
                                                    ? 'border-raosc-yellow bg-raosc-yellow/10 shadow-md' 
                                                    : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800']"
                                            @click="projectFormData.type = 'projet'">
                                            <Target class="w-4 h-4" :class="projectFormData.type === 'projet' ? 'text-raosc-yellow' : 'text-zinc-500'" />
                                            <span class="font-bold text-xs sm:text-sm" :class="projectFormData.type === 'projet' ? 'text-raosc-yellow' : 'text-zinc-500'">Projet</span>
                                        </button>
                                        <button type="button"
                                            :class="['flex items-center justify-center gap-2 p-2.5 sm:p-3 border-2 rounded-xl sm:rounded-2xl cursor-pointer transition-all duration-300 hover:scale-105', 
                                                projectFormData.type === 'benevolat' 
                                                    ? 'border-raosc-green bg-raosc-green/10 shadow-md' 
                                                    : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800']"
                                            @click="projectFormData.type = 'benevolat'">
                                            <Users class="w-4 h-4" :class="projectFormData.type === 'benevolat' ? 'text-raosc-green' : 'text-zinc-500'" />
                                            <span class="font-bold text-xs sm:text-sm" :class="projectFormData.type === 'benevolat' ? 'text-raosc-green' : 'text-zinc-500'">Bénévolat</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Statut -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Statut
                                    </label>
                                    <select v-model="projectFormData.status" 
                                        class="w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl sm:rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300">
                                        <option value="active">🟢 En cours - Actif maintenant</option>
                                        <option value="completed">✅ Terminé - Mission accomplie</option>
                                    </select>
                                </div>

                                <!-- Image de couverture -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        <Image class="w-3.5 h-3.5 inline mr-1" /> Image de couverture
                                    </label>
                                    <div 
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop"
                                        :class="['border-2 border-dashed rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center transition-all duration-300 cursor-pointer',
                                            coverPreview ? 'border-raosc-green bg-raosc-green/5' : 'border-zinc-300 dark:border-zinc-600 hover:border-raosc-green hover:bg-raosc-green/5',
                                            isDragging ? 'border-raosc-green bg-raosc-green/10 scale-[0.99]' : '']"
                                        @click="() => document.getElementById('cover-input')?.click()">
                                        <div v-if="coverPreview" class="relative inline-block">
                                            <img :src="coverPreview" class="h-32 w-full object-cover rounded-xl" />
                                            <button type="button" @click.stop="removeCoverImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                                <X class="w-3 h-3" />
                                            </button>
                                        </div>
                                        <div v-else class="flex flex-col items-center gap-2">
                                            <Upload class="w-8 h-8 text-zinc-400" />
                                            <p class="text-sm text-zinc-500">Glissez une image ou cliquez</p>
                                            <p class="text-xs text-zinc-400">PNG, JPG, WEBP jusqu'à 5MB</p>
                                        </div>
                                        <input id="cover-input" type="file" @change="handleImageUpload" accept="image/*" class="hidden" />
                                    </div>
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.cover_image" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.cover_image }}</p>
                                    </Transition>
                                </div>

                                <!-- Galerie -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Galerie photos
                                    </label>
                                    <input 
                                        type="file" 
                                        @change="handleGalleryUpload" 
                                        accept="image/*"
                                        multiple
                                        class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-300 dark:hover:file:bg-zinc-700 transition-all duration-300"
                                    />
                                    <div v-if="galleryPreviews.length > 0" class="mt-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                        <div v-for="(preview, index) in galleryPreviews" :key="index" class="relative group aspect-square rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                            <img :src="preview" class="h-full w-full object-cover">
                                            <button type="button" @click="removeGalleryImage(index)" class="absolute inset-0 bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <X class="w-4 h-4 sm:w-5 sm:h-5" />
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-zinc-400 mt-2">Jusqu'à 10 images maximum</p>
                                </div>

                                <!-- Description -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Description <span class="text-raosc-red">*</span>
                                    </label>
                                    <textarea 
                                        v-model="projectFormData.description" 
                                        rows="5" 
                                        placeholder="Expliquez les objectifs, l'impact direct, les besoins spécifiques..." 
                                        required 
                                        class="w-full px-4 sm:px-5 py-3 rounded-xl sm:rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm leading-relaxed transition-all duration-300 resize-none"
                                        :class="{ 'border-raosc-red': projectFormData.errors.description }"
                                    ></textarea>
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.description" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.description }}</p>
                                    </Transition>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 sm:pt-6 border-t-2 border-zinc-200 dark:border-zinc-800">
                                <button type="button" @click="resetForm" 
                                    class="px-5 sm:px-6 py-2 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold transition-all duration-300 hover:scale-105 order-2 sm:order-1">
                                    Annuler
                                </button>
                                <button type="submit" :disabled="projectFormData.processing" 
                                    class="group flex items-center justify-center gap-2 px-6 sm:px-8 py-2.5 bg-gradient-to-r from-raosc-green to-raosc-green/80 text-white font-bold rounded-xl sm:rounded-2xl text-xs sm:text-sm hover:scale-105 hover:shadow-xl transition-all duration-300 disabled:opacity-60 disabled:hover:scale-100 order-1 sm:order-2">
                                    <CheckCircle v-if="!projectFormData.processing" class="w-4 h-4" />
                                    <span>{{ projectFormData.processing ? 'Publication...' : 'Publier l\'initiative' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>

                <!-- Filtres et vue -->
                <div v-if="projects.length > 0" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex gap-2">
                        <button 
                            @click="activeFilter = 'all'"
                            :class="['px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300', 
                                activeFilter === 'all' ? 'bg-raosc-green text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700']">
                            Tous
                        </button>
                        <button 
                            @click="activeFilter = 'projet'"
                            :class="['px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300', 
                                activeFilter === 'projet' ? 'bg-raosc-yellow text-zinc-900 shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700']">
                            Projets
                        </button>
                        <button 
                            @click="activeFilter = 'benevolat'"
                            :class="['px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300', 
                                activeFilter === 'benevolat' ? 'bg-raosc-green text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700']">
                            Bénévolats
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button @click="viewMode = 'grid'" :class="['p-2 rounded-lg transition-all duration-300', viewMode === 'grid' ? 'bg-raosc-green/20 text-raosc-green' : 'text-zinc-400 hover:text-zinc-600']">
                            <LayoutGrid class="w-4 h-4" />
                        </button>
                        <button @click="viewMode = 'list'" :class="['p-2 rounded-lg transition-all duration-300', viewMode === 'list' ? 'bg-raosc-green/20 text-raosc-green' : 'text-zinc-400 hover:text-zinc-600']">
                            <List class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <!-- Liste des projets -->
                <div v-if="filteredProjects().length > 0" :class="viewMode === 'grid' 
                    ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6' 
                    : 'space-y-4'">
                    
                    <!-- Vue grille -->
                    <div v-for="project in filteredProjects()" :key="project.id" v-if="viewMode === 'grid'"
                        class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-2xl transition-all duration-500 hover:scale-[1.02] relative flex flex-col">
                        <div class="absolute top-4 right-4">
                            <span :class="['h-2.5 w-2.5 rounded-full block', project.status === 'active' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400']"></span>
                        </div>
                        <div class="flex items-start justify-between mb-4">
                            <span :class="['px-3 py-1.5 text-[10px] sm:text-xs font-bold rounded-xl flex items-center gap-1.5', 
                                project.type === 'benevolat' ? 'bg-raosc-green/10 text-raosc-green' : 'bg-raosc-yellow/10 text-raosc-yellow']">
                                <component :is="project.type === 'benevolat' ? Heart : Briefcase" class="w-3 h-3" />
                                {{ project.type === 'benevolat' ? 'Bénévolat' : 'Projet' }}
                            </span>
                        </div>
                        <h4 class="font-extrabold text-lg sm:text-xl dark:text-white mb-2 leading-snug group-hover:text-raosc-green transition-colors line-clamp-2">
                            {{ project.title }}
                        </h4>
                        <p class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed line-clamp-3 mb-4 flex-grow">
                            {{ project.description }}
                        </p>
                        <div class="flex items-center justify-between pt-3 border-t border-zinc-100 dark:border-zinc-800">
                            <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-zinc-500">
                                <Clock class="w-3 h-3" />
                                <span>{{ formatDate(project.created_at) }}</span>
                            </div>
                            <button @click="deleteProject(project.id)" :disabled="isDeleting === project.id"
                                class="text-zinc-400 hover:text-raosc-red hover:bg-red-50 dark:hover:bg-red-500/10 h-8 w-8 sm:h-9 sm:w-9 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 disabled:opacity-50 bg-zinc-50 dark:bg-zinc-800">
                                <Trash2 class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </button>
                        </div>
                        <div class="absolute inset-0 rounded-2xl sm:rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" 
                             :style="{ boxShadow: 'inset 0 0 0 2px var(--raosc-green)' }"></div>
                    </div>

                    <!-- Vue liste -->
                    <div v-for="project in filteredProjects()" :key="project.id" v-else
                        class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-[1.01] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <span :class="['px-2 py-1 text-[10px] font-bold rounded-lg', 
                                    project.type === 'benevolat' ? 'bg-raosc-green/10 text-raosc-green' : 'bg-raosc-yellow/10 text-raosc-yellow']">
                                    {{ project.type === 'benevolat' ? 'Bénévolat' : 'Projet' }}
                                </span>
                                <span :class="['text-[10px] font-medium px-2 py-1 rounded-full', 
                                    project.status === 'active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800']">
                                    {{ project.status === 'active' ? 'En cours' : 'Terminé' }}
                                </span>
                            </div>
                            <h4 class="font-bold text-base sm:text-lg dark:text-white group-hover:text-raosc-green transition-colors line-clamp-1">
                                {{ project.title }}
                            </h4>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2 mt-1">{{ project.description }}</p>
                            <div class="flex items-center gap-1.5 text-[10px] text-zinc-400 mt-2">
                                <Clock class="w-3 h-3" />
                                <span>{{ formatDate(project.created_at) }}</span>
                            </div>
                        </div>
                        <button @click="deleteProject(project.id)" :disabled="isDeleting === project.id"
                            class="text-zinc-400 hover:text-raosc-red hover:bg-red-50 dark:hover:bg-red-500/10 h-8 w-8 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 disabled:opacity-50 bg-zinc-50 dark:bg-zinc-800 shrink-0">
                            <Trash2 class="w-3.5 h-3.5" />
                        </button>
                    </div>
                </div>

                <!-- État vide -->
                <div v-else class="text-center py-16 sm:py-20 backdrop-blur-sm bg-white/50 dark:bg-zinc-900/50 rounded-2xl sm:rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                    <div class="h-16 w-16 sm:h-20 sm:w-20 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 rounded-2xl flex items-center justify-center text-zinc-400 mb-5 mx-auto">
                        <Target class="w-8 h-8 sm:w-10 sm:h-10" />
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-zinc-900 dark:text-white mb-2">Aucune initiative</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 max-w-sm mx-auto mb-6">Commencez par publier votre premier projet ou appel à bénévoles</p>
                    <button @click="isFormOpen = true" 
                        class="inline-flex items-center gap-2 px-6 sm:px-8 py-2.5 sm:py-3 bg-raosc-green text-white font-bold rounded-xl sm:rounded-2xl text-xs sm:text-sm hover:scale-105 hover:shadow-xl transition-all duration-300">
                        <PlusCircle class="w-4 h-4" /> Publier une initiative
                    </button>
                </div>

                <!-- Statistiques -->
                <div v-if="projects.length > 0" class="flex justify-center gap-6 sm:gap-8 pt-4 sm:pt-6">
                    <div class="text-center group cursor-pointer">
                        <div class="text-xl sm:text-2xl font-black text-raosc-green group-hover:scale-110 transition-transform duration-300">
                            {{ stats.active }}
                        </div>
                        <div class="text-[10px] sm:text-xs text-zinc-500">En cours</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="text-xl sm:text-2xl font-black text-raosc-yellow group-hover:scale-110 transition-transform duration-300">
                            {{ stats.projets }}
                        </div>
                        <div class="text-[10px] sm:text-xs text-zinc-500">Projets</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="text-xl sm:text-2xl font-black text-raosc-green group-hover:scale-110 transition-transform duration-300">
                            {{ stats.benevolats }}
                        </div>
                        <div class="text-[10px] sm:text-xs text-zinc-500">Bénévolats</div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Animations existantes */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

.slide-fade-enter-active {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-fade-enter-from {
    transform: translateY(-20px);
    opacity: 0;
}

.slide-fade-leave-to {
    transform: translateY(10px);
    opacity: 0;
}

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

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>