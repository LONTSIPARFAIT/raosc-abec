<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    MapPin, Building2, Calendar, Mail, CheckCircle2, Users, 
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
const gallery: string[] = props.organization.gallery || [];

const nextGallery = () => {
    galleryIndex.value = (galleryIndex.value + 1) % gallery.length;
};

const prevGallery = () => {
    galleryIndex.value = (galleryIndex.value - 1 + gallery.length) % gallery.length;
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
                        <Card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                            <div class="p-6 text-center">
                                <!-- Logo -->
                                <div class="h-28 w-28 rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-4 ring-white dark:ring-zinc-950 overflow-hidden mx-auto mb-5 flex items-center justify-center border border-zinc-100 dark:border-zinc-700">
                                    <img v-if="org.logo" :src="org.logo" class="h-full w-full object-cover" />
                                    <Building2 v-else class="h-10 w-10 text-raosc-green" />
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
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white">
                                                {{ org.city }}, {{ org.country }}
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
                                
                                <div class="mt-6 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                                    <Button class="w-full bg-raosc-green hover:bg-raosc-green/90 text-white rounded-xl text-sm font-semibold py-2.5 shadow-sm">
                                        Prendre contact
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                            <div class="flex flex-wrap gap-2 mb-6">
                                <Badge v-for="cat in org.categories" :key="cat.id" variant="outline" class="text-[10px] font-semibold py-1 px-3 rounded-full border-raosc-green/20 bg-raosc-green/5 text-raosc-green">
                                    {{ cat.name }}
                                </Badge>
                            </div>
                            
                            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white mb-6">À propos de <span class="text-raosc-green">l'organisation</span></h2>
                            
                            <div class="space-y-5">
                                <p class="text-lg font-semibold text-zinc-900 dark:text-white border-l-3 border-raosc-yellow pl-5 leading-relaxed">
                                    {{ org.short_description }}
                                </p>
                                <div class="text-zinc-600 dark:text-zinc-400 text-base leading-relaxed" v-if="org.description" v-html="org.description.replace(/\n/g, '<br>')"></div>
                            </div>

                            <!-- Technical Sheet -->
                            <div class="mt-10 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-6 border border-zinc-100 dark:border-zinc-700">
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                    <span class="w-1 h-5 bg-raosc-yellow rounded-full"></span>
                                    Fiche technique
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-lg bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center text-raosc-red border border-zinc-200 dark:border-zinc-700">
                                            <Calendar class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Fondation</p>
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ org.founded_date ? new Date(org.founded_date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' }) : 'Non spécifiée' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-lg bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center text-raosc-yellow border border-zinc-200 dark:border-zinc-700">
                                            <ShieldCheck class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">N° d'enregistrement</p>
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ org.registration_number || 'Non spécifié' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Team Section -->
                            <div v-if="org.members && org.members.length > 0" class="mt-10 pt-8 border-t border-zinc-100 dark:border-zinc-800">
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-5 flex items-center gap-2">
                                    <Users class="h-5 w-5 text-raosc-green" />
                                    Équipe de direction
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div v-for="member in org.members" :key="member.id" class="flex items-center gap-3 bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-xl border border-zinc-100 dark:border-zinc-700">
                                        <div class="h-10 w-10 rounded-lg bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center font-bold text-raosc-green text-sm">
                                            {{ member.user ? member.user.name.charAt(0).toUpperCase() : '?' }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ member.user ? member.user.name : 'Membre' }}</p>
                                            <p class="text-[10px] font-semibold text-raosc-yellow">{{ member.job_title || 'Responsable' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Section -->
                        <div v-if="gallery && gallery.length > 0" class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="p-6 sm:p-8 border-b border-zinc-100 dark:border-zinc-800">
                                <div class="flex items-center gap-2 mb-1">
                                    <ImageIcon class="h-5 w-5 text-raosc-green" />
                                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Médiathèque</h3>
                                </div>
                                <p class="text-xs text-zinc-500">Immersion dans les actions de l'organisation sur le terrain.</p>
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