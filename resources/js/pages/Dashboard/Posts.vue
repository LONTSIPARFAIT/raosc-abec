<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusCircle, Newspaper, Trash2, ShieldAlert, Eye, X, Upload, Clock, Tag } from 'lucide-vue-next';
import { ref, reactive } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { store, destroy } from '@/actions/App/Http/Controllers/PostController';
import { show as showPost } from '@/actions/App/Http/Controllers/PostController';
import { marked } from 'marked';

interface Post {
    id: number;
    title: string;
    summary: string;
    category: string | null;
    slug: string;
    cover_image: string | null;
    read_time: number | null;
}

const {
    posts = [],
    organization = null,
    organizations = [],
    organizationId = null
} = defineProps<{
    posts?: Post[];
    organization?: any;
    organizations?: Organization[];
    organizationId?: number | null;
}>();

const isFormOpen = ref(false);
const coverPreview = ref<string | null>(null);
const isDeleting = ref<number | null>(null);

const postFormData = useForm({
    organization_id: organizationId || (organizations.length > 0 ? organizations[0].id : null),
    title: '',
    summary: '',
    content: '',
    category: '',
    cover_image: null as File | null,
});

const isPreviewMode = ref(false);
const contentTextarea = ref<HTMLTextAreaElement | null>(null);

