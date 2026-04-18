<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    MapPin, Building2, Mail, CheckCircle2, ArrowLeft,
    ChevronLeft, ChevronRight, Globe, PhoneCall, Navigation,
    Users, Target, Calendar, Image as ImageIcon
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
    projects?: { id: number, title: string, type: string, status: string, description: string }[];
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
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head :title="org.name + ' — RAOSC'" />

        <div class="bg-white dark:bg-zinc-950 min-h-screen">

            <!-- COVER -->
            <div class="relative w-full h-52 sm:h-64 bg-zinc-900 overflow-hidden">
                <img v-if="org.cover_image" :src="org.cover_image" class="absolute inset-0 w-full h-full object-cover opacity-40" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent" />
                <Link
                    :href="backUrl"
                    class="absolute top-5 left-5 sm:left-8 z-10 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-sm font-medium backdrop-blur-sm border border-white/10 transition-all"
                >
                    <ArrowLeft class="w-4 h-4" /> Retour
                </Link>
            </div>
            <!-- ... reste du template (déjà correct) ... -->

            <div class="mx-auto max-w-6xl px-5 sm:px-8">

                <!-- LOGO + NOM (chevauche le cover) -->
                <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4 -mt-12 sm:-mt-14 mb-8 relative z-10">
                    <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-2xl bg-white dark:bg-zinc-900 border-4 border-white dark:border-zinc-950 shadow-xl overflow-hidden shrink-0 flex items-center justify-center">
                        <img v-if="org.logo" :src="org.logo" class="h-full w-full object-cover" />
                        <Building2 v-else class="h-12 w-12 text-zinc-300" />
                    </div>
                    <div class="pb-1">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white leading-tight">{{ org.name }}</h1>
                            <CheckCircle2 class="w-5 h-5 text-raosc-green shrink-0" title="Organisation vérifiée" />
                        </div>
                        <p class="text-sm text-zinc-500 flex items-center gap-1.5">
                            <MapPin class="w-3.5 h-3.5" /> {{ org.city }}<span v-if="org.country">, {{ org.country }}</span>
                        </p>
                    </div>
                </div>

                <!-- CATÉGORIES -->
                <div class="flex flex-wrap gap-2 mb-8">
                    <span v-for="cat in org.categories" :key="cat.id" class="px-3 py-1 text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 rounded-full">
                        {{ cat.name }}
                    </span>
                </div>

                <hr class="border-zinc-100 dark:border-zinc-800 mb-10" />

                <!-- CORPS 2 COLONNES -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-20">

                    <!-- ── COLONNE GAUCHE (sidebar infos) ── -->
                    <aside class="lg:col-span-1 space-y-8 order-2 lg:order-1">

                        <!-- Coordonnées -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-4">Contact</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <Mail class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Email</p>
                                        <a :href="`mailto:${org.email}`" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors break-all">{{ org.email }}</a>
                                    </div>
                                </li>
                                <li v-if="org.phone" class="flex items-start gap-3">
                                    <PhoneCall class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Téléphone</p>
                                        <a :href="`tel:${org.phone}`" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors">{{ org.phone }}</a>
                                    </div>
                                </li>
                                <li v-if="org.website" class="flex items-start gap-3">
                                    <Globe class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Site web</p>
                                        <a :href="org.website" target="_blank" rel="noopener" class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:text-raosc-green transition-colors break-all">
                                            {{ org.website.replace(/^https?:\/\//, '') }}
                                        </a>
                                    </div>
                                </li>
                                <li v-if="org.address" class="flex items-start gap-3">
                                    <Navigation class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Adresse</p>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ org.address }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Infos légales -->
                        <div v-if="org.founded_date || org.registration_number">
                            <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-4">Informations</h3>
                            <ul class="space-y-3">
                                <li v-if="org.founded_date" class="flex items-start gap-3">
                                    <Calendar class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">Fondée en</p>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ new Date(org.founded_date).getFullYear() }}</p>
                                    </div>
                                </li>
                                <li v-if="org.registration_number" class="flex items-start gap-3">
                                    <CheckCircle2 class="w-4 h-4 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-[10px] text-zinc-400 uppercase tracking-wider mb-0.5">N° Enregistrement</p>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ org.registration_number }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Équipe -->
                        <div v-if="org.members && org.members.length > 0">
                            <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-4 flex items-center gap-1.5">
                                <Users class="w-3.5 h-3.5" /> Équipe
                            </h3>
                            <ul class="space-y-3">
                                <li v-for="member in org.members" :key="member.id" class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-full bg-raosc-green/10 text-raosc-green flex items-center justify-center font-bold text-sm shrink-0 select-none">
                                        {{ member.user ? member.user.name.charAt(0).toUpperCase() : '?' }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white leading-tight">{{ member.user ? member.user.name : 'Membre' }}</p>
                                        <p class="text-xs text-zinc-400">{{ member.job_title || 'Responsable' }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </aside>

                    <!-- ── COLONNE DROITE (contenu principal) ── -->
                    <main class="lg:col-span-2 space-y-12 order-1 lg:order-2">

                        <!-- À propos -->
                        <section>
                            <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-4">À propos</h2>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-white leading-relaxed mb-4">
                                {{ org.short_description }}
                            </p>
                            <div
                                v-if="org.description"
                                class="text-base text-zinc-500 dark:text-zinc-400 leading-relaxed"
                                v-html="org.description.replace(/\n/g, '<br>')"
                            />
                        </section>

                        <!-- Projets & Bénévolat -->
                        <section v-if="org.projects && org.projects.length > 0">
                            <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-5 flex items-center gap-1.5">
                                <Target class="w-3.5 h-3.5" /> Projets & Bénévolat
                            </h2>
                            <div class="space-y-3">
                                <div
                                    v-for="project in org.projects"
                                    :key="project.id"
                                    class="border border-zinc-100 dark:border-zinc-800 rounded-xl p-5 hover:border-zinc-200 dark:hover:border-zinc-700 transition-colors"
                                >
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <h3 class="text-base font-bold text-zinc-900 dark:text-white">{{ project.title }}</h3>
                                        <div class="flex gap-1.5 shrink-0">
                                            <span :class="['px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide', project.type === 'benevolat' ? 'bg-raosc-green/10 text-raosc-green' : 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400']">
                                                {{ project.type === 'benevolat' ? 'Bénévolat' : 'Projet' }}
                                            </span>
                                            <span :class="['px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide', project.status === 'active' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800']">
                                                {{ project.status === 'active' ? 'En cours' : 'Clôturé' }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-zinc-500 leading-relaxed">{{ project.description }}</p>
                                </div>
                            </div>
                        </section>

                        <!-- Galerie photos -->
                        <section v-if="gallery.length > 0">
                            <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-5 flex items-center gap-1.5">
                                <ImageIcon class="w-3.5 h-3.5" /> Galerie
                            </h2>
                            <div class="relative rounded-2xl overflow-hidden bg-zinc-900 group">
                                <div class="h-64 sm:h-80 w-full overflow-hidden">
                                    <transition name="fade" mode="out-in">
                                        <img
                                            :key="galleryIndex"
                                            :src="gallery[galleryIndex]"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                                        />
                                    </transition>
                                </div>
                                <button @click="prevGallery" class="absolute left-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full bg-black/50 hover:bg-black/70 border border-white/10 text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                    <ChevronLeft class="w-4 h-4" />
                                </button>
                                <button @click="nextGallery" class="absolute right-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full bg-black/50 hover:bg-black/70 border border-white/10 text-white flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                    <ChevronRight class="w-4 h-4" />
                                </button>
                                <span class="absolute bottom-3 right-3 text-xs font-bold text-white bg-black/50 backdrop-blur-sm px-2 py-0.5 rounded-full">
                                    {{ galleryIndex + 1 }}/{{ gallery.length }}
                                </span>
                            </div>
                            <!-- Miniatures -->
                            <div v-if="gallery.length > 1" class="flex gap-2 mt-3 overflow-x-auto pb-1">
                                <button
                                    v-for="(img, idx) in gallery"
                                    :key="idx"
                                    @click="galleryIndex = idx"
                                    class="h-12 w-16 shrink-0 rounded-lg overflow-hidden border-2 transition-all"
                                    :class="galleryIndex === idx ? 'border-raosc-green opacity-100' : 'border-transparent opacity-40 hover:opacity-80'"
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
.fade-enter-active, .fade-leave-active { transition: opacity 0.25s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>