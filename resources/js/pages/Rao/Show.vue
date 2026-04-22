<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    MapPin, Building2, Mail, CheckCircle2, ArrowLeft,
    ChevronLeft, ChevronRight, Globe, PhoneCall, Navigation,
    Users, Target, Calendar, Image as ImageIcon, Briefcase,
    Heart, Clock, Eye, Award, Shield, FileText, CreditCard
} from 'lucide-vue-next';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { index as raoIndex } from '@/actions/App/Http/Controllers/RaoController';
import { index as dashboardIndex } from '@/actions/App/Http/Controllers/DashboardController';

interface Organization {
    id: number;
    name: string;
    slug: string;
    logo?: string;
    cover_image?: string;
    short_description?: string;
    description?: string;
    city?: string;
    country?: string;
    email?: string;
    phone?: string;
    website?: string;
    address?: string;
    registration_number?: string;
    founded_date?: string;
    categories?: { id: number, name: string }[];
    members?: { id: number, user: { name: string }, job_title?: string }[];
    projects?: { id: number, title: string, type: string, status: string, description: string, cover_image?: string, gallery?: string[] }[];
    gallery?: string[];
}

const {
    organization,
    isPublic = false
} = defineProps<{
    organization: { data: Organization } | Organization;
    isPublic?: boolean;
}>();

const org = ('data' in organization) ? organization.data : organization;
const gallery: string[] = org.gallery || [];
const galleryIndex = ref(0);

const nextGallery = () => galleryIndex.value = (galleryIndex.value + 1) % gallery.length;
const prevGallery = () => galleryIndex.value = (galleryIndex.value - 1 + gallery.length) % gallery.length;

const backUrl = computed(() => isPublic ? raoIndex().url : dashboardIndex().url);

