<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    MapPin, Building2, Calendar, Mail, CheckCircle2, 
    ArrowLeft, Image as ImageIcon, ChevronLeft, ChevronRight, Globe, PhoneCall, Navigation, Users, Target
} from 'lucide-vue-next';
import { defineProps, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

const props = defineProps<{
    organization: { data: any };
    isPublic?: boolean;
}>();
const org = props.organization.data;

const galleryIndex = ref(0);
const gallery: string[] = org.gallery || [];

const nextGallery = () => {
    galleryIndex.value = (galleryIndex.value + 1) % gallery.length;
};

const prevGallery = () => {
    galleryIndex.value = (galleryIndex.value - 1 + gallery.length) % gallery.length;
};

// Fonction pour lier un pays à son drapeau
const getFlagEmoji = (countryName: string) => {
    if (!countryName) return '🌍';
    const flags: Record<string, string> = {
        'Cameroun': '🇨🇲', 'Sénégal': '🇸🇳', 'Côte d\'Ivoire': '🇨🇮', 'Mali': '🇲🇱',
        'Burkina Faso': '🇧🇫', 'Togo': '🇹🇬', 'Bénin': '🇧🇯', 'Niger': '🇳🇪',
        'Guinée': '🇬🇳', 'Tchad': '🇹🇩', 'République Centrafricaine': '🇨🇫',
        'Gabon': '🇬🇦', 'Congo': '🇨🇬', 'République Démocratique du Congo': '🇨🇩',
        'RDC': '🇨🇩', 'Rwanda': '🇷🇼', 'Burundi': '🇧🇮', 'Maroc': '🇲🇦',
        'Algérie': '🇩🇿', 'Tunisie': '🇹🇳', 'Madagascar': '🇲🇬', 'Djibouti': '🇩🇯',
        'Mauritanie': '🇲🇷', 'Comores': '🇰🇲', 'France': '🇫🇷', 'Canada': '🇨🇦',
        'Belgique': '🇧🇪', 'Suisse': '🇨🇭'
    };
    
    const normalized = countryName.trim();
    for (const [key, value] of Object.entries(flags)) {
        if (normalized.toLowerCase() === key.toLowerCase() || 
            normalized.toLowerCase().includes(key.toLowerCase())) {
            return value;
        }
    }
    return '🌍';
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head :title="org.name + ' - Profil'" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24 font-sans">
            <!-- Cover Header Professionnel -->
            <div class="relative h-[400px] w-full bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
                <img v-if="org.cover_image" :src="org.cover_image" class="w-full h-full object-cover opacity-60 mix-blend-overlay" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                
                <div class="absolute top-6 left-6 z-20">
                    <Link :href="isPublic ? '/rao' : '/dashboard/rao'" class="inline-flex items-center gap-2 px-4 py-2 bg-black/40 hover:bg-black/60 text-white backdrop-blur-md border border-white/10 rounded-full text-sm font-medium transition-all">
                        <ArrowLeft class="w-4 h-4" /> Retour
                    </Link>
                </div>

                <div class="absolute bottom-0 left-0 w-full px-4 sm:px-6 lg:px-8 pb-10">
                    <div class="mx-auto max-w-7xl flex flex-col md:flex-row gap-6 items-end">
                        <div class="h-32 w-32 rounded-xl bg-white dark:bg-zinc-900 shadow-xl border-4 border-white dark:border-zinc-800 overflow-hidden shrink-0 flex items-center justify-center -mb-16 z-30 relative group">
                            <img v-if="org.logo" :src="org.logo" class="h-full w-full object-cover" />
                            <Building2 v-else class="h-12 w-12 text-zinc-300" />
                        </div>
                        <div class="flex-1 text-white relative z-20">
                            <div class="flex items-center gap-2 mb-2">
                                <h1 class="text-3xl md:text-5xl font-bold tracking-tight">{{ org.name }}</h1>
                                <CheckCircle2 class="w-6 h-6 text-raosc-green mt-1" title="Structure Vérifiée" />
                            </div>
                            <div class="flex flex-wrap gap-4 text-sm md:text-base font-medium text-zinc-300">
                                <span class="flex items-center gap-1"><MapPin class="w-4 h-4" /> {{ org.city }}, {{ getFlagEmoji(org.country) }} {{ org.country }}</span>
                                <span v-if="org.founded_date" class="flex items-center gap-1"><Calendar class="w-4 h-4" /> Fondée en {{ new Date(org.founded_date).getFullYear() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-24">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Sidebar (Contact & Info) -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Card Contact -->
                        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-6">
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                                Coordonnées
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <Mail class="w-5 h-5 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-0.5">Contact direct</p>
                                        <a :href="`mailto:${org.email}`" class="text-sm font-medium text-zinc-900 dark:text-zinc-300 hover:text-raosc-green transition-colors break-all">{{ org.email }}</a>
                                    </div>
                                </li>
                                <li v-if="org.phone" class="flex items-start gap-3">
                                    <PhoneCall class="w-5 h-5 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-0.5">Téléphone</p>
                                        <a :href="`tel:${org.phone}`" class="text-sm font-medium text-zinc-900 dark:text-zinc-300 hover:text-raosc-green transition-colors">{{ org.phone }}</a>
                                    </div>
                                </li>
                                <li v-if="org.website" class="flex items-start gap-3">
                                    <Globe class="w-5 h-5 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-0.5">Site Officiel</p>
                                        <a :href="org.website" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-raosc-green hover:underline truncate inline-block max-w-xs">{{ org.website.replace(/^https?:\/\//, '') }}</a>
                                    </div>
                                </li>
                                <li v-if="org.address" class="flex items-start gap-3">
                                    <Navigation class="w-5 h-5 text-raosc-green mt-0.5 shrink-0" />
                                    <div>
                                        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-0.5">Adresse Physique</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-300 leading-relaxed">{{ org.address }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Card Tech Info -->
                        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-6">
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                                Fiche Statutaire
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-center justify-between py-2 border-b border-zinc-50 dark:border-zinc-800/50 last:border-0">
                                    <span class="text-sm text-zinc-500">Statut Réseau</span>
                                    <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded bg-emerald-50 text-emerald-600 border border-emerald-100">Vérifié</span>
                                </li>
                                <li class="flex items-center justify-between py-2 border-b border-zinc-50 dark:border-zinc-800/50 last:border-0">
                                    <span class="text-sm text-zinc-500">N° d'enregistrement</span>
                                    <span class="text-sm font-medium text-zinc-900 dark:text-zinc-300">{{ org.registration_number || 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Main Area -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- Secteurs & Description -->
                        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-8">
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span v-for="cat in org.categories" :key="cat.id" class="px-3 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded text-xs font-bold uppercase tracking-wide">
                                    {{ cat.name }}
                                </span>
                            </div>
                            
                            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">La vision</h2>
                            <p class="text-lg font-medium text-raosc-green leading-relaxed mb-6">
                                {{ org.short_description }}
                            </p>
                            
                            <div v-if="org.description" class="prose prose-zinc dark:prose-invert max-w-none text-zinc-600 dark:text-zinc-400">
                                <p v-html="org.description.replace(/\n/g, '<br>')"></p>
                            </div>
                        </div>

                        <!-- Projets & Bénévolat -->
                        <div v-if="org.projects && org.projects.length > 0" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20">
                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                    <Target class="w-5 h-5 text-raosc-green" /> Projets et Opportunités
                                </h3>
                            </div>
                            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                <div v-for="project in org.projects" :key="project.id" class="p-6 hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-colors">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        <div v-if="project.cover_image" class="w-full sm:w-48 h-32 rounded-xl overflow-hidden shrink-0 bg-zinc-100 dark:bg-zinc-800">
                                            <img :src="project.cover_image" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex gap-2 mb-3">
                                                <span :class="['px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded', project.type === 'benevolat' ? 'bg-raosc-green/10 text-raosc-green' : 'bg-raosc-yellow/10 text-raosc-yellow']">
                                                    {{ project.type === 'benevolat' ? 'Mission Bénévole' : 'Projet' }}
                                                </span>
                                                <span :class="['px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded border', project.status === 'active' ? 'border-emerald-200 text-emerald-600 bg-emerald-50' : 'border-zinc-200 text-zinc-500 bg-zinc-50']">
                                                    {{ project.status === 'active' ? 'En cours' : 'Clôturé' }}
                                                </span>
                                            </div>
                                            <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">{{ project.title }}</h4>
                                            <p class="text-sm text-zinc-500 leading-relaxed">{{ project.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Equipe Dirigeante -->
                        <div v-if="org.members && org.members.length > 0" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-8">
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                                <Users class="w-5 h-5 text-raosc-green" /> L'équipe clé
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div v-for="member in org.members" :key="member.id" class="flex items-center gap-4 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50 hover:border-raosc-green/30 transition-colors">
                                    <div class="h-12 w-12 rounded-full bg-raosc-green/10 text-raosc-green flex items-center justify-center font-bold text-lg select-none">
                                        {{ member.user ? member.user.name.charAt(0).toUpperCase() : '?' }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-zinc-900 dark:text-white text-sm">{{ member.user ? member.user.name : 'Membre' }}</p>
                                        <p class="text-xs font-semibold text-raosc-green">{{ member.job_title || 'Responsable' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Galerie Photo -->
                        <div v-if="gallery && gallery.length > 0" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-zinc-100 dark:border-zinc-800">
                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                    <ImageIcon class="w-5 h-5 text-raosc-green" /> Galerie Terrain
                                </h3>
                            </div>
                            <div class="relative group bg-zinc-950">
                                <div class="h-[400px] w-full overflow-hidden">
                                    <transition name="fade" mode="out-in">
                                        <div :key="galleryIndex" class="h-full w-full">
                                            <img :src="gallery[galleryIndex]" class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />
                                        </div>
                                    </transition>
                                </div>
                                <button @click="prevGallery" class="absolute left-4 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/50 hover:bg-black border border-white/20 text-white flex items-center justify-center backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all">
                                    <ChevronLeft class="w-5 h-5" />
                                </button>
                                <button @click="nextGallery" class="absolute right-4 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/50 hover:bg-black border border-white/20 text-white flex items-center justify-center backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all">
                                    <ChevronRight class="w-5 h-5" />
                                </button>
                                <div class="absolute bottom-4 right-4 bg-black/70 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full border border-white/10">
                                    {{ galleryIndex + 1 }} / {{ gallery.length }}
                                </div>
                            </div>
                            <div class="p-4 bg-zinc-50 dark:bg-zinc-800 flex gap-2 overflow-x-auto scrollbar-hide">
                                <button v-for="(img, idx) in gallery" :key="idx" @click="galleryIndex = idx" class="h-16 w-24 shrink-0 rounded-lg overflow-hidden border-2 transition-all focus:outline-none" :class="galleryIndex === idx ? 'border-raosc-green opacity-100 shadow-sm' : 'border-transparent opacity-50 hover:opacity-100'">
                                    <img :src="img" class="h-full w-full object-cover" />
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </component>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 20px;
}
.dark .scrollbar-thin::-webkit-scrollbar-thumb {
    background: #334155;
}
</style>