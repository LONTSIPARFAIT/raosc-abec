<script setup lang="ts">
import { Head, Link, useForm, Form } from '@inertiajs/vue3';
import { PlusCircle, Newspaper, Trash2, ShieldAlert, Eye, X, Upload, Clock, Tag } from 'lucide-vue-next';
import { ref, reactive } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { store, destroy } from '@/actions/App/Http/Controllers/PostController';
import { show as showPost } from '@/actions/App/Http/Controllers/PostController';

interface Post {
    id: number;
    title: string;
    summary: string;
    category: string | null;
    slug: string;
    cover_image: string | null;
    read_time: number | null;
}

interface Organization {
    id: number;
    name: string;
    slug: string;
}

const {
    posts = [],
    organization = null
} = defineProps<{
    posts?: Post[];
    organization?: Organization | null;
}>();

const isFormOpen = ref(false);
const coverPreview = ref<string | null>(null);
const isDeleting = ref<number | null>(null);

const postFormData = reactive({
    title: '',
    summary: '',
    content: '',
    category: '',
    cover_image: null as File | null,
});

const handleFile = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (!file) return;
    postFormData.cover_image = file;
    const reader = new FileReader();
    reader.onload = (ev) => { coverPreview.value = ev.target?.result as string; };
    reader.readAsDataURL(file);
};

const deletePost = (id: number) => {
    if (confirm('Supprimer cet article définitivement ?')) {
        isDeleting.value = id;
        useForm({}).delete(destroy(id).url, { 
            preserveScroll: true,
            onFinish: () => { isDeleting.value = null; }
        });
    }
};

const categories = ['Solidarité', 'Éducation', 'Santé', 'Environnement', 'Emploi', 'Droits', 'Gouvernance', 'Autre'];
</script>

