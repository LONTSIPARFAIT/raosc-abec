<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { FileText, PlusCircle, Trash2, Edit2, X } from 'lucide-vue-next';

defineProps<{
    categories: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '/dashboard' },
    { title: 'Catégories', href: '/admin/categories' }
];

const editingCategory = ref<any>(null);

const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    if (editingCategory.value) {
        form.put(`/admin/categories/${editingCategory.value.id}`, {
            preserveScroll: true,
            onSuccess: () => cancelEdit(),
        });
    } else {
        form.post('/admin/categories', {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
};

const startEdit = (category: any) => {
    editingCategory.value = category;
    form.name = category.name;
    form.description = category.description;
};

const cancelEdit = () => {
    editingCategory.value = null;
    form.reset();
};

const deleteCategory = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        useForm({}).delete(`/admin/categories/${id}`, {
            preserveScroll: true
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Gestion des Catégories" />

        <div class="p-6 lg:p-8 space-y-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-raosc-green/10 flex items-center justify-center text-raosc-green">
                    <FileText class="w-5 h-5" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold dark:text-white">Gestion des Catégories</h1>
                    <p class="text-sm text-zinc-500">Ajoutez, modifiez ou supprimez les secteurs d'activité des ONG.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Formulaire d'ajout / modification -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm h-fit sticky top-24">
                    <h3 class="text-lg font-bold mb-4 dark:text-white flex items-center gap-2">
                        <component :is="editingCategory ? Edit2 : PlusCircle" class="w-5 h-5 text-raosc-green" />
                        {{ editingCategory ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}
                    </h3>
                    
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Nom de la catégorie</label>
                            <input 
                                v-model="form.name" 
                                type="text" 
                                required 
                                placeholder="ex: Santé, Education..."
                                class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            >
                            <span v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Description</label>
                            <textarea 
                                v-model="form.description" 
                                rows="3" 
                                required 
                                placeholder="Brève description de ce secteur d'activité..."
                                class="w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            ></textarea>
                            <span v-if="form.errors.description" class="text-xs text-red-500 mt-1">{{ form.errors.description }}</span>
                        </div>

                        <div class="flex gap-3">
                            <button 
                                v-if="editingCategory"
                                @click="cancelEdit"
                                type="button"
                                class="flex-1 border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                            >
                                Annuler
                            </button>
                            <button 
                                type="submit" 
                                :disabled="form.processing" 
                                class="flex-[2] bg-raosc-green text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-raosc-green/90 transition-colors shadow-sm shadow-raosc-green/20"
                            >
                                {{ editingCategory ? 'Mettre à jour' : 'Enregistrer' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste des catégories -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-zinc-50/50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400">
                                    <tr>
                                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[10px]">Nom de la catégorie</th>
                                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[10px] hidden md:table-cell">Description</th>
                                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[10px] text-center">OSC</th>
                                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[10px] text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories" :key="category.id" class="border-b border-zinc-100 dark:border-zinc-800 last:border-0 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors group">
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-zinc-900 dark:text-white group-hover:text-raosc-green transition-colors">{{ category.name }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400 hidden md:table-cell max-w-xs truncate">
                                            {{ category.description }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-full text-[10px] font-black text-zinc-600 dark:text-zinc-300">
                                                {{ category.organizations_count || 0 }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button 
                                                    @click="startEdit(category)"
                                                    class="text-zinc-400 hover:text-raosc-green hover:bg-raosc-green/10 p-2.5 rounded-xl transition-all"
                                                    title="Modifier"
                                                >
                                                    <Edit2 class="w-4 h-4" />
                                                </button>
                                                <button 
                                                    @click="deleteCategory(category.id)"
                                                    class="text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 p-2.5 rounded-xl transition-all"
                                                    title="Supprimer"
                                                >
                                                    <Trash2 class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="categories.length === 0">
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="h-16 w-16 bg-zinc-50 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <FileText class="w-8 h-8 text-zinc-300" />
                                            </div>
                                            <p class="text-zinc-500 font-medium">Aucune catégorie n'a été créée pour le moment.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
