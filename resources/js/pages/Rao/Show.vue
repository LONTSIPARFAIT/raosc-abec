<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { 
    MapPin, Building2, Calendar, Mail, Phone, Globe, 
    Share2, ArrowLeft, CheckCircle2, Users
} from 'lucide-vue-next';

defineProps({
    organization: Object
});
</script>

<template>
    <AppLayout>
        <Head :title="organization.name + ' - RAO'" />

        <!-- Header Hero Image -->
        <div class="relative h-64 md:h-80 w-full overflow-hidden bg-slate-100 dark:bg-slate-900 border-b dark:border-slate-800">
            <img v-if="organization.cover_image" :src="organization.cover_image" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
            
            <div class="absolute top-4 left-4">
                <Link :href="route('rao.index')">
                    <Button variant="outline" size="sm" class="bg-white/10 backdrop-blur-md border-white/20 text-white hover:bg-white/20">
                        <ArrowLeft class="w-4 h-4 mr-2" /> Retour à l'annuaire
                    </Button>
                </Link>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-24 relative z-10 pb-16">
            <div class="flex flex-col md:flex-row gap-8">
                
                <!-- Left Sidebar (Profile Info) -->
                <div class="w-full md:w-1/3 lg:w-1/4 flex flex-col gap-6">
                    <Card class="shadow-xl border-slate-200/50 dark:border-slate-800/50 overflow-hidden">
                        <div class="p-6 text-center flex flex-col items-center border-b dark:border-slate-800">
                            <!-- Logo -->
                            <div class="h-32 w-32 rounded-2xl bg-white dark:bg-slate-800 shadow-lg ring-4 ring-white dark:ring-slate-900 overflow-hidden mb-4 flex items-center justify-center">
                                <img v-if="organization.logo" :src="organization.logo" class="h-full w-full object-cover" />
                                <Building2 v-else class="h-16 w-16 text-slate-300" />
                            </div>
                            
                            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ organization.name }}</h1>
                            <div class="flex items-center text-emerald-600 mt-2 text-sm font-medium">
                                <CheckCircle2 class="w-4 h-4 mr-1" />
                                Organisation Vérifiée
                            </div>
                        </div>
                        
                        <CardContent class="p-0">
                            <!-- Contact Info -->
                            <div class="p-6 flex flex-col gap-4 text-sm text-slate-600 dark:text-slate-300">
                                <div v-if="organization.country || organization.city" class="flex items-start gap-3">
                                    <MapPin class="w-5 h-5 text-slate-400 shrink-0" />
                                    <span>
                                        {{ organization.address }}<br v-if="organization.address" />
                                        {{ organization.city }}, {{ organization.country }}
                                    </span>
                                </div>
                                
                                <div v-if="organization.email" class="flex items-center gap-3">
                                    <Mail class="w-5 h-5 text-slate-400 shrink-0" />
                                    <a :href="`mailto:${organization.email}`" class="hover:text-blue-600 hover:underline">{{ organization.email }}</a>
                                </div>
                                
                                <div v-if="organization.phone" class="flex items-center gap-3">
                                    <Phone class="w-5 h-5 text-slate-400 shrink-0" />
                                    <span>{{ organization.phone }}</span>
                                </div>
                                
                                <div v-if="organization.website" class="flex items-center gap-3">
                                    <Globe class="w-5 h-5 text-slate-400 shrink-0" />
                                    <a :href="organization.website" target="_blank" class="hover:text-blue-600 hover:underline break-all">{{ organization.website }}</a>
                                </div>
                                
                                <div v-if="organization.founded_date" class="flex items-center gap-3">
                                    <Calendar class="w-5 h-5 text-slate-400 shrink-0" />
                                    <span>Fondée en {{ new Date(organization.founded_date).getFullYear() }}</span>
                                </div>
                            </div>
                            
                            <!-- Action buttons -->
                            <div class="p-6 border-t dark:border-slate-800 flex flex-col gap-3 ActionButtons">
                                <Button class="w-full bg-blue-600 hover:bg-blue-700">Contacter</Button>
                                <Button variant="outline" class="w-full">
                                    <Share2 class="w-4 h-4 mr-2" /> Partager
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Content (Details) -->
                <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col gap-8 mt-4 md:mt-24">
                    
                    <div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <Badge v-for="cat in organization.categories" :key="cat.id" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border-none px-3 py-1">
                                {{ cat.name }}
                            </Badge>
                        </div>
                        
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">À propos de l'organisation</h2>
                        <Card class="border-none shadow-md overflow-hidden bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm">
                            <CardContent class="p-8 prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                                <div class="text-lg font-medium mb-6 text-slate-800 dark:text-slate-200">
                                    {{ organization.short_description }}
                                </div>
                                
                                <div v-if="organization.description" v-html="organization.description.replace(/\n/g, '<br>')"></div>
                                <div v-else class="italic opacity-70">Aucune description détaillée n'a été fournie.</div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Members Section -->
                    <div v-if="organization.members && organization.members.length > 0" class="mt-8">
                        <div class="flex items-center gap-2 mb-6">
                            <Users class="w-6 h-6 text-blue-600" />
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Représentants</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <Card v-for="member in organization.members" :key="member.id" class="border-slate-200/50 dark:border-slate-800/50 shadow-sm">
                                <CardContent class="p-4 flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold text-slate-500 overflow-hidden shrink-0">
                                        <template v-if="member.user">
                                            {{ member.user.name.charAt(0) }}
                                        </template>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-white" v-if="member.user">{{ member.user.name }}</p>
                                        <p class="text-xs text-slate-500">{{ member.job_title || 'Membre' }}</p>
                                        <Badge variant="outline" class="mt-1 text-[10px] leading-tight px-1.5 py-0" v-if="member.role === 'admin'">Administrateur</Badge>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