const insertMarkdown = (tag: string, placeholder = '') => {
    if (!contentTextarea.value) return;
    const start = contentTextarea.value.selectionStart;
    const end = contentTextarea.value.selectionEnd;
    const text = postFormData.content;
    const before = text.substring(0, start);
    const selection = text.substring(start, end) || placeholder;
    const after = text.substring(end);

    let newText = '';
    switch (tag) {
        case 'bold': newText = `${before}**${selection}**${after}`; break;
        case 'italic': newText = `${before}*${selection}*${after}`; break;
        case 'link': newText = `${before}[${selection}](https://...)${after}`; break;
        case 'h1': newText = `${before}\n# ${selection}\n${after}`; break;
        case 'h2': newText = `${before}\n## ${selection}\n${after}`; break;
        case 'h3': newText = `${before}\n### ${selection}\n${after}`; break;
        case 'list': newText = `${before}\n- ${selection}\n${after}`; break;
        case 'quote': newText = `${before}\n> ${selection}\n${after}`; break;
        case 'code': newText = `${before}\n\`\`\`javascript\n${selection}\n\`\`\`\n${after}`; break;
    }
    
    postFormData.content = newText;
    
    // Focus back and set cursor
    setTimeout(() => {
        if (contentTextarea.value) {
            contentTextarea.value.focus();
            const offset = (tag === 'bold' || tag === 'italic') ? (tag === 'bold' ? 2 : 1) : 0;
            const newPos = start + offset;
            contentTextarea.value.setSelectionRange(newPos, newPos + selection.length + offset);
        }
    }, 50);
};

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
            <div v-if="organizations.length === 0"
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
                            <div v-if="organizations.length > 1" class="flex items-center gap-3 mt-4">
                                <span class="text-xs font-bold text-zinc-500">Filtrer par organisation :</span>
                                <select 
                                    :value="organizationId" 
                                    @change="(e: any) => $inertia.visit(`?organization_id=${e.target.value}`, { preserveScroll: true })"
                                    class="text-xs font-bold bg-zinc-100 dark:bg-zinc-800 border-none rounded-xl px-3 py-1.5 focus:ring-raosc-green"
                                >
                                    <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                </select>
                            </div>
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

                        <form 
                            @submit.prevent="postFormData.post(store().url, { 
                                onSuccess: () => { coverPreview = null; isFormOpen = false; postFormData.reset(); },
                                preserveScroll: true
                            })"
                            class="space-y-6"
                        >
                            <div v-if="Object.keys(postFormData.errors).length > 0" class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-2xl mb-6">
                                <div class="flex items-center gap-2 text-raosc-red font-bold text-sm mb-1">
                                    <ShieldAlert class="w-4 h-4" />
                                    Erreurs de validation
                                </div>
                                <ul class="text-xs text-raosc-red/80 space-y-1 ml-6 list-disc">
                                    <li v-for="(error, field) in postFormData.errors" :key="field">{{ error }}</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div v-if="organizations.length > 1" class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Organisation auteur <span class="text-raosc-red">*</span>
                                    </label>
                                    <select v-model="postFormData.organization_id" required
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300 cursor-pointer">
                                        <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                    </select>
                                </div>
                                <!-- Titre -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Titre de l'article <span class="text-raosc-red">*</span>
                                    </label>
                                    <input v-model="postFormData.title" type="text" required 
                                        placeholder="Un titre accrocheur qui capte l'attention..."
                                        class="w-full h-12 px-5 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': postFormData.errors.title }" />
                                    <Transition name="slide-down">
                                        <div v-if="postFormData.errors.title" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.title }}</div>
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
                                        <div v-if="postFormData.errors.category" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.category }}</div>
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
                                        <div v-if="postFormData.errors.cover_image" class="text-raosc-red text-xs mt-1">{{ postFormData.errors.cover_image }}</div>
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
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': postFormData.errors.summary }"></textarea>
                                    <Transition name="slide-down">
                                        <div v-if="postFormData.errors.summary" class="text-raosc-red text-xs mt-1">{{ postFormData.errors.summary }}</div>
                                    </Transition>
                                </div>

                                <div class="lg:col-span-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                            Contenu complet (Markdown) <span class="text-raosc-red">*</span>
                                        </label>
                                        <div class="flex items-center p-1 bg-zinc-100 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                            <button 
                                                type="button" 
                                                @click="isPreviewMode = false" 
                                                class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-300"
                                                :class="!isPreviewMode ? 'bg-white dark:bg-zinc-700 text-raosc-green shadow-sm shadow-raosc-green/20' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                                            >
                                                Éditeur
                                            </button>
                                            <button 
                                                type="button" 
                                                @click="isPreviewMode = true" 
                                                class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-300 flex items-center gap-2"
                                                :class="isPreviewMode ? 'bg-raosc-green text-white shadow-lg shadow-raosc-green/30' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                                            >
                                                <Eye class="w-3 h-3" /> Aperçu Premium
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Barre d'outils Markdown -->
                                    <div v-if="!isPreviewMode" class="flex flex-wrap items-center gap-1 mb-2 bg-white/50 dark:bg-zinc-900/50 p-2 rounded-xl border border-zinc-200 dark:border-zinc-700 backdrop-blur-sm">
                                        <div class="flex items-center gap-1 pr-2 mr-2 border-r border-zinc-200 dark:border-zinc-700">
                                            <button type="button" @click="insertMarkdown('bold', 'texte gras')" title="Gras" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-sm font-bold">B</button>
                                            <button type="button" @click="insertMarkdown('italic', 'texte italique')" title="Italique" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-sm italic font-serif">I</button>
                                        </div>
                                        <div class="flex items-center gap-1 pr-2 mr-2 border-r border-zinc-200 dark:border-zinc-700">
                                            <button type="button" @click="insertMarkdown('h1', 'Titre Principal')" title="Titre 1" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-xs font-black">H1</button>
                                            <button type="button" @click="insertMarkdown('h2', 'Sous-titre')" title="Titre 2" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-xs font-extrabold">H2</button>
                                            <button type="button" @click="insertMarkdown('h3', 'Section')" title="Titre 3" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-xs font-bold">H3</button>
                                        </div>
                                        <div class="flex items-center gap-1 pr-2 mr-2 border-r border-zinc-200 dark:border-zinc-700">
                                            <button type="button" @click="insertMarkdown('list', 'élément')" title="Liste" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-sm">List</button>
                                            <button type="button" @click="insertMarkdown('quote', 'citation')" title="Citation" class="h-8 w-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-sm">"</button>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button type="button" @click="insertMarkdown('link', 'nom du lien')" title="Insérer un lien" class="px-3 h-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-xs font-bold text-raosc-green">Lien</button>
                                            <button type="button" @click="insertMarkdown('code', 'console.log()')" title="Code" class="px-3 h-8 flex items-center justify-center hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-xs font-mono bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 border">Code</button>
                                        </div>
                                    </div>

                                    <div v-if="isPreviewMode" class="w-full px-8 py-10 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900/50 min-h-[350px] overflow-auto prose dark:prose-invert max-w-none shadow-inner
                                        prose-headings:text-raosc-green prose-a:text-raosc-green prose-blockquote:border-raosc-green prose-img:rounded-3xl">
                                        <div v-if="postFormData.content" v-html="marked.parse(postFormData.content)"></div>
                                        <div v-else class="flex flex-col items-center justify-center h-48 text-zinc-400 italic">
                                            <Eye class="w-8 h-8 mb-2 opacity-20" />
                                            Votre contenu formaté apparaîtra ici...
                                        </div>
                                    </div>
                                    <textarea v-else ref="contentTextarea" v-model="postFormData.content" required rows="12"
                                        placeholder="Rédigez votre article ici... (Markdown supporté)"
                                        class="w-full px-5 py-3 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm leading-relaxed transition-all duration-300 font-mono"
                                        :class="{ 'border-raosc-red focus:ring-raosc-red/20': postFormData.errors.content }"></textarea>
                                    <Transition name="slide-down">
                                        <div v-if="postFormData.errors.content" class="text-raosc-red text-xs mt-1">{{ postFormData.errors.content }}</div>
                                    </Transition>
                                </div>
                            </div>

                            <div class="flex gap-3 justify-end pt-6 border-t-2 border-zinc-200 dark:border-zinc-800">
                                <button type="button" @click="isFormOpen = false"
                                    class="px-6 py-2.5 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-2xl text-sm font-semibold transition-all duration-300 hover:scale-105">
                                    Annuler
                                </button>
                                <button type="submit" :disabled="postFormData.processing"
                                    class="group flex items-center gap-2 px-8 py-2.5 bg-raosc-green text-white font-bold rounded-2xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300 disabled:opacity-60 disabled:hover:scale-100">
                                    <PlusCircle v-if="!postFormData.processing" class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                                    <span>{{ postFormData.processing ? 'Publication en cours...' : 'Publier l\'article' }}</span>
                                </button>
                            </div>
                        </form>
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