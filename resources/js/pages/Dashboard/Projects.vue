<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { ref } from 'vue';

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
    if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
        form.delete(`/dashboard/projects/${id}`);
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Gestion Projets & Bénévolat" />

        <div class="px-4 py-8 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold dark:text-white">Projets & Bénévolats</h1>
                    <p class="text-sm text-zinc-500">Ajoutez et gérez vos activités de structure.</p>
                </div>
                <button @click="isFormOpen = true" class="bg-raosc-green text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-raosc-green/90 transition-colors">
                    Nouveau
                </button>
            </div>

            <!-- Formulaire ajout -->
            <div v-if="isFormOpen" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-bold mb-4 dark:text-white">Ajouter un élément</h3>
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Titre</label>
                            <input v-model="form.title" type="text" required class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Type</label>
                            <select v-model="form.type" required class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                                <option value="projet">Projet</option>
                                <option value="benevolat">Bénévolat</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Description</label>
                            <textarea v-model="form.description" rows="3" required class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Statut</label>
                            <select v-model="form.status" required class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                                <option value="active">En cours</option>
                                <option value="completed">Terminé</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 justify-end mt-4">
                        <button type="button" @click="isFormOpen = false" class="px-4 py-2 text-zinc-500 hover:bg-zinc-100 rounded-xl text-sm font-semibold transition-colors">Annuler</button>
                        <button type="submit" :disabled="form.processing" class="bg-raosc-green text-white px-6 py-2 rounded-xl text-sm font-semibold hover:bg-raosc-green/90 transition-colors">Enregistrer</button>
                    </div>
                </form>
            </div>

            <!-- Liste dynamique -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-for="project in projects" :key="project.id" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm relative">
                    <div class="flex gap-2 mb-3">
                        <Badge :class="project.type === 'benevolat' ? 'bg-raosc-green/10 text-raosc-green' : 'bg-raosc-yellow/10 text-raosc-yellow'">
                            {{ project.type === 'benevolat' ? 'Bénévolat' : 'Projet' }}
                        </Badge>
                        <Badge :class="project.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-zinc-100 text-zinc-500'">
                            {{ project.status === 'active' ? 'En cours' : 'Terminé' }}
                        </Badge>
                    </div>
                    <h4 class="font-bold text-lg dark:text-white mb-2">{{ project.title }}</h4>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-3 mb-4">{{ project.description }}</p>
                    
                    <button @click="deleteProject(project.id)" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-1 rounded-lg text-xs font-semibold transition-colors absolute bottom-4 right-4">
                        Supprimer
                    </button>
                </div>
                <div v-if="!projects.length" class="md:col-span-2 text-center text-zinc-500 py-10 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800">
                    Aucun projet ni bénévolat ajouté.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