const stats = {
    projects: org.projects?.length || 0,
    activeProjects: org.projects?.filter(p => p.status === 'active').length || 0,
    members: org.members?.length || 0,
    categories: org.categories?.length || 0
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head :title="org.name + ' — RAOSC'" />

        <div class="bg-white dark:bg-zinc-950 min-h-screen">

            <!-- COVER IMAGE - sans superposition de contenu -->
            <div class="relative w-full h-48 sm:h-56 md:h-64 bg-gradient-to-r from-zinc-800 to-zinc-900 overflow-hidden">
                <img 
                    v-if="org.cover_image" 
                    :src="org.cover_image" 
                    class="absolute inset-0 w-full h-full object-cover" 
                />
                <div class="absolute inset-0 bg-black/50"></div>
                
                <!-- Bouton retour -->
                <Link
                    :href="backUrl"
                    class="absolute top-4 left-4 z-10 inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-black/50 hover:bg-black/70 text-white text-xs sm:text-sm font-medium backdrop-blur-sm border border-white/20 transition-all duration-300"
                >
                    <ArrowLeft class="w-3.5 h-3.5 sm:w-4 sm:h-4" /> 
                    <span class="hidden sm:inline">Retour</span>
                </Link>
            </div>

            <!-- CONTENU PRINCIPAL - avec padding top pour l'espace -->
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 relative">
                
                <!-- Logo positionné correctement (chevauchement léger) -->
                <div class="relative z-10 -mt-10 sm:-mt-12 mb-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                        <!-- Logo -->
                        <div class="h-20 w-20 sm:h-24 sm:w-24 md:h-28 md:w-28 rounded-xl sm:rounded-2xl bg-white dark:bg-zinc-900 border-4 border-white dark:border-zinc-950 shadow-xl overflow-hidden shrink-0 flex items-center justify-center">
                            <img 
                                v-if="org.logo" 
                                :src="org.logo" 
                                class="h-full w-full object-cover" 
                            />
                            <Building2 v-else class="h-10 w-10 sm:h-12 sm:w-12 text-zinc-300 dark:text-zinc-600" />
                        </div>
                        
                        <!-- Titre et localisation -->
                        <div class="pb-1 flex-1">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-zinc-900 dark:text-white leading-tight">
                                    {{ org.name }}
                                </h1>
                                <CheckCircle2 class="w-5 h-5 text-raosc-green shrink-0" title="Organisation vérifiée" />
                            </div>
                            <div class="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
                                <MapPin class="w-3.5 h-3.5" />
                                <span>{{ org.city || 'Ville non renseignée' }}{{ org.country ? `, ${org.country}` : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CATÉGORIES & STATS RAPIDES -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="flex flex-wrap gap-2">
                        <span 
                            v-for="cat in org.categories" 
                            :key="cat.id" 
                            class="px-2.5 py-1 text-[10px] font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-full"
                        >
                            {{ cat.name }}
                        </span>
                        <span v-if="!org.categories?.length" class="text-xs text-zinc-400 italic">
                            Aucune catégorie renseignée
                        </span>
                    </div>
                    
                    <div class="flex gap-4 text-center">
                        <div class="px-2">
                            <div class="text-sm font-black text-raosc-green">{{ stats.projects }}</div>
                            <div class="text-[9px] text-zinc-500">Projets</div>
                        </div>
                        <div class="px-2">
                            <div class="text-sm font-black text-raosc-green">{{ stats.activeProjects }}</div>
                            <div class="text-[9px] text-zinc-500">En cours</div>
                        </div>
                        <div class="px-2">
                            <div class="text-sm font-black text-raosc-green">{{ stats.members }}</div>
                            <div class="text-[9px] text-zinc-500">Membres</div>
                        </div>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-800 mb-8" />

                <!-- GRILLE 2 COLONNES -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10 pb-16">
                    
                    <!-- ─── COLONNE GAUCHE - SIDEBAR ─── -->
                    <aside class="lg:col-span-1 space-y-8 order-2 lg:order-1">
                        
                        <!-- Bloc Contact -->
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-5">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <div class="h-px w-4 bg-raosc-green"></div>
                                Contact
                            </h3>
                            <div class="space-y-4">
                                <div v-if="org.email" class="flex items-start gap-3">
                                    <Mail class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Email</p>
                                        <a :href="`mailto:${org.email}`" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors break-all">
                                            {{ org.email }}
                                        </a>
                                    </div>
                                </div>
                                
                                <div v-if="org.phone" class="flex items-start gap-3">
                                    <PhoneCall class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Téléphone</p>
                                        <a :href="`tel:${org.phone}`" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors">
                                            {{ org.phone }}
                                        </a>
                                    </div>
                                </div>
                                
                                <div v-if="org.website" class="flex items-start gap-3">
                                    <Globe class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Site web</p>
                                        <a :href="org.website" target="_blank" rel="noopener" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors break-all">
                                            {{ org.website.replace(/^https?:\/\//, '') }}
                                        </a>
                                    </div>
                                </div>
                                
                                <div v-if="org.address" class="flex items-start gap-3">
                                    <Navigation class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Adresse</p>
                                        <p class="text-sm text-zinc-800 dark:text-zinc-200">{{ org.address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bloc Informations légales -->
                        <div v-if="org.founded_date || org.registration_number" class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-5">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <div class="h-px w-4 bg-raosc-green"></div>
                                Informations
                            </h3>
                            <div class="space-y-3">
                                <div v-if="org.founded_date" class="flex items-start gap-3">
                                    <Calendar class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Fondée en</p>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                            {{ new Date(org.founded_date).getFullYear() }}
                                        </p>
                                    </div>
                                </div>
                                <div v-if="org.registration_number" class="flex items-start gap-3">
                                    <FileText class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">N° Enregistrement</p>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ org.registration_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bloc Équipe -->
                        <div v-if="org.members && org.members.length > 0" class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-5">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <div class="h-px w-4 bg-raosc-green"></div>
                                <Users class="w-3.5 h-3.5" /> Équipe
                            </h3>
                            <div class="space-y-3">
                                <div v-for="member in org.members" :key="member.id" class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-raosc-green/10 text-raosc-green flex items-center justify-center font-bold text-sm shrink-0 select-none">
                                        {{ member.user?.name?.charAt(0).toUpperCase() || '?' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white leading-tight truncate">
                                            {{ member.user ? member.user.name : 'Membre' }}
                                        </p>
                                        <p class="text-xs text-zinc-400 truncate">{{ member.job_title || 'Responsable' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <!-- ─── COLONNE DROITE - CONTENU PRINCIPAL ─── -->
                    <main class="lg:col-span-2 space-y-10 order-1 lg:order-2">
                        
                        <!-- Section À propos -->
                        <section>
                            <h2 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <div class="h-px w-4 bg-raosc-green"></div>
                                À propos
                            </h2>
                            <div class="space-y-4">
                                <p v-if="org.short_description" class="text-base sm:text-lg font-semibold text-zinc-900 dark:text-white leading-relaxed">
                                    {{ org.short_description }}
                                </p>
                                <div 
                                    v-if="org.description"
                                    class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed whitespace-pre-line"
                                >
                                    {{ org.description }}
                                </div>
                                <div v-if="!org.short_description && !org.description" class="text-sm text-zinc-400 italic">
                                    Aucune description disponible.
                                </div>
                            </div>
                        </section>

                        <!-- Section Projets & Bénévolat -->
                        <section v-if="org.projects && org.projects.length > 0">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 flex items-center gap-2">
                                    <div class="h-px w-4 bg-raosc-green"></div>
                                    <Target class="w-3.5 h-3.5" /> Projets & Bénévolat
                                </h2>
                                <span class="text-[10px] font-bold text-raosc-green bg-raosc-green/10 px-2 py-0.5 rounded-full">
                                    {{ org.projects.length }} action<span v-if="org.projects.length > 1">s</span>
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div
                                    v-for="project in org.projects"
                                    :key="project.id"
                                    class="group relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-zinc-200/50 dark:hover:shadow-none transition-all duration-500"
                                >
                                    <div class="flex flex-col md:flex-row">
                                        <!-- Image du projet -->
                                        <div class="w-full md:w-48 h-32 md:h-auto shrink-0 overflow-hidden bg-zinc-100 dark:bg-zinc-800 relative">
                                            <img v-if="project.cover_image" :src="project.cover_image" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                            <div v-else class="w-full h-full flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 text-zinc-300">
                                                <ImageIcon class="w-8 h-8" />
                                            </div>
                                            <!-- Type Badge -->
                                            <div class="absolute top-3 left-3">
                                                <span :class="['px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm backdrop-blur-md', 
                                                    project.type === 'benevolat' ? 'bg-raosc-green/90 text-white' : 'bg-raosc-yellow/90 text-zinc-900']">
                                                    {{ project.type === 'benevolat' ? 'Bénévolat' : 'Projet' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Détails du projet -->
                                        <div class="p-5 flex-1 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span :class="['flex items-center gap-1 text-[10px] font-bold', 
                                                        project.status === 'active' ? 'text-emerald-500' : 'text-zinc-400']">
                                                        <Clock class="w-3 h-3" />
                                                        {{ project.status === 'active' ? 'En cours' : 'Terminé' }}
                                                    </span>
                                                </div>
                                                <h3 class="text-base font-black text-zinc-900 dark:text-white mb-2 group-hover:text-raosc-green transition-colors">
                                                    {{ project.title }}
                                                </h3>
                                                <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed line-clamp-2">
                                                    {{ project.description }}
                                                </p>
                                            </div>
                                            
                                            <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                                                <button class="text-[10px] font-bold text-zinc-400 hover:text-raosc-green transition-colors flex items-center gap-1 uppercase tracking-widest">
                                                    Détails <ArrowRight class="w-3 h-3" />
                                                </button>
                                                <div class="flex -space-x-2">
                                                    <div v-for="i in 3" :key="i" class="h-6 w-6 rounded-full border-2 border-white dark:border-zinc-900 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-[8px] font-bold text-zinc-400 overflow-hidden">
                                                        <Users class="w-3 h-3" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Section Galerie photos -->
                        <section v-if="gallery.length > 0">
                            <h2 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <div class="h-px w-4 bg-raosc-green"></div>
                                <ImageIcon class="w-3.5 h-3.5" /> Galerie
                            </h2>
                            
                            <div class="relative rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 group">
                                <div class="h-64 sm:h-80 w-full overflow-hidden">
                                    <transition name="fade" mode="out-in">
                                        <img
                                            :key="galleryIndex"
                                            :src="gallery[galleryIndex]"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                                        />
                                    </transition>
                                </div>
                                
                                <button 
                                    v-if="gallery.length > 1"
                                    @click="prevGallery" 
                                    class="absolute left-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full bg-black/50 hover:bg-black/70 border border-white/20 text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110"
                                >
                                    <ChevronLeft class="w-4 h-4" />
                                </button>
                                <button 
                                    v-if="gallery.length > 1"
                                    @click="nextGallery" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full bg-black/50 hover:bg-black/70 border border-white/20 text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110"
                                >
                                    <ChevronRight class="w-4 h-4" />
                                </button>
                                
                                <span class="absolute bottom-3 right-3 text-[10px] font-bold text-white bg-black/60 backdrop-blur-sm px-2 py-1 rounded-full">
                                    {{ galleryIndex + 1 }} / {{ gallery.length }}
                                </span>
                            </div>
                            
                            <div v-if="gallery.length > 1" class="flex gap-2 mt-3 overflow-x-auto pb-2">
                                <button
                                    v-for="(img, idx) in gallery"
                                    :key="idx"
                                    @click="galleryIndex = idx"
                                    class="h-12 w-16 shrink-0 rounded-lg overflow-hidden border-2 transition-all duration-300"
                                    :class="galleryIndex === idx ? 'border-raosc-green opacity-100' : 'border-transparent opacity-50 hover:opacity-100'"
                                >
                                    <img :src="img" class="h-full w-full object-cover" />
                                </button>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </component>
</template>

<style scoped>
.fade-enter-active, 
.fade-leave-active { 
    transition: opacity 0.3s ease; 
}
.fade-enter-from, 
.fade-leave-to { 
    opacity: 0; 
}
</style>