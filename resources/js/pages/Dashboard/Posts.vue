<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusCircle, Newspaper, Trash2, ShieldAlert, Eye, X } from 'lucide-vue-next';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
    posts: any[];
    organization: any;
}>();

const isFormOpen = ref(false);
const coverPreview = ref<string | null>(null);

const form = useForm({
    title: '',
    summary: '',
    content: '',
    category: '',
    cover_image: null as File | null,
});

const handleFile = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (!file) return;
    form.cover_image = file;
    const reader = new FileReader();
    reader.onload = (ev) => { coverPreview.value = ev.target?.result as string; };
    reader.readAsDataURL(file);
};

const submit = () => {
    form.post('/dashboard/posts', {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            coverPreview.value = null;
            isFormOpen.value = false;
        },
    });
};

const deletePost = (id: number) => {
    if (confirm('Supprimer cet article définitivement ?')) {
        useForm({}).delete(`/dashboard/posts/${id}`, { preserveScroll: true });
    }
};

const categories = ['Solidarité', 'Éducation', 'Santé', 'Environnement', 'Emploi', 'Droits', 'Gouvernance', 'Autre'];
</script>

<template>
    <AppLayout>
        <Head title="Gestion des Actualités" />

        <div class="p-6 lg:p-10 bg-zinc-50 dark:bg-zinc-950 min-h-screen">

            <!-- Alerte: pas d'organisation -->
            <div v-if="!organization" class="max-w-2xl mx-auto mt-10 bg-white dark:bg-zinc-900 border border-red-200 dark:border-red-800 rounded-2xl p-10 text-center shadow-sm">
                <div class="h-16 w-16 bg-red-50 dark:bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-5 text-red-500">
                    <ShieldAlert class="w-8 h-8" />
                </div>
                <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Organisation requise</h2>
                <p class="text-zinc-500 mb-6 text-sm">Vous devez lier votre compte à une organisation avant de publier des actualités.</p>
                <Link href="/rao/join" class="inline-flex items-center gap-2 px-6 py-2.5 bg-raosc-green text-white font-bold rounded-full text-sm hover:bg-raosc-green/90 transition-colors">
                    Inscrire mon organisation
                </Link>
            </div>

            <div v-else>
                <!-- En-tête -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 mb-8 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-raosc-green mb-1">Espace Média</p>
                        <h1 class="text-2xl font-extrabold text-zinc-900 dark:text-white">Nos Actualités</h1>
                        <p class="text-sm text-zinc-500 mt-1">Partagez les actions de votre organisation avec la communauté.</p>
                    </div>
                    <button
                        @click="isFormOpen = true"
                        class="flex items-center gap-2 px-5 py-2.5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-full font-bold text-sm hover:opacity-90 transition-opacity shadow-md shrink-0"
                    >
                        <PlusCircle class="w-4 h-4" /> Nouvel article
                    </button>
                </div>

                <!-- Formulaire de création -->
                <div v-if="isFormOpen" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-8 mb-8 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Rédiger un article</h3>
                        <button @click="isFormOpen = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                    <form @submit.prevent="submit" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Titre -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Titre de l'article <span class="text-red-500">*</span></label>
                                <input v-model="form.title" type="text" required placeholder="Un titre accrocheur..." class="w-full h-11 px-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-raosc-green/30 focus:border-raosc-green outline-none text-sm transition-all" />
                                <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                            </div>

                            <!-- Catégorie -->
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Catégorie</label>
                                <select v-model="form.category" class="w-full h-11 px-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-raosc-green/30 focus:border-raosc-green outline-none text-sm">
                                    <option value="">-- Choisir --</option>
                                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                </select>
                            </div>

                            <!-- Image de couverture -->
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Image de couverture</label>
                                <div class="relative">
                                    <label class="flex items-center gap-3 w-full h-11 px-4 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-800 text-zinc-500 text-sm cursor-pointer hover:border-raosc-green hover:text-raosc-green transition-colors">
                                        <Newspaper class="w-4 h-4 shrink-0" />
                                        <span class="truncate">{{ form.cover_image ? form.cover_image.name : 'Choisir une image...' }}</span>
                                        <input type="file" accept="image/*" @change="handleFile" class="hidden" />
                                    </label>
                                </div>
                                <div v-if="coverPreview" class="mt-2 h-24 w-full rounded-lg overflow-hidden">
                                    <img :src="coverPreview" class="h-full w-full object-cover" />
                                </div>
                            </div>

                            <!-- Résumé -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Accroche / Résumé <span class="text-red-500">*</span></label>
                                <textarea v-model="form.summary" required rows="2" placeholder="Un résumé court et percutant (visible sur la liste des articles)..." class="w-full px-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-raosc-green/30 focus:border-raosc-green outline-none text-sm resize-none transition-all"></textarea>
                                <p v-if="form.errors.summary" class="text-red-500 text-xs mt-1">{{ form.errors.summary }}</p>
                            </div>

                            <!-- Contenu -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Contenu complet de l'article <span class="text-red-500">*</span></label>
                                <textarea v-model="form.content" required rows="10" placeholder="Rédigez votre article ici. Utilisez des sauts de ligne pour structurer vos paragraphes..." class="w-full px-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-raosc-green/30 focus:border-raosc-green outline-none text-sm leading-relaxed transition-all"></textarea>
                                <p v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</p>
                            </div>
                        </div>

                        <div class="flex gap-3 justify-end pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <button type="button" @click="isFormOpen = false" class="px-5 py-2.5 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full text-sm font-semibold transition-colors">
                                Annuler
                            </button>
                            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 px-6 py-2.5 bg-raosc-green text-white font-bold rounded-full text-sm hover:bg-raosc-green/90 transition-colors disabled:opacity-60 shadow-sm shadow-raosc-green/20">
                                <span v-if="form.processing">Publication en cours...</span>
                                <span v-else>Publier l'article</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste des articles -->
                <div v-if="posts.length > 0" class="space-y-4">
                    <div
                        v-for="post in posts"
                        :key="post.id"
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 flex gap-4 shadow-sm hover:shadow-md transition-shadow"
                    >
                        <div class="h-20 w-28 rounded-xl overflow-hidden shrink-0 bg-zinc-100 dark:bg-zinc-800">
                            <img v-if="post.cover_image" :src="post.cover_image" class="h-full w-full object-cover" />
                            <div v-else class="h-full w-full flex items-center justify-center">
                                <Newspaper class="w-6 h-6 text-zinc-300" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span v-if="post.category" class="px-2 py-0.5 bg-raosc-green/10 text-raosc-green text-[10px] font-bold uppercase tracking-wider rounded">
                                    {{ post.category }}
                                </span>
                                <span class="text-xs text-zinc-400">{{ post.read_time ? post.read_time + ' min' : '' }}</span>
                            </div>
                            <h4 class="font-bold text-zinc-900 dark:text-white text-sm line-clamp-1">{{ post.title }}</h4>
                            <p class="text-xs text-zinc-500 line-clamp-1 mt-0.5">{{ post.summary }}</p>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <Link :href="`/posts/${post.slug}`" class="h-8 w-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 hover:text-raosc-green hover:bg-raosc-green/10 transition-colors">
                                <Eye class="w-4 h-4" />
                            </Link>
                            <button @click="deletePost(post.id)" class="h-8 w-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- État vide -->
                <div v-else class="text-center py-20 bg-white dark:bg-zinc-900 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                    <div class="h-16 w-16 bg-zinc-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-5 text-zinc-400">
                        <Newspaper class="w-8 h-8" />
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Aucun article publié</h3>
                    <p class="text-zinc-500 text-sm max-w-sm mx-auto mb-6">Partagez les actions de votre organisation avec la communauté RAOSC en publiant votre premier article.</p>
                    <button @click="isFormOpen = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-raosc-green text-white font-bold rounded-full text-sm hover:bg-raosc-green/90 transition-colors">
                        <PlusCircle class="w-4 h-4" /> Rédiger mon premier article
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
