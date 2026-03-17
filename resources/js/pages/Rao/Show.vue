<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    MapPin, Building2, Calendar, Mail, Phone, Globe, 
    Share2, ArrowLeft, CheckCircle2, Users, ExternalLink,
    ShieldCheck, Heart
} from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    organization: any;
    isPublic?: boolean;
}>();
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head :title="organization.name + ' - RAOSC'" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Header Image -->
            <div class="relative h-[20rem] sm:h-[30rem] w-full overflow-hidden bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
                <img v-if="organization.cover_image" :src="organization.cover_image" class="w-full h-full object-cover opacity-60" />
                <div v-else class="w-full h-full bg-gradient-to-br from-zinc-800 to-zinc-950"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                
                <div class="absolute top-8 left-6 sm:left-12 z-20">
                    <Link :href="isPublic ? '/rao' : '/dashboard/rao'">
                        <Button variant="outline" size="sm" class="rounded-full bg-white/20 backdrop-blur-md border-white/30 text-white hover:bg-white/30">
                            <ArrowLeft class="w-4 h-4 mr-2" /> Retour
                        </Button>
                    </Link>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-24 relative z-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- Sidebar (Profile) -->
                    <div class="lg:col-span-4 flex flex-col gap-6">
                        <Card class="shadow-xl bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden">
                            <div class="p-8 text-center flex flex-col items-center">
                                <!-- Logo -->
                                <div class="h-32 w-32 rounded-3xl bg-white dark:bg-zinc-800 shadow-lg ring-4 ring-white dark:ring-zinc-950 overflow-hidden mb-6 flex items-center justify-center border border-zinc-100 dark:border-zinc-800">
                                    <img v-if="organization.logo" :src="organization.logo" class="h-full w-full object-cover" />
                                    <Building2 v-else class="h-12 w-12 text-[#008751]" />
                                </div>
                                
                                <h1 class="text-2xl font-extrabold text-zinc-900 dark:text-white mb-2 tracking-tight">{{ organization.name }}</h1>
                                <div class="flex items-center text-[#008751] text-[10px] font-bold tracking-[0.1em]">
                                    <CheckCircle2 class="w-4 h-4 mr-1.5" />
                                    ONG Vérifiée
                                </div>
                            </div>
                            
                            <CardContent class="p-8 border-t border-zinc-50 dark:border-zinc-800">
                                <dl class="space-y-6">
                                    <div class="flex gap-4">
                                        <MapPin class="h-5 w-5 text-zinc-400 shrink-0" />
                                        <div>
                                            <dt class="text-[10px] font-bold uppercase text-zinc-400">Localisation</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white italic">
                                                {{ organization.city }}, {{ organization.country }}
                                            </dd>
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <Mail class="h-5 w-5 text-zinc-400 shrink-0" />
                                        <div>
                                            <dt class="text-[10px] font-bold uppercase text-zinc-400">Email</dt>
                                            <dd class="text-sm font-medium text-zinc-900 dark:text-white italic truncate">
                                                <a :href="`mailto:${organization.email}`" class="hover:text-[#008751]">{{ organization.email }}</a>
                                            </dd>
                                        </div>
                                    </div>
                                </dl>
                                
                                <div class="mt-8 pt-8 border-t border-zinc-50 dark:border-zinc-800">
                                    <Button class="w-full bg-[#008751] hover:bg-[#006b40] text-white rounded-xl py-6 font-bold text-xs shadow-lg shadow-[#008751]/10">
                                        Prendre Contact
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-8 flex flex-col gap-8">
                        <div class="bg-white dark:bg-zinc-900 p-8 sm:p-12 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
                            <div class="flex flex-wrap gap-2 mb-8">
                                <Badge v-for="cat in organization.categories" :key="cat.id" variant="outline" class="text-[9px] font-bold uppercase py-1 px-3">
                                    {{ cat.name }}
                                </Badge>
                            </div>
                            
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-zinc-900 dark:text-white mb-8 tracking-tight">À propos de <span class="text-[#008751]">l'ONG</span></h2>
                            
                            <div class="space-y-6">
                                <p class="text-lg sm:text-xl font-bold text-zinc-900 dark:text-white border-l-3 border-[#FFCB05] pl-6 py-2 leading-relaxed tracking-tight">
                                    {{ organization.short_description }}
                                </p>
                                <div class="text-zinc-600 dark:text-zinc-400 text-base leading-relaxed font-medium mt-6" v-if="organization.description" v-html="organization.description.replace(/\n/g, '<br>')"></div>
                            </div>

                            <div v-if="organization.members && organization.members.length > 0" class="mt-16 pt-12 border-t border-zinc-100 dark:border-zinc-800">
                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-8 flex items-center gap-3">
                                    <Users class="w-6 h-6 text-[#008751]" />
                                    Équipe de Direction
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div v-for="member in organization.members" :key="member.id" class="flex items-center gap-4 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                        <div class="h-12 w-12 rounded-xl bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center font-bold text-[#008751]">
                                            {{ member.user ? member.user.name.charAt(0) : '?' }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-zinc-900 dark:text-white uppercase italic tracking-tight">{{ member.user ? member.user.name : 'Membre' }}</p>
                                            <p class="text-[9px] font-bold text-[#FFCB05] uppercase tracking-widest">{{ member.job_title || 'Responsable' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </component>
</template>
