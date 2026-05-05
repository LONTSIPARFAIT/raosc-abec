<!-- OrganizationShow.vue - Version corrigée avec titre visible -->
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    MapPin, Building2, Mail, CheckCircle2, ArrowLeft,
    ChevronLeft, ChevronRight, Globe, PhoneCall, Navigation,
    Users, Target, Calendar, Image as ImageIcon, Briefcase,
    Heart, Clock, Eye, Award, Shield, FileText, CreditCard,
    Share2, Bookmark, ChevronRight as ChevronRightIcon,
    ExternalLink, Verified, Star, Facebook, Twitter, Linkedin
} from 'lucide-vue-next';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

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
    social_facebook?: string;
    social_twitter?: string;
    social_linkedin?: string;
    categories?: { id: number, name: string }[];
    members?: { id: number, user: { name: string }, job_title?: string }[];
    projects?: { id: number, title: string, type: string, status: string, description: string, cover_image?: string, gallery?: string[] }[];
    gallery?: string[];
    member_count?: number;
    presentation_doc?: string;
    legal_docs?: string[];
    responsible_name?: string;
    responsible_email?: string;
    responsible_phone?: string;
    responsible_photo?: string;
    responsible_id_doc?: string;
    vice_responsible_name?: string;
    vice_responsible_email?: string;
    vice_responsible_phone?: string;
    vice_responsible_photo?: string;
    vice_responsible_id_doc?: string;
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
const scrollProgress = ref(0);
const isBookmarked = ref(false);
const showFullDescription = ref(false);

const nextGallery = () => galleryIndex.value = (galleryIndex.value + 1) % gallery.length;
const prevGallery = () => galleryIndex.value = (galleryIndex.value - 1 + gallery.length) % gallery.length;

const updateProgress = () => {
    const winScroll = document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    scrollProgress.value = (winScroll / height) * 100;
};

onMounted(() => {
    window.addEventListener('scroll', updateProgress);
});

onUnmounted(() => {
    window.removeEventListener('scroll', updateProgress);
});

const backUrl = computed(() => '#');

const stats = {
    projects: org.projects?.length || 0,
    activeProjects: org.projects?.filter(p => p.status === 'active').length || 0,
    completedProjects: org.projects?.filter(p => p.status === 'completed').length || 0,
    members: org.member_count || org.members?.length || 0,
    categories: org.categories?.length || 0
};

