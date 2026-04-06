<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { ref } from 'vue';
import { PlusCircle, Target, Users, Trash2, ShieldAlert } from 'lucide-vue-next';

const props = defineProps<{
    projects: any[];
    organization: any;
}>();

const form = useForm({
    title: '',
    type: 'projet',
    description: '',
    status: 'active',
});

const isFormOpen = ref(false);

const submit = () => {
    form.post('/dashboard/projects', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            isFormOpen.value = false;
        },
    });
};

const deleteProject = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir retirer cet engagement public ?')) {
        form.delete(`/dashboard/projects/${id}`, {
            preserveScroll: true
        });
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Gestion Projets & Bénévolat" />

        <div class="p-6 lg:p-10 space-y-8 bg-zinc-50/50 dark:bg-zinc-950 min-h-screen">
            
            <!-- Affichage si pas d'organisation -->
            <div v-if="!organization" class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-3xl p-10 text-center max-w-2xl mx-auto mt-10">
                <div class="h-20 w-20 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
                    <ShieldAlert class="w-10 h-10" />
                </div>
                <h2 class="text-2xl font-bold dark:text-white mb-3 text-red-900 dark:text-red-400">Organisation Requise</h2>
                <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                    Vous devez d'abord lier votre compte à une organisation civile valide avant de pouvoir publier des initiatives.
                </p>
                <Link href="/rao/join" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold shadow-lg shadow-red-600/20 hover:scale-105 transition-transform">
                    Inscrire mon organisation
                </Link>
            </div>

            <div v-else>
                <!-- Entête premium -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10 bg-white dark:bg-zinc-900 p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:border dark:border-zinc-800">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-raosc-green/10 text-raosc-green text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                            Initiatives d'impact
                        </div>
                        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white mb-2">Projets & Bénévolats</h1>
                        <p class="text-zinc-500 max-w-xl">Mettez en lumière vos actions actives pour attirer des partenaires ou recruter des bénévoles engagés.</p>
                    </div>
                    <button 
                        @click="isFormOpen = true" 
                        class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-6 py-3.5 rounded-full font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-xl w-full sm:w-auto justify-center"
                    >
                        <PlusCircle class="w-5 h-5" />
                        Nouvelle initiative
                    </button>
                </div>

                <!-- Formulaire ajout ultra design -->
                <div v-if="isFormOpen" class="bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 p-8 sm:p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgb(0,0,0,0.1)] dark:shadow-none mb-10 animate-fade-in relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-raosc-green/5 rounded-full blur-[80px]"></div>
                    
                    <h3 class="text-2xl font-bold dark:text-white mb-8 relative z-10">Détails de l'initiative</h3>
                    <form @submit.prevent="submit" class="space-y-6 relative z-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-zinc-300">Titre saisissant</label>
                                <input v-model="form.title" type="text" placeholder="Ex: Forage hydraulique dans la région de..." required class="w-full h-12 px-4 rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-zinc-300">Type de l'action</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label :class="['flex items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all', form.type === 'projet' ? 'border-raosc-yellow bg-raosc-yellow/5' : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800']">
                                        <input type="radio" v-model="form.type" value="projet" class="hidden">
                                        <span class="font-bold flex items-center gap-2" :class="form.type === 'projet' ? 'text-raosc-yellow' : 'text-zinc-500'"><Target class="w-4 h-4"/> Projet</span>
                                    </label>
                                    <label :class="['flex items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all', form.type === 'benevolat' ? 'border-raosc-green bg-raosc-green/5' : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800']">
                                        <input type="radio" v-model="form.type" value="benevolat" class="hidden">
                                        <span class="font-bold flex items-center gap-2" :class="form.type === 'benevolat' ? 'text-raosc-green' : 'text-zinc-500'"><Users class="w-4 h-4"/> Bénévolat</span>
                                    </label>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold mb-2 dark:text-zinc-300">Description détaillée</label>
                                <textarea v-model="form.description" rows="4" placeholder="Expliquez les objectifs, l'impact direct..." required class="w-full p-4 rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green transition-all shadow-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-zinc-300">Statut actuel</label>
                                <select v-model="form.status" required class="w-full h-12 px-4 rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green shadow-sm">
                                    <option value="active">🟢 Actuellement en cours</option>
                                    <option value="completed">✅ Déjà terminé avec succès</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-4 justify-end mt-8 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                            <button type="button" @click="isFormOpen = false" class="px-6 py-3 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full font-bold transition-colors">Annuler</button>
                            <button type="submit" :disabled="form.processing" class="bg-raosc-green text-white px-8 py-3 rounded-full font-bold hover:shadow-lg hover:shadow-raosc-green/30 hover:-translate-y-0.5 transition-all">
                                Mettre en ligne
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste dynamique (Cartes premium) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="project in projects" 
                        :key="project.id" 
                        class="group bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 rounded-3xl p-8 shadow-sm hover:shadow-[0_10px_30px_rgb(0,0,0,0.06)] dark:hover:shadow-none transition-all duration-300 relative flex flex-col"
                    >
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex gap-2">
                                <span :class="['px-3 py-1 text-xs font-bold rounded-md', project.type === 'benevolat' ? 'bg-raosc-green/10 text-raosc-green' : 'bg-raosc-yellow/10 text-raosc-yellow']">
                                    {{ project.type === 'benevolat' ? 'Appel Bénévole' : 'Projet Terrain' }}
                                </span>
                            </div>
                            <span :class="['h-2 w-2 rounded-full', project.status === 'active' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-300']" title="Statut de l'initiative"></span>
                        </div>
                        
                        <h4 class="font-extrabold text-xl dark:text-white mb-3 leading-snug group-hover:text-raosc-green transition-colors">{{ project.title }}</h4>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-3 mb-6 flex-grow">{{ project.description }}</p>
                        
                        <div class="flex items-center justify-between pt-5 border-t border-zinc-100 dark:border-zinc-800">
                            <span class="text-xs font-bold text-zinc-400">Ajouté récemment</span>
                            <button @click="deleteProject(project.id)" class="text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 h-8 w-8 rounded-full flex items-center justify-center transition-all bg-zinc-50 dark:bg-zinc-800">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>

                    <!-- Carte vide stylée -->
                    <div v-if="!projects.length" class="lg:col-span-3 text-center py-20 bg-white/50 dark:bg-zinc-900/50 rounded-[3rem] border-2 border-dashed border-zinc-200 dark:border-zinc-800 flex flex-col items-center justify-center">
                        <div class="h-16 w-16 bg-zinc-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center text-zinc-400 mb-6 group-hover:scale-110 transition-transform">
                            <Target class="w-8 h-8" />
                        </div>
                        <h3 class="text-xl font-bold dark:text-white mb-2">Votre vitrine est vide</h3>
                        <p class="text-zinc-500 max-w-sm mb-6">Attirez l'attention des investisseurs en ajoutant votre premier projet concret.</p>
                        <button @click="isFormOpen = true" class="text-raosc-green font-bold text-sm hover:underline">
                            + Publier ma première action
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
