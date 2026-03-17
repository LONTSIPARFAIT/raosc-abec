<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Building2, Info, ArrowRight, CheckCircle2, MapPin, Mail, Phone } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

const props = defineProps<{
    categories: any[];
    isPublic?: boolean;
}>();

const form = useForm({
    name: '',
    short_description: '',
    description: '',
    email: '',
    phone: '',
    country: '',
    city: '',
    address: '',
    registration_number: '',
    founded_date: '',
    categories: [] as number[],
});

const submit = () => {
    form.post('/rao/join');
};

const toggleCategory = (id: number) => {
    const index = form.categories.indexOf(id);
    if (index === -1) {
        form.categories.push(id);
    } else {
        form.categories.splice(index, 1);
    }
};
</script>

<template>
    <component :is="isPublic ? PublicLayout : AppLayout">
        <Head title="Enregistrer une organisation - RAOSC" />

        <div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen pb-24">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-20 sm:py-32 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#008751] opacity-5 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/5 px-4 py-2 border border-white/10 backdrop-blur-xl">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white">Adhésion</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-7xl font-black text-white uppercase italic tracking-tighter leading-none mb-6">
                        Inscrire votre <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#008751] to-[#FFCB05]">Organisation</span>
                    </h1>
                    <p class="text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                        Rejoignez le Réseau Africain pour amplifier votre impact et accéder à des partenariats stratégiques.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-4xl px-6 -mt-16 sm:-mt-24 relative z-20">
                <Card class="shadow-3xl border-zinc-200 dark:border-zinc-800 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-2xl rounded-[3rem] overflow-hidden">
                    <CardContent class="p-8 sm:p-12">
                        <form @submit.prevent="submit" class="space-y-12">
                            
                            <!-- Informations Générales -->
                            <section>
                                <div class="flex items-center gap-4 mb-10 border-b border-zinc-100 dark:border-zinc-800 pb-6">
                                    <div class="h-12 w-12 rounded-2xl bg-[#008751]/10 flex items-center justify-center text-[#008751]">
                                        <Building2 class="h-6 w-6" />
                                    </div>
                                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white uppercase italic tracking-tighter">Identité</h2>
                                </div>
                                
                                <div class="space-y-8">
                                    <div class="group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Nom officiel de l'OSC <span class="text-[#E4002B]">*</span></label>
                                        <input v-model="form.name" type="text" required placeholder="Ex: Développement Pour Tous" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                        <div v-if="form.errors.name" class="text-[#E4002B] text-[10px] font-bold mt-2 ml-2 uppercase tracking-widest">{{ form.errors.name }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2 text-left">Domaines d'intervention <span class="text-[#E4002B]">*</span></label>
                                        <div class="flex flex-wrap gap-3 p-4 bg-zinc-50 dark:bg-zinc-950 rounded-3xl border border-zinc-200 dark:border-zinc-800">
                                            <div 
                                                v-for="cat in categories" 
                                                :key="cat.id"
                                                @click="toggleCategory(cat.id)"
                                                class="cursor-pointer px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all select-none border"
                                                :class="form.categories.includes(cat.id) ? 'bg-[#008751] text-white border-[#008751] shadow-lg' : 'bg-white dark:bg-zinc-900 text-zinc-500 border-zinc-200 dark:border-zinc-800 hover:border-[#008751]/30'"
                                            >
                                                {{ cat.name }}
                                            </div>
                                        </div>
                                        <div v-if="form.errors.categories" class="text-[#E4002B] text-[10px] font-bold mt-2 ml-2 uppercase tracking-widest">{{ form.errors.categories }}</div>
                                    </div>

                                    <div class="group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Résumé de mission <span class="text-[#E4002B]">*</span></label>
                                        <textarea v-model="form.short_description" required rows="3" placeholder="Décrivez en quelques mots l'essence de votre engagement..." class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-3xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic resize-none"></textarea>
                                        <div v-if="form.errors.short_description" class="text-[#E4002B] text-[10px] font-bold mt-2 ml-2 uppercase tracking-widest">{{ form.errors.short_description }}</div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="group">
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">N° Enregistrement Officiel</label>
                                            <input v-model="form.registration_number" type="text" placeholder="Ex: 2024/001/MISP/..." class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                        </div>
                                        <div class="group">
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Date de Fondation</label>
                                            <input v-model="form.founded_date" type="date" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium" />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Coordonnées -->
                            <section>
                                <div class="flex items-center gap-4 mb-10 border-b border-zinc-100 dark:border-zinc-800 pb-6">
                                    <div class="h-12 w-12 rounded-2xl bg-[#FFCB05]/10 flex items-center justify-center text-[#FFCB05]">
                                        <Info class="h-6 w-6" />
                                    </div>
                                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white uppercase italic tracking-tighter">Localisation & Contact</h2>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Email Professionnel <span class="text-[#E4002B]">*</span></label>
                                        <input v-model="form.email" type="email" required placeholder="contact@votre-ong.org" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                        <div v-if="form.errors.email" class="text-[#E4002B] text-[10px] font-bold mt-2 ml-2 uppercase tracking-widest">{{ form.errors.email }}</div>
                                    </div>
                                    
                                    <div class="group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Téléphone</label>
                                        <input v-model="form.phone" type="text" placeholder="+229 ..." class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                    </div>

                                    <div class="group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Pays <span class="text-[#E4002B]">*</span></label>
                                        <input v-model="form.country" type="text" required placeholder="Bénin" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                        <div v-if="form.errors.country" class="text-[#E4002B] text-[10px] font-bold mt-2 ml-2 uppercase tracking-widest">{{ form.errors.country }}</div>
                                    </div>

                                    <div class="group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Ville <span class="text-[#E4002B]">*</span></label>
                                        <input v-model="form.city" type="text" required placeholder="Cotonou" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                    </div>

                                    <div class="md:col-span-2 group">
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 ml-2">Adresse détaillée</label>
                                        <input v-model="form.address" type="text" placeholder="Rue, Quartier, Porte..." class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#008751]/20 focus:border-[#008751] outline-none transition-all dark:text-white font-medium italic" />
                                    </div>
                                </div>
                            </section>

                            <div class="pb-6 border-t border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row justify-end gap-6 pt-12">
                                <Link :href="isPublic ? '/rao' : '/dashboard/rao'" class="order-2 sm:order-1">
                                    <Button type="button" variant="outline" class="w-full sm:w-auto rounded-full py-7 px-10 font-black uppercase tracking-widest text-[10px] border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                        Annuler
                                    </Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing" class="order-1 sm:order-2 w-full sm:w-auto bg-[#008751] hover:bg-[#006b40] text-white rounded-full py-7 px-12 font-black uppercase tracking-widest text-[10px] shadow-2xl shadow-[#008751]/20 transform hover:-translate-y-1 transition-all">
                                    <span v-if="form.processing" class="flex items-center gap-2 italic">Traitement en cours...</span>
                                    <span v-else class="flex items-center gap-2">Soumettre mon Dossier <ArrowRight class="w-4 h-4 ml-2" /></span>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>

                <div class="mt-12 text-center flex flex-col items-center">
                    <div class="h-10 w-10 rounded-full bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex items-center justify-center text-[#008751] mb-6">
                        <CheckCircle2 class="h-6 w-6" />
                    </div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-zinc-400 mb-2">Charte de confiance</p>
                    <p class="text-xs text-zinc-500 font-medium italic max-w-lg leading-relaxed">En soumettant ce formulaire, vous certifiez que l'organisation existe légalement et que vous avez l'autorité pour l'inscrire au RAOSC.</p>
                </div>
            </div>
        </div>
    </component>
</template>