<template>
    <AppLayout>
        <Head title="Gestion des Actualités" />

        <div class="p-6 lg:p-10 bg-zinc-50 dark:bg-zinc-950 min-h-screen">

            <!-- Alerte: pas d'organisation avec glassmorphism -->
            <div v-if="!organization"
                class="max-w-2xl mx-auto mt-10 backdrop-blur-lg bg-white/90 dark:bg-zinc-900/90 border border-red-200/50 dark:border-red-800/50 rounded-3xl p-12 text-center shadow-xl animate-fade-in">
                <div class="animate-pulse">
                    <div class="h-20 w-20 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-500/20 dark:to-red-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <ShieldAlert class="w-10 h-10 text-raosc-red" />
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">Organisation requise</h2>
                <p class="text-zinc-600 dark:text-zinc-400 mb-8">Vous devez lier votre compte à une organisation avant de publier des actualités.</p>
                <Link href="/rao/join"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-raosc-green text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300">
                    Inscrire mon organisation
                </Link>
            </div>

            <!-- Contenu principal (quand organisation existe) -->
            <div v-else class="space-y-8">
                <!-- En-tête avec glassmorphism -->
                <div
                    class="sticky top-6 z-10 backdrop-blur-md bg-white/80 dark:bg-zinc-900/80 border border-zinc-200/50 dark:border-zinc-800/50 rounded-3xl p-8 shadow-lg transition-all duration-300 hover:shadow-xl">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="h-px w-8 bg-raosc-green"></div>
                                <p class="text-xs font-bold uppercase tracking-wider text-raosc-green">Espace Média</p>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-black text-zinc-900 dark:text-white">Nos Actualités</h1>
                            <p class="text-zinc-600 dark:text-zinc-400">Partagez les actions de votre organisation avec la communauté.</p>
                        </div>
                        <button @click="isFormOpen = true"
                            class="group flex items-center gap-2 px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-2xl font-bold text-sm hover:scale-105 hover:shadow-xl transition-all duration-300 shrink-0">
                            <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" /> 
                            Nouvel article
                        </button>
                    </div>
                </div>

                <!-- Formulaire de création avec glassmorphism -->
                <Transition name="slide-fade">
                    <div v-if="isFormOpen"
                        class="backdrop-blur-md bg-white/95 dark:bg-zinc-900/95 border border-zinc-200/50 dark:border-zinc-800/50 rounded-3xl p-8 shadow-xl">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Rédiger un article</h3>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Partagez votre histoire avec la communauté</p>
                            </div>
                            <button @click="isFormOpen = false"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all duration-300 hover:scale-110 hover:rotate-90">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <Form :action="store()" :data="postFormData" v-slot="{ errors, processing }" preserve-scroll
                            @success="() => { coverPreview = null; isFormOpen = false; postFormData.title = ''; postFormData.summary = ''; postFormData.content = ''; postFormData.category = ''; postFormData.cover_image = null; }" class="space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Titre -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Titre de l'article <span class="text-raosc-red">*</span>
                                    </label>
                                    <input v-model="postFormData.title" type="text" required 
                                        placeholder="Un titre accrocheur qui capte l'attention..."
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': errors.title }" />
                                    <Transition name="slide-down">
                                        <p v-if="errors.title" class="text-raosc-red text-xs mt-2">{{ errors.title }}</p>
                                    </Transition>
                                </div>

                                <!-- Catégorie -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        <Tag class="w-3 h-3 inline mr-1" /> Catégorie
                                    </label>
                                    <select v-model="postFormData.category"
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300 cursor-pointer">
                                        <option value="">-- Choisir une catégorie --</option>
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                    <Transition name="slide-down">
                                        <p v-if="errors.category" class="text-raosc-red text-xs mt-2">{{ errors.category }}</p>
                                    </Transition>
                                </div>

                                <!-- Image de couverture -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        <Upload class="w-3 h-3 inline mr-1" /> Image de couverture
                                    </label>
                                    <div class="relative">
                                        <label
                                            class="flex items-center gap-3 w-full h-12 px-5 rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-600 bg-white/50 dark:bg-zinc-800/50 text-zinc-500 text-sm cursor-pointer hover:border-raosc-green hover:text-raosc-green transition-all duration-300 hover:scale-[1.02]">
                                            <Newspaper class="w-4 h-4 shrink-0" />
                                            <span class="truncate">{{ postFormData.cover_image ? postFormData.cover_image.name : 'Choisir une image...' }}</span>
                                            <input type="file" accept="image/*" @change="(e) => handleFile(e)" class="hidden" />
                                        </label>
                                    </div>
                                    <Transition name="slide-down">
                                        <p v-if="errors.cover_image" class="text-raosc-red text-xs mt-2">{{ errors.cover_image }}</p>
                                    </Transition>
                                    <Transition name="fade">
                                        <div v-if="coverPreview" class="mt-3 h-28 w-full rounded-xl overflow-hidden border-2 border-zinc-200 dark:border-zinc-700 hover:scale-[1.02] transition-transform duration-300">
                                            <img :src="coverPreview" class="h-full w-full object-cover" />
                                        </div>
                                    </Transition>
                                </div>

                                <!-- Résumé -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Résumé <span class="text-raosc-red">*</span>
                                    </label>
                                    <textarea v-model="postFormData.summary" required rows="3"
                                        placeholder="Un résumé court et percutant qui donne envie de lire la suite..."
                                        class="w-full px-5 py-3 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm resize-none transition-all duration-300"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': errors.summary }"></textarea>
                                    <Transition name="slide-down">
                                        <p v-if="errors.summary" class="text-raosc-red text-xs mt-2">{{ errors.summary }}</p>
                                    </Transition>
                                </div>

                                <!-- Contenu -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Contenu complet <span class="text-raosc-red">*</span>
                                    </label>
                                    <textarea v-model="postFormData.content" required rows="12"
                                        placeholder="Rédigez votre article ici... (Markdown supporté)"
                                        class="w-full px-5 py-3 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm leading-relaxed transition-all duration-300 font-mono"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': errors.content }"></textarea>
                                    <Transition name="slide-down">
                                        <p v-if="errors.content" class="text-raosc-red text-xs mt-2">{{ errors.content }}</p>
                                    </Transition>
                                </div>
                            </div>

                            <div class="flex gap-3 justify-end pt-6 border-t-2 border-zinc-200 dark:border-zinc-800">
                                <button type="button" @click="isFormOpen = false"
                                    class="px-6 py-2.5 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-2xl text-sm font-semibold transition-all duration-300 hover:scale-105">
                                    Annuler
                                </button>
                                <button type="submit" :disabled="processing"
                                    class="group flex items-center gap-2 px-8 py-2.5 bg-raosc-green text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300 disabled:opacity-60 disabled:hover:scale-100">
                                    <PlusCircle v-if="!processing" class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                                    <span>{{ processing ? 'Publication en cours...' : 'Publier l\'article' }}</span>
                                </button>
                            </div>
                        </Form>
                    </div>
                </Transition>

                <!-- Liste des articles -->
                <TransitionGroup name="list" tag="div" class="space-y-4">
                    <div v-for="post in posts" :key="post.id"
                        class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 flex gap-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-[1.01]">
                        <div class="h-24 w-32 rounded-xl overflow-hidden shrink-0 bg-zinc-100 dark:bg-zinc-800">
                            <img v-if="post.cover_image" :src="post.cover_image" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            <div v-else class="h-full w-full flex items-center justify-center">
                                <Newspaper class="w-8 h-8 text-zinc-400" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2 flex-wrap">
                                <span v-if="post.category"
                                    class="px-3 py-1 bg-raosc-green/10 text-raosc-green text-xs font-bold uppercase tracking-wider rounded-full">
                                    {{ post.category }}
                                </span>
                                <span v-if="post.read_time" class="flex items-center gap-1 text-xs text-zinc-500">
                                    <Clock class="w-3 h-3" /> {{ post.read_time }} min de lecture
                                </span>
                            </div>
                            <h4 class="font-bold text-lg text-zinc-900 dark:text-white line-clamp-1 group-hover:text-raosc-green transition-colors duration-300">
                                {{ post.title }}
                            </h4>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mt-1">{{ post.summary }}</p>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <Link :href="showPost(post.slug).url"
                                class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 hover:text-raosc-green hover:bg-raosc-green/10 transition-all duration-300 hover:scale-110">
                                <Eye class="w-4 h-4" />
                            </Link>
                            <button @click="deletePost(post.id)" :disabled="isDeleting === post.id"
                                class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 hover:text-raosc-red hover:bg-red-50 dark:hover:bg-red-500/10 transition-all duration-300 hover:scale-110 disabled:opacity-50">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </TransitionGroup>

                <!-- État vide amélioré -->
                <Transition name="fade">
                    <div v-if="posts.length === 0"
                        class="text-center py-20 bg-white dark:bg-zinc-900 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-3xl hover:border-raosc-green/50 transition-all duration-300">
                        <div class="h-20 w-20 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <Newspaper class="w-10 h-10 text-zinc-400" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">Aucun article publié</h3>
                        <p class="text-zinc-600 dark:text-zinc-400 max-w-sm mx-auto mb-8">Partagez les actions de votre organisation avec la communauté RAOSC en publiant votre premier article.</p>
                        <button @click="isFormOpen = true"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-raosc-green text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300">
                            <PlusCircle class="w-4 h-4" /> Rédiger mon premier article
                        </button>
                    </div>
                </Transition>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Transitions fluides */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-fade-enter-from {
    transform: translateY(-20px);
    opacity: 0;
}

.slide-fade-leave-to {
    transform: translateY(10px);
    opacity: 0;
}

.slide-down-enter-active {
    transition: all 0.2s ease-out;
}

.slide-down-leave-active {
    transition: all 0.15s ease-in;
}

.slide-down-enter-from {
    transform: translateY(-10px);
    opacity: 0;
}

.slide-down-leave-to {
    transform: translateY(-5px);
    opacity: 0;
}

.list-enter-active,
.list-leave-active {
    transition: all 0.3s ease;
}

.list-enter-from {
    opacity: 0;
    transform: translateX(-20px);
}

.list-leave-to {
    opacity: 0;
    transform: translateX(20px);
}

.list-move {
    transition: transform 0.3s ease;
}

/* Animation d'entrée pour l'alerte */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}
</style>