const formattedDate = computed(() => {
    if (!org.founded_date) return null;
    return new Date(org.founded_date).getFullYear();
});
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head :title="`${org.name} | RAOSC`" />

        <article class="bg-white dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- BARRE DE PROGRESSION -->
            <!-- ============================================ -->
            <div class="fixed top-0 left-0 right-0 h-1 bg-zinc-200 dark:bg-zinc-800 z-50">
                <div class="h-full bg-raosc-green transition-all duration-200" :style="{ width: scrollProgress + '%' }"></div>
            </div>

            <!-- ============================================ -->
            <!-- COVER IMAGE - HAUTEUR RÉDUITE POUR LAISSER LA PLACE AU TITRE -->
            <!-- ============================================ -->
            <div class="relative w-full h-48 sm:h-56 md:h-64 lg:h-72 overflow-hidden">
                <img 
                    v-if="org.cover_image" 
                    :src="org.cover_image" 
                    class="absolute inset-0 w-full h-full object-cover" 
                />
                <div v-else class="absolute inset-0 bg-gradient-to-r from-raosc-green/30 to-raosc-yellow/30"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-transparent"></div>
                
                <!-- Bouton retour flottant -->
                <div class="absolute top-4 left-4 z-20 flex gap-3">
                    <Link
                        :href="backUrl"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/50 hover:bg-black/70 text-white text-xs font-medium backdrop-blur-sm border border-white/20 transition-all duration-300"
                    >
                        <ArrowLeft class="w-3.5 h-3.5" /> 
                        <span class="hidden sm:inline">Retour</span>
                    </Link>
                    
                    <div class="flex gap-2">
                        <button @click="isBookmarked = !isBookmarked" 
                                class="p-1.5 rounded-full bg-black/50 backdrop-blur-sm hover:bg-black/70 transition-all">
                            <Bookmark :class="['w-3.5 h-3.5', isBookmarked ? 'text-raosc-yellow fill-raosc-yellow' : 'text-white']" />
                        </button>
                        <button class="p-1.5 rounded-full bg-black/50 backdrop-blur-sm hover:bg-black/70 transition-all">
                            <Share2 class="w-3.5 h-3.5 text-white" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU PRINCIPAL - TITRE BIEN VISIBLE -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12">
                
                <!-- Header avec logo et titre - PAS DE CHEVAUCHEMENT, TITRE BIEN EN DESSOUS -->
                <div class="pt-6 pb-8 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        
                        <!-- Logo -->
                        <div class="h-20 w-20 sm:h-24 sm:w-24 rounded-xl bg-white dark:bg-zinc-900 border-2 border-zinc-200 dark:border-zinc-700 shadow-lg overflow-hidden shrink-0 flex items-center justify-center">
                            <img 
                                v-if="org.logo" 
                                :src="org.logo" 
                                class="h-full w-full object-cover" 
                            />
                            <Building2 v-else class="h-10 w-10 sm:h-12 sm:w-12 text-zinc-300 dark:text-zinc-600" />
                        </div>
                        
                        <!-- Titre et infos -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 flex-wrap mb-2">
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-zinc-900 dark:text-white">
                                    {{ org.name }}
                                </h1>
                                <div class="flex items-center gap-1 px-2 py-0.5 bg-raosc-green/10 rounded-full">
                                    <CheckCircle2 class="w-3.5 h-3.5 text-raosc-green" />
                                    <span class="text-[9px] font-bold text-raosc-green uppercase">Vérifié</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-zinc-500 dark:text-zinc-400">
                                <div class="flex items-center gap-1.5">
                                    <MapPin class="w-3.5 h-3.5" />
                                    <span>{{ org.city || 'Ville non renseignée' }}{{ org.country ? `, ${org.country}` : '' }}</span>
                                </div>
                                <div v-if="formattedDate" class="flex items-center gap-1.5">
                                    <Calendar class="w-3.5 h-3.5" />
                                    <span>Fondée en {{ formattedDate }}</span>
                                </div>
                                <div v-if="org.registration_number" class="flex items-center gap-1.5">
                                    <FileText class="w-3.5 h-3.5" />
                                    <span>N° {{ org.registration_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Badge stats rapide -->
                        <div class="flex gap-4 text-center bg-zinc-50 dark:bg-zinc-900/50 px-4 py-3 rounded-xl">
                            <div>
                                <div class="text-lg font-black text-raosc-green">{{ stats.projects }}</div>
                                <div class="text-[9px] text-zinc-500">Projets</div>
                            </div>
                            <div class="w-px bg-zinc-200 dark:bg-zinc-700"></div>
                            <div>
                                <div class="text-lg font-black text-raosc-green">{{ stats.activeProjects }}</div>
                                <div class="text-[9px] text-zinc-500">En cours</div>
                            </div>
                            <div class="w-px bg-zinc-200 dark:bg-zinc-700"></div>
                            <div>
                                <div class="text-lg font-black text-raosc-green">{{ stats.members }}</div>
                                <div class="text-[9px] text-zinc-500">Membres</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- CATÉGORIES - BANDE DÉDIÉE -->
                <!-- ============================================ -->
                <div class="py-4 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-xs text-zinc-400 font-medium">Domaines d'action :</span>
                        <div class="flex flex-wrap gap-2">
                            <span 
                                v-for="cat in org.categories" 
                                :key="cat.id" 
                                class="px-3 py-1 text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-full"
                            >
                                {{ cat.name }}
                            </span>
                            <span v-if="!org.categories?.length" class="text-xs text-zinc-400 italic">
                                Aucune catégorie renseignée
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- GRID PRINCIPALE - 2 COLONNES -->
                <!-- ============================================ -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 py-10 lg:py-12">
                    
                    <!-- ======================================== -->
                    <!-- COLONNE GAUCHE - SIDEBAR (33%) -->
                    <!-- ======================================== -->
                    <aside class="lg:col-span-1 space-y-6 order-2 lg:order-1">
                        
                        <!-- Contact -->
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl p-5">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <span class="w-6 h-px bg-raosc-green"></span>
                                Contact
                            </h3>
                            <div class="space-y-4">
                                <div v-if="org.email" class="flex items-start gap-3">
                                    <Mail class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] text-zinc-400 uppercase mb-0.5">Email</p>
                                        <a :href="`mailto:${org.email}`" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors break-all">
                                            {{ org.email }}
                                        </a>
                                    </div>
                                </div>
                                
                                <div v-if="org.phone" class="flex items-start gap-3">
                                    <PhoneCall class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase mb-0.5">Téléphone</p>
                                        <a :href="`tel:${org.phone}`" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green">
                                            {{ org.phone }}
                                        </a>
                                    </div>
                                </div>
                                
                                <div v-if="org.website" class="flex items-start gap-3">
                                    <Globe class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase mb-0.5">Site web</p>
                                        <a :href="org.website" target="_blank" class="text-sm font-medium text-raosc-green hover:underline break-all flex items-center gap-1">
                                            {{ org.website.replace(/^https?:\/\//, '') }}
                                            <ExternalLink class="w-3 h-3" />
                                        </a>
                                    </div>
                                </div>
                                
                                <div v-if="org.address" class="flex items-start gap-3">
                                    <Navigation class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase mb-0.5">Adresse</p>
                                        <p class="text-sm text-zinc-800 dark:text-zinc-200">{{ org.address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Réseaux sociaux -->
                        <div v-if="org.social_facebook || org.social_twitter || org.social_linkedin" class="bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl p-5">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <span class="w-6 h-px bg-raosc-green"></span>
                                Suivez-nous
                            </h3>
                            <div class="flex gap-3">
                                <a v-if="org.social_facebook" :href="org.social_facebook" target="_blank" 
                                   class="h-9 w-9 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all hover:scale-110">
                                    <Facebook class="w-4 h-4" />
                                </a>
                                <a v-if="org.social_twitter" :href="org.social_twitter" target="_blank"
                                   class="h-9 w-9 rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all hover:scale-110">
                                    <Twitter class="w-4 h-4" />
                                </a>
                                <a v-if="org.social_linkedin" :href="org.social_linkedin" target="_blank"
                                   class="h-9 w-9 rounded-full bg-[#0A66C2]/10 text-[#0A66C2] flex items-center justify-center hover:bg-[#0A66C2] hover:text-white transition-all hover:scale-110">
                                    <Linkedin class="w-4 h-4" />
                                </a>
                            </div>
                        </div>

                        <!-- Équipe dirigeante -->
                        <div v-if="org.responsible_name" class="bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl p-5">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                                <span class="w-6 h-px bg-raosc-green"></span>
                                <Briefcase class="w-3.5 h-3.5" /> Direction
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded-xl overflow-hidden border-2 border-raosc-green/20 shrink-0 bg-zinc-200">
                                        <img v-if="org.responsible_photo" :src="org.responsible_photo" class="h-full w-full object-cover" />
                                        <Users v-else class="h-full w-full p-2 text-zinc-400" />
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-raosc-green uppercase tracking-wider">Responsable</p>
                                        <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ org.responsible_name }}</p>
                                        <p v-if="org.responsible_email" class="text-xs text-zinc-500">{{ org.responsible_email }}</p>
                                    </div>
                                </div>

                                <div v-if="org.vice_responsible_name" class="flex items-center gap-3 pt-3 border-t border-zinc-200 dark:border-zinc-800">
                                    <div class="h-10 w-10 rounded-xl overflow-hidden border border-zinc-200 shrink-0 bg-zinc-200">
                                        <img v-if="org.vice_responsible_photo" :src="org.vice_responsible_photo" class="h-full w-full object-cover" />
                                        <Users v-else class="h-full w-full p-1.5 text-zinc-400" />
                                    </div>
                                    <div>
                                        <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-wider">Vice-Responsable</p>
                                        <p class="text-xs font-bold text-zinc-700 dark:text-zinc-300">{{ org.vice_responsible_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Document de présentation -->
                        <div v-if="org.presentation_doc" class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 rounded-2xl p-5 border border-blue-200 dark:border-blue-800">
                            <a :href="org.presentation_doc" target="_blank" class="flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-white dark:bg-zinc-800 shadow-md flex items-center justify-center">
                                        <FileText class="w-5 h-5 text-raosc-green" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-zinc-900 dark:text-white">Fiche de présentation</p>
                                        <p class="text-[9px] text-zinc-500">Télécharger le document</p>
                                    </div>
                                </div>
                                <Award class="w-4 h-4 text-blue-400 group-hover:text-blue-600 transition-colors" />
                            </a>
                        </div>
                    </aside>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE - CONTENU PRINCIPAL (66%) -->
                    <!-- ======================================== -->
                    <main class="lg:col-span-2 space-y-10 order-1 lg:order-2">
                        
                        <!-- Section Description -->
                        <section>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-8 h-px bg-raosc-green"></span>
                                <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-400">Présentation</h2>
                            </div>
                            
                            <div class="prose prose-lg dark:prose-invert max-w-none">
                                <p v-if="org.short_description" class="text-lg font-semibold text-zinc-900 dark:text-white leading-relaxed mb-4">
                                    {{ org.short_description }}
                                </p>
                                <div 
                                    v-if="org.description"
                                    class="text-zinc-600 dark:text-zinc-400 leading-relaxed"
                                    :class="{ 'line-clamp-6': !showFullDescription }"
                                >
                                    <div v-html="org.description.replace(/\n/g, '<br/>')"></div>
                                </div>
                                <button 
                                    v-if="org.description && org.description.length > 500"
                                    @click="showFullDescription = !showFullDescription"
                                    class="text-raosc-green font-semibold text-sm mt-3 hover:underline"
                                >
                                    {{ showFullDescription ? 'Voir moins' : 'Voir plus' }}
                                </button>
                                <div v-if="!org.short_description && !org.description" class="text-sm text-zinc-400 italic">
                                    Aucune description disponible.
                                </div>
                            </div>
                        </section>

                        <!-- Section Projets -->
                        <section v-if="org.projects && org.projects.length > 0">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-px bg-raosc-green"></span>
                                    <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-400 flex items-center gap-2">
                                        <Target class="w-4 h-4" /> Projets & Actions
                                    </h2>
                                </div>
                                <span class="text-xs font-bold text-raosc-green bg-raosc-green/10 px-2.5 py-1 rounded-full">
                                    {{ stats.projects }} projet(s)
                                </span>
                            </div>

                            <div class="space-y-5">
                                <div
                                    v-for="project in org.projects"
                                    :key="project.id"
                                    class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300"
                                >
                                    <div class="flex flex-col sm:flex-row">
                                        <!-- Image -->
                                        <div class="w-full sm:w-44 h-32 sm:h-auto shrink-0 overflow-hidden bg-zinc-100 dark:bg-zinc-800 relative">
                                            <img v-if="project.cover_image" 
                                                 :src="project.cover_image" 
                                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                                            <div v-else class="w-full h-full flex items-center justify-center text-zinc-300">
                                                <ImageIcon class="w-8 h-8" />
                                            </div>
                                            <div class="absolute top-2 left-2">
                                                <span :class="[
                                                    'px-2 py-0.5 rounded text-[8px] font-bold uppercase shadow-sm',
                                                    project.type === 'benevolat' ? 'bg-raosc-green text-white' : 'bg-raosc-yellow text-zinc-900'
                                                ]">
                                                    {{ project.type === 'benevolat' ? 'Bénévolat' : 'Projet' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Détails -->
                                        <div class="p-4 flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h3 class="text-base font-bold text-zinc-900 dark:text-white group-hover:text-raosc-green transition-colors">
                                                    {{ project.title }}
                                                </h3>
                                                <span :class="[
                                                    'px-2 py-0.5 rounded text-[8px] font-bold',
                                                    project.status === 'active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-zinc-100 text-zinc-500'
                                                ]">
                                                    {{ project.status === 'active' ? 'En cours' : 'Terminé' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed line-clamp-2">
                                                {{ project.description }}
                                            </p>
                                            <div class="mt-3 flex items-center gap-3">
                                                <button class="text-xs font-medium text-raosc-green hover:underline flex items-center gap-1">
                                                    En savoir plus <ChevronRightIcon class="w-3 h-3" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Section Galerie -->
                        <section v-if="gallery.length > 0">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-8 h-px bg-raosc-green"></span>
                                <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-400 flex items-center gap-2">
                                    <ImageIcon class="w-4 h-4" /> Galerie photos
                                </h2>
                            </div>
                            
                            <div class="relative rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 group">
                                <div class="h-64 md:h-80 w-full overflow-hidden">
                                    <transition name="fade" mode="out-in">
                                        <img
                                            :key="galleryIndex"
                                            :src="gallery[galleryIndex]"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        />
                                    </transition>
                                </div>
                                
                                <button 
                                    v-if="gallery.length > 1"
                                    @click="prevGallery" 
                                    class="absolute left-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full bg-black/50 hover:bg-black/70 text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all hover:scale-110"
                                >
                                    <ChevronLeft class="w-4 h-4" />
                                </button>
                                <button 
                                    v-if="gallery.length > 1"
                                    @click="nextGallery" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full bg-black/50 hover:bg-black/70 text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all hover:scale-110"
                                >
                                    <ChevronRight class="w-4 h-4" />
                                </button>
                                
                                <div class="absolute bottom-3 right-3 text-[10px] font-bold text-white bg-black/60 backdrop-blur-sm px-2 py-1 rounded-full">
                                    {{ galleryIndex + 1 }} / {{ gallery.length }}
                                </div>
                            </div>
                            
                            <div class="flex gap-2 mt-3 overflow-x-auto pb-2">
                                <button
                                    v-for="(img, idx) in gallery.slice(0, 6)"
                                    :key="idx"
                                    @click="galleryIndex = idx"
                                    class="h-14 w-16 shrink-0 rounded-lg overflow-hidden border-2 transition-all duration-300"
                                    :class="galleryIndex === idx ? 'border-raosc-green opacity-100' : 'border-transparent opacity-60 hover:opacity-100'"
                                >
                                    <img :src="img" class="h-full w-full object-cover" />
                                </button>
                            </div>
                        </section>

                        <!-- Section Équipe -->
                        <section v-if="org.members && org.members.length > 0">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-8 h-px bg-raosc-green"></span>
                                <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-400 flex items-center gap-2">
                                    <Users class="w-4 h-4" /> Équipe
                                </h2>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div v-for="member in org.members.slice(0, 6)" :key="member.id" 
                                     class="bg-zinc-50 dark:bg-zinc-900 rounded-xl p-3 text-center hover:shadow-md transition-all">
                                    <div class="h-12 w-12 mx-auto rounded-full bg-gradient-to-br from-raosc-green to-raosc-yellow flex items-center justify-center text-white font-bold text-lg mb-2">
                                        {{ member.user?.name?.charAt(0).toUpperCase() || '?' }}
                                    </div>
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white truncate">
                                        {{ member.user ? member.user.name : 'Membre' }}
                                    </p>
                                    <p class="text-[9px] text-zinc-500 truncate">{{ member.job_title || 'Membre' }}</p>
                                </div>
                            </div>
                        </section>

                    </main>
                </div>
            </div>
        </article>
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-6 {
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>