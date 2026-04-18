<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { ref, reactive } from 'vue';
import { PlusCircle, Target, Users, Trash2, ShieldAlert, Calendar, TrendingUp, Heart, Briefcase, CheckCircle, Clock, X, ArrowRight } from 'lucide-vue-next';
import { store, destroy } from '@/actions/App/Http/Controllers/Dashboard/ProjectController';
import { create as joinRao } from '@/actions/App/Http/Controllers/RaoController';

interface Project {
    id: number;
    title: string;
    type: 'projet' | 'benevolat';
    description: string;
    status: 'active' | 'completed';
    created_at?: string;
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

const handleImageUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        projectFormData.cover_image = target.files[0];
        coverPreview.value = URL.createObjectURL(target.files[0]);
    } else {
        projectFormData.cover_image = null;
        coverPreview.value = null;
    }
};

const handleGalleryUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        projectFormData.gallery = Array.from(target.files);
        galleryPreviews.value = projectFormData.gallery.map(file => URL.createObjectURL(file));
    }
};

const removeGalleryImage = (index: number) => {
    projectFormData.gallery.splice(index, 1);
    galleryPreviews.value.splice(index, 1);
};

const resetForm = () => {
    isFormOpen.value = false;
    coverPreview.value = null;
    galleryPreviews.value = [];
    projectFormData.cover_image = null;
    projectFormData.gallery = [];
    projectFormData.title = '';
    projectFormData.description = '';
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
    return new Date(date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
};
</script>

<template>
    <AppLayout>
        <Head title="Gestion Projets & Bénévolat" />

        <div class="min-h-screen bg-gradient-to-br from-zinc-50 via-white to-zinc-50 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 p-6 lg:p-10">
            
            <!-- Effets de fond glassmorphique -->
            <div class="fixed inset-0 pointer-events-none opacity-30 dark:opacity-10">
                <div class="absolute top-20 -left-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-green)"></div>
                <div class="absolute bottom-20 -right-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-yellow)"></div>
            </div>

            <!-- Affichage si pas d'organisation -->
            <div v-if="organizations.length === 0" class="max-w-2xl mx-auto mt-10 animate-fade-in">
                <div class="backdrop-blur-xl bg-white/90 dark:bg-zinc-900/90 rounded-3xl p-12 text-center shadow-2xl border border-red-200/50 dark:border-red-800/50">
                    <div class="animate-pulse">
                        <div class="h-20 w-20 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-500/20 dark:to-red-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <ShieldAlert class="w-10 h-10 text-raosc-red" />
                        </div>
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

            <!-- Contenu principal (quand organisation existe) -->
            <div v-else class="space-y-8">
                <!-- Entête premium avec glassmorphism -->
                <div class="sticky top-6 z-10 backdrop-blur-md bg-white/80 dark:bg-zinc-900/80 border border-zinc-200/50 dark:border-zinc-800/50 rounded-3xl p-8 shadow-lg transition-all duration-300 hover:shadow-xl">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="h-px w-8 bg-raosc-green"></div>
                                <p class="text-xs font-bold uppercase tracking-wider text-raosc-green">Initiatives d'impact</p>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-black text-zinc-900 dark:text-white">Projets & Bénévolats</h1>
                            <div v-if="organizations.length > 1" class="flex items-center gap-3 mt-4">
                                <span class="text-xs font-bold text-zinc-500">Filtrer par organisation :</span>
                                <select 
                                    :value="organizationId" 
                                    @change="(e: any) => $inertia.visit(`?organization_id=${e.target.value}`, { preserveScroll: true })"
                                    class="text-xs font-bold bg-zinc-100 dark:bg-zinc-800 border-none rounded-xl px-3 py-1.5 focus:ring-raosc-green"
                                >
                                    <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                </select>
                            </div>
                        </div>
                        <button 
                            @click="isFormOpen = true" 
                            class="group flex items-center gap-2 px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-2xl font-bold text-sm hover:scale-105 hover:shadow-xl transition-all duration-300 w-full sm:w-auto justify-center"
                        >
                            <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                            Nouvelle initiative
                        </button>
                    </div>
                </div>

                <!-- Formulaire ajout avec glassmorphism -->
                <Transition name="slide-fade">
                    <div v-if="isFormOpen" class="backdrop-blur-md bg-white/95 dark:bg-zinc-900/95 border border-zinc-200/50 dark:border-zinc-800/50 rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-raosc-green/5 rounded-full blur-[100px]"></div>
                        <div class="absolute bottom-0 left-0 w-96 h-96 bg-raosc-yellow/5 rounded-full blur-[100px]"></div>
                        
                        <div class="flex items-center justify-between mb-8 relative z-10">
                            <div>
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Nouvelle initiative</h3>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Partagez votre projet ou appel à bénévoles</p>
                            </div>
                            <button @click="isFormOpen = false"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all duration-300 hover:scale-110 hover:rotate-90">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form 
                            @submit.prevent="projectFormData.post(store().url, { 
                                onSuccess: () => resetForm(),
                                preserveScroll: true
                            })"
                            class="space-y-6 relative z-10"
                        >
                            <div v-if="Object.keys(projectFormData.errors).length > 0" class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-2xl mb-6">
                                <div class="flex items-center gap-2 text-raosc-red font-bold text-sm mb-1">
                                    <ShieldAlert class="w-4 h-4" />
                                    Erreurs de validation
                                </div>
                                <ul class="text-xs text-raosc-red/80 space-y-1 ml-6 list-disc">
                                    <li v-for="(error, field) in projectFormData.errors" :key="field">{{ error }}</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div v-if="organizations.length > 1" class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Organisation concernée <span class="text-raosc-red">*</span>
                                    </label>
                                    <select v-model="projectFormData.organization_id" required
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300">
                                        <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                    </select>
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Titre saisissant <span class="text-raosc-red">*</span>
                                    </label>
                                    <input 
                                        v-model="projectFormData.title" 
                                        type="text" 
                                        placeholder="Ex: Forage hydraulique dans la région de..." 
                                        required 
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': projectFormData.errors.title }"
                                    />
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.title" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.title }}</p>
                                    </Transition>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Type d'action <span class="text-raosc-red">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label 
                                            :class="['flex items-center justify-center gap-2 p-3 border-2 rounded-2xl cursor-pointer transition-all duration-300 hover:scale-105', 
                                                projectFormData.type === 'projet' 
                                                    ? 'border-raosc-yellow bg-raosc-yellow/10 shadow-md' 
                                                    : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800']">
                                            <input type="radio" v-model="projectFormData.type" value="projet" class="hidden">
                                            <Target class="w-4 h-4" :class="projectFormData.type === 'projet' ? 'text-raosc-yellow' : 'text-zinc-500'" />
                                            <span class="font-bold text-sm" :class="projectFormData.type === 'projet' ? 'text-raosc-yellow' : 'text-zinc-500'">Projet</span>
                                        </label>
                                        <label 
                                            :class="['flex items-center justify-center gap-2 p-3 border-2 rounded-2xl cursor-pointer transition-all duration-300 hover:scale-105', 
                                                projectFormData.type === 'benevolat' 
                                                    ? 'border-raosc-green bg-raosc-green/10 shadow-md' 
                                                    : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800']">
                                            <input type="radio" v-model="projectFormData.type" value="benevolat" class="hidden">
                                            <Users class="w-4 h-4" :class="projectFormData.type === 'benevolat' ? 'text-raosc-green' : 'text-zinc-500'" />
                                            <span class="font-bold text-sm" :class="projectFormData.type === 'benevolat' ? 'text-raosc-green' : 'text-zinc-500'">Bénévolat</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Statut actuel
                                    </label>
                                    <select 
                                        v-model="projectFormData.status" 
                                        required 
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300 cursor-pointer"
                                    >
                                        <option value="active">🟢 En cours - Actif maintenant</option>
                                        <option value="completed">✅ Terminé - Mission accomplie</option>
                                    </select>
                                </div>

                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Image de couverture (Optionnelle)
                                    </label>
                                    <div class="flex items-center gap-4">
                                        <div v-if="coverPreview" class="h-16 w-16 rounded-xl overflow-hidden shrink-0 border border-zinc-200 dark:border-zinc-700">
                                            <img :src="coverPreview" class="h-full w-full object-cover" />
                                        </div>
                                        <input 
                                            type="file" 
                                            @change="handleImageUpload" 
                                            accept="image/*"
                                            class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-300 dark:hover:file:bg-zinc-700 transition-all duration-300"
                                        />
                                    </div>
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.cover_image" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.cover_image }}</p>
                                    </Transition>
                                </div>

                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Galerie Photos (Optionnelle, jusqu'à 10 images)
                                    </label>
                                    <input 
                                        type="file" 
                                        @change="handleGalleryUpload" 
                                        accept="image/*"
                                        multiple
                                        class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-300 dark:hover:file:bg-zinc-700 transition-all duration-300"
                                    />
                                    <div v-if="galleryPreviews.length > 0" class="mt-4 grid grid-cols-4 sm:grid-cols-6 gap-3">
                                        <div v-for="(preview, index) in galleryPreviews" :key="index" class="relative group h-20 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                            <img :src="preview" class="h-full w-full object-cover">
                                            <button type="button" @click.prevent="removeGalleryImage(index)" class="absolute inset-0 bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <X class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </div>
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.gallery" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.gallery }}</p>
                                    </Transition>
                                </div>

                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Description détaillée <span class="text-raosc-red">*</span>
                                    </label>
                                    <textarea 
                                        v-model="projectFormData.description" 
                                        rows="5" 
                                        placeholder="Expliquez les objectifs, l'impact direct, les besoins spécifiques..." 
                                        required 
                                        class="w-full px-5 py-3 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm leading-relaxed transition-all duration-300 resize-none"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': projectFormData.errors.description }"
                                    ></textarea>
                                    <Transition name="slide-down">
                                        <p v-if="projectFormData.errors.description" class="text-raosc-red text-xs mt-2">{{ projectFormData.errors.description }}</p>
                                    </Transition>
                                </div>
                            </div>

                            <div class="flex gap-4 justify-end pt-6 border-t-2 border-zinc-200 dark:border-zinc-800">
                                <button type="button" @click="resetForm" 
                                    class="px-6 py-2.5 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-2xl text-sm font-semibold transition-all duration-300 hover:scale-105">
                                    Annuler
                                </button>
                                <button type="submit" :disabled="projectFormData.processing" 
                                    class="group flex items-center gap-2 px-8 py-2.5 bg-gradient-to-r from-raosc-green to-raosc-green/80 text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-xl transition-all duration-300 disabled:opacity-60 disabled:hover:scale-100">
                                    <TrendingUp v-if="!projectFormData.processing" class="w-4 h-4 group-hover:translate-y-[-2px] transition-transform duration-300" />
                                    <span>{{ projectFormData.processing ? 'Publication...' : 'Mettre en ligne' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>

                <!-- Liste dynamique - Cartes premium -->
                <TransitionGroup name="list" tag="div" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="project in projects" 
                        :key="project.id" 
                        class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 hover:scale-[1.02] relative flex flex-col"
                    >
                        <!-- Badge de statut animé -->
                        <div class="absolute top-4 right-4">
                            <span :class="['h-2.5 w-2.5 rounded-full block', project.status === 'active' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400']" 
                                  :title="project.status === 'active' ? 'En cours' : 'Terminé'"></span>
                        </div>

                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-2">
                                <span :class="['px-3 py-1.5 text-xs font-bold rounded-xl flex items-center gap-1.5', 
                                    project.type === 'benevolat' 
                                        ? 'bg-raosc-green/10 text-raosc-green' 
                                        : 'bg-raosc-yellow/10 text-raosc-yellow']">
                                    <component :is="project.type === 'benevolat' ? Heart : Briefcase" class="w-3 h-3" />
                                    {{ project.type === 'benevolat' ? 'Appel Bénévole' : 'Projet Terrain' }}
                                </span>
                            </div>
                        </div>
                        
                        <h4 class="font-extrabold text-xl dark:text-white mb-3 leading-snug group-hover:text-raosc-green transition-colors duration-300 line-clamp-2">
                            {{ project.title }}
                        </h4>
                        
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed line-clamp-3 mb-6 flex-grow">
                            {{ project.description }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-4 border-t-2 border-zinc-100 dark:border-zinc-800">
                            <div class="flex items-center gap-1.5 text-xs text-zinc-500">
                                <Clock class="w-3 h-3" />
                                <span>{{ formatDate(project.created_at) }}</span>
                            </div>
                            <button 
                                @click="deleteProject(project.id)" 
                                :disabled="isDeleting === project.id"
                                class="text-zinc-400 hover:text-raosc-red hover:bg-red-50 dark:hover:bg-red-500/10 h-9 w-9 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 disabled:opacity-50 bg-zinc-50 dark:bg-zinc-800"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>

                        <!-- Effet de bordure au survol -->
                        <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" 
                             :style="{ boxShadow: 'inset 0 0 0 2px var(--raosc-green)' }"></div>
                    </div>

                    <!-- Carte vide stylisée -->
                    <div v-if="projects.length === 0" class="lg:col-span-3 text-center py-20 backdrop-blur-sm bg-white/50 dark:bg-zinc-900/50 rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800 flex flex-col items-center justify-center hover:border-raosc-green/50 transition-all duration-300">
                        <div class="h-20 w-20 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 rounded-2xl flex items-center justify-center text-zinc-400 mb-6 transition-transform duration-300 group-hover:scale-110">
                            <Target class="w-10 h-10" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">Votre vitrine est vide</h3>
                        <p class="text-zinc-600 dark:text-zinc-400 max-w-sm mb-8">Attirez l'attention des partenaires en ajoutant votre premier projet concret.</p>
                        <button @click="isFormOpen = true" 
                            class="inline-flex items-center gap-2 px-8 py-3 bg-raosc-green text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-xl transition-all duration-300">
                            <PlusCircle class="w-4 h-4" /> Publier ma première action
                        </button>
                    </div>
                </TransitionGroup>

                <!-- Indicateur de statistiques -->
                <div v-if="projects.length > 0" class="flex justify-center gap-8 pt-6">
                    <div class="text-center group cursor-pointer">
                        <div class="text-2xl font-black text-raosc-green group-hover:scale-110 transition-transform duration-300">
                            {{ projects.filter(p => p.status === 'active').length }}
                        </div>
                        <div class="text-xs text-zinc-500">En cours</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="text-2xl font-black text-raosc-yellow group-hover:scale-110 transition-transform duration-300">
                            {{ projects.filter(p => p.type === 'projet').length }}
                        </div>
                        <div class="text-xs text-zinc-500">Projets</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="text-2xl font-black text-raosc-green group-hover:scale-110 transition-transform duration-300">
                            {{ projects.filter(p => p.type === 'benevolat').length }}
                        </div>
                        <div class="text-xs text-zinc-500">Bénévolats</div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
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

.list-enter-active,
.list-leave-active {
    transition: all 0.3s ease;
}

.list-enter-from {
    opacity: 0;
    transform: translateX(-20px);
}

.list-leave-to {
    opacity: 0;
    transform: translateX(20px);
}

.list-move {
    transition: transform 0.3s ease;
}

/* Animation pulse pour le statut actif */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>