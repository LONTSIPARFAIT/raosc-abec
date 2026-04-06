<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    MapPin, Building2, Calendar, Mail, CheckCircle2, 
    ArrowLeft, ShieldCheck, Image as ImageIcon, ChevronLeft, ChevronRight, Globe, PhoneCall, Navigation
} from 'lucide-vue-next';
import { defineProps, ref } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
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
        'Cameroun': '🇨🇲',
        'Sénégal': '🇸🇳',
        'Côte d\'Ivoire': '🇨🇮',
        'Mali': '🇲🇱',
        'Burkina Faso': '🇧🇫',
        'Togo': '🇹🇬',
        'Bénin': '🇧🇯',
        'Niger': '🇳🇪',
        'Guinée': '🇬🇳',
        'Tchad': '🇹🇩',
        'République Centrafricaine': '🇨🇫',
        'Gabon': '🇬🇦',
        'Congo': '🇨🇬',
        'République Démocratique du Congo': '🇨🇩',
        'RDC': '🇨🇩',
        'Rwanda': '🇷🇼',
        'Burundi': '🇧🇮',
        'Maroc': '🇲🇦',
        'Algérie': '🇩🇿',
        'Tunisie': '🇹🇳',
        'Madagascar': '🇲🇬',
        'Djibouti': '🇩🇯',
        'Mauritanie': '🇲🇷',
        'Comores': '🇰🇲',
        'France': '🇫🇷',
        'Canada': '🇨🇦',
        'Belgique': '🇧🇪',
        'Suisse': '🇨🇭'
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
        <Head :title="org.name + ' - RAOSC'" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Cover Image -->
            <div class="relative h-64 sm:h-80 md:h-96 w-full overflow-hidden bg-zinc-900">
                <img v-if="org.cover_image" :src="org.cover_image" class="w-full h-full object-cover opacity-80" />
                <div v-else class="w-full h-full bg-gradient-to-r from-raosc-green/80 to-zinc-800"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                
                <div class="absolute top-6 left-6 sm:left-8 z-20">
                    <Link :href="isPublic ? '/rao' : '/dashboard/rao'">
                        <Button variant="outline" size="sm" class="rounded-full bg-white/20 backdrop-blur-sm border-white/30 text-white hover:bg-white/30 text-xs">
                            <ArrowLeft class="w-4 h-4 mr-2" /> Retour
                        </Button>
                    </Link>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20 relative z-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                    
                    <!-- Sidebar (Profile) -->
                    <div class="lg:col-span-4 space-y-6">
                        <Card class="bg-transparent dark:bg-zinc-900 border-none overflow-hidden">
                            <div class="p-6 text-center">
                                <!-- Logo -->
                                <div class="h-32 w-32 rounded-3xl bg-white dark:bg-zinc-800 shadow-xl shadow-zinc-200/50 dark:shadow-none ring-8 ring-white dark:ring-zinc-950 overflow-hidden mx-auto mb-6 flex items-center justify-center border-none">
                                    <img v-if="org.logo" :src="org.logo" class="h-full w-full object-cover" />
                                    <Building2 v-else class="h-12 w-12 text-raosc-green" />
                                </div>
                                
                                <h1 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">{{ org.name }}</h1>
                                <div class="inline-flex items-center gap-1.5 text-raosc-green text-[10px] font-semibold bg-raosc-green/5 px-3 py-1 rounded-full">
                                    <CheckCircle2 class="w-3 h-3" />
                                    ONG vérifiée
                                </div>
                            </div>
                            
                            <CardContent class="p-6 pt-0 border-t border-zinc-100 dark:border-zinc-800">
                                <dl class="space-y-5">
                                    <div class="flex gap-3">
                                        <MapPin class="h-4 w-4 text-zinc-400 shrink-0 mt-0.5" />
                                        <div>
                                            <dt class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Localisation</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white flex items-center gap-1.5 mt-0.5">
                                                <span>{{ org.city }},</span>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-xs font-semibold">
                                                    {{ getFlagEmoji(org.country) }} {{ org.country }}
                                                </span>
                                            </dd>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <Mail class="h-4 w-4 text-zinc-400 shrink-0 mt-0.5" />
                                        <div>
                                            <dt class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Email</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white truncate">
                                                <a :href="`mailto:${org.email}`" class="hover:text-raosc-green transition-colors">{{ org.email }}</a>
                                            </dd>
                                        </div>
                                    </div>
                                    <div v-if="org.phone" class="flex gap-3">
                                        <PhoneCall class="h-4 w-4 text-zinc-400 shrink-0 mt-0.5" />
                                        <div>
                                            <dt class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Téléphone</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white">
                                                <a :href="`tel:${org.phone}`" class="hover:text-raosc-green transition-colors">{{ org.phone }}</a>
                                            </dd>
                                        </div>
                                    </div>
                                    <div v-if="org.address" class="flex gap-3">
                                        <Navigation class="h-4 w-4 text-zinc-400 shrink-0 mt-0.5" />
                                        <div>
                                            <dt class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Adresse</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white">{{ org.address }}</dd>
                                        </div>
                                    </div>
                                    <div v-if="org.website" class="flex gap-3">
                                        <Globe class="h-4 w-4 text-zinc-400 shrink-0 mt-0.5" />
                                        <div>
                                            <dt class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Site Web</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white truncate">
                                                <a :href="org.website" target="_blank" rel="noopener noreferrer" class="hover:text-raosc-green transition-colors">
                                                    {{ org.website.replace(/^https?:\/\//, '') }}
                                                </a>
                                            </dd>
                                        </div>
                                    </div>
                                </dl>
                                
                                <div class="mt-8 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                                    <Button class="w-full bg-raosc-green hover:bg-raosc-green/90 text-white rounded-2xl text-sm font-bold py-3 shadow-lg shadow-raosc-green/20">
                                        Prendre contact
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-transparent p-0">
                            <div class="flex flex-wrap gap-2 mb-8">
                                <Badge v-for="cat in org.categories" :key="cat.id" variant="secondary" class="text-[10px] font-bold py-1.5 px-4 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-none">
                                    {{ cat.name }}
                                </Badge>
                            </div>
                            
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-300 dark:text-white mb-6">À propos de <span class="text-raosc-green">l'organisation</span></h2>
                            
                            <div class="space-y-6">
                                <p class="text-xl font-semibold text-zinc-900 dark:text-white leading-relaxed">
                                    {{ org.short_description }}
                                </p>
                                <div class="text-zinc-500 dark:text-zinc-400 text-lg leading-relaxed space-y-4" v-if="org.description" v-html="org.description.replace(/\n/g, '<br>')"></div>
                            </div>

                            <!-- Technical Sheet -->
                            <div class="mt-12 bg-zinc-100/40 dark:bg-zinc-800/20 rounded-3xl p-8 border-none">
                                <h3 class="text-lg font-black text-zinc-900 dark:text-white mb-6 flex items-center gap-2 uppercase tracking-tighter">
                                    Information Technique
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-2xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center text-raosc-red border-none">
                                            <Calendar class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Fondation</p>
                                            <p class="text-base font-bold text-zinc-900 dark:text-white">{{ org.founded_date ? new Date(org.founded_date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' }) : 'Non spécifiée' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-2xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center text-raosc-yellow border-none">
                                            <ShieldCheck class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Enregistrement</p>
                                            <p class="text-base font-bold text-zinc-900 dark:text-white">{{ org.registration_number || 'Non spécifié' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Team Section -->
                            <div v-if="org.members && org.members.length > 0" class="mt-12 pt-8 border-none">
                                <h3 class="text-lg font-black text-zinc-900 dark:text-white mb-6 flex items-center gap-2 uppercase tracking-tighter">
                                    Notre Équipe
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div v-for="member in org.members" :key="member.id" class="flex items-center gap-4 bg-zinc-100/40 dark:bg-zinc-800/20 p-5 rounded-3xl">
                                        <div class="h-14 w-14 rounded-2xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center font-black text-raosc-green text-lg">
                                            {{ member.user ? member.user.name.charAt(0).toUpperCase() : '?' }}
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-zinc-900 dark:text-white">{{ member.user ? member.user.name : 'Membre' }}</p>
                                            <p class="text-xs font-bold text-raosc-yellow uppercase tracking-widest">{{ member.job_title || 'Responsable' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Section -->
                        <div v-if="gallery && gallery.length > 0" class="bg-white dark:bg-zinc-900 rounded-[3rem] overflow-hidden mt-12 shadow-2xl shadow-zinc-200/50 dark:shadow-none">
                            <div class="p-8 sm:p-10 border-none">
                                <div class="flex items-center gap-3 mb-2">
                                    <ImageIcon class="h-6 w-6 text-raosc-green" />
                                    <h3 class="text-xl font-black text-zinc-900 dark:text-white uppercase tracking-tighter">Actions en images</h3>
                                </div>
                                <p class="text-sm text-zinc-500 font-medium">Découvrez notre impact sur le terrain à travers ces quelques clichés.</p>
                            </div>
                            
                            <div class="relative group">
                                <div class="h-64 sm:h-80 md:h-96 w-full overflow-hidden bg-zinc-950">
                                    <transition name="fade" mode="out-in">
                                        <div :key="galleryIndex" class="h-full w-full">
                                            <img :src="gallery[galleryIndex]" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" />
                                            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        </div>
                                    </transition>
                                </div>

                                <!-- Gallery Controls -->
                                <button 
                                    @click="prevGallery" 
                                    class="absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-black/60"
                                >
                                    <ChevronLeft class="w-5 h-5" />
                                </button>
                                <button 
                                    @click="nextGallery" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-black/60"
                                >
                                    <ChevronRight class="w-5 h-5" />
                                </button>

                                <!-- Counter -->
                                <div class="absolute bottom-4 right-4 z-10">
                                    <span class="text-[10px] font-semibold text-white bg-black/40 backdrop-blur-sm px-3 py-1.5 rounded-full">
                                        {{ galleryIndex + 1 }} / {{ gallery.length }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Thumbnails -->
                            <div class="p-4 bg-zinc-50 dark:bg-zinc-800/20 flex gap-3 overflow-x-auto scrollbar-thin">
                                <button 
                                    v-for="(img, idx) in gallery" 
                                    :key="idx"
                                    @click="galleryIndex = idx"
                                    class="h-16 w-24 shrink-0 rounded-lg overflow-hidden border-2 transition-all"
                                    :class="galleryIndex === idx ? 'border-raosc-green shadow-md' : 'border-transparent opacity-60 hover:opacity-100'"
                                >
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
.scrollbar-thin::-webkit-scrollbar {
    height: 4px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 20px;
}
.dark .scrollbar-thin::-webkit-scrollbar-thumb {
    background: #334155;
}
</style>