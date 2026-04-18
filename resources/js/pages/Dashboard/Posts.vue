<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusCircle, Newspaper, Trash2, ShieldAlert, Eye, X, Upload, Clock, Tag, Bold, Italic, Link as LinkIcon, List, Quote, Code, Heading1, Heading2, Heading3 } from 'lucide-vue-next';
import { ref } from 'vue';
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

interface Organization {
    id: number;
    name: string;
    slug: string;
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

const insertMarkdown = (prefix: string, suffix: string = '', placeholder: string = '') => {
    if (!contentTextarea.value) return;
    const start = contentTextarea.value.selectionStart;
    const end = contentTextarea.value.selectionEnd;
    const text = postFormData.content;
    const selectedText = text.substring(start, end) || placeholder;
    
    const newText = text.substring(0, start) + prefix + selectedText + suffix + text.substring(end);
    postFormData.content = newText;
    
    setTimeout(() => {
        if (contentTextarea.value) {
            contentTextarea.value.focus();
            const newCursorPos = start + prefix.length;
            contentTextarea.value.setSelectionRange(newCursorPos, newCursorPos + selectedText.length);
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

const removeCoverImage = () => {
    postFormData.cover_image = null;
    if (coverPreview.value) {
        URL.revokeObjectURL(coverPreview.value);
        coverPreview.value = null;
    }
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

const resetForm = () => {
    isFormOpen.value = false;
    removeCoverImage();
    postFormData.reset();
    isPreviewMode.value = false;
};

const categories = ['Solidarité', 'Éducation', 'Santé', 'Environnement', 'Emploi', 'Droits', 'Gouvernance', 'Autre'];
</script>

<template>
    <AppLayout>
        <Head title="Gestion des Actualités" />

        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 p-4 sm:p-6 lg:p-10">
            
            <!-- Effets de fond subtils -->
            <div class="fixed inset-0 pointer-events-none opacity-20 dark:opacity-5">
                <div class="absolute top-20 -left-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-green)"></div>
                <div class="absolute bottom-20 -right-20 w-96 h-96 rounded-full blur-[120px]" style="background-color: var(--raosc-yellow)"></div>
            </div>

            <!-- Pas d'organisation -->
            <div v-if="organizations.length === 0" class="max-w-2xl mx-auto mt-10">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl sm:rounded-3xl p-8 sm:p-12 text-center shadow-xl border border-red-200 dark:border-red-800">
                    <div class="h-16 w-16 sm:h-20 sm:w-20 bg-red-50 dark:bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <ShieldAlert class="w-8 h-8 sm:w-10 sm:h-10 text-raosc-red" />
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white mb-3">Organisation requise</h2>
                    <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mb-8">Vous devez lier votre compte à une organisation avant de publier des actualités.</p>
                    <Link href="/rao/join"
                        class="inline-flex items-center gap-2 px-6 sm:px-8 py-2.5 sm:py-3 bg-raosc-green text-white font-bold rounded-xl sm:rounded-2xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300">
                        Inscrire mon organisation
                    </Link>
                </div>
            </div>

            <!-- Contenu principal -->
            <div v-else class="space-y-6 sm:space-y-8">
                <!-- En-tête -->
                <div class="sticky top-6 z-10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm border border-zinc-200 dark:border-zinc-800 rounded-2xl sm:rounded-3xl p-5 sm:p-8 shadow-lg">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="h-px w-6 sm:w-8 bg-raosc-green"></div>
                                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-raosc-green">Espace Média</p>
                            </div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-zinc-900 dark:text-white">Nos Actualités</h1>
                            <div v-if="organizations.length > 1" class="flex items-center gap-3 mt-2">
                                <span class="text-xs font-medium text-zinc-500">Filtrer :</span>
                                <select 
                                    :value="organizationId" 
                                    @change="(e: any) => $inertia.visit(`?organization_id=${e.target.value}`, { preserveScroll: true })"
                                    class="text-xs font-medium bg-zinc-100 dark:bg-zinc-800 border-0 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-raosc-green"
                                >
                                    <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                </select>
                            </div>
                        </div>
                        <button @click="isFormOpen = true"
                            class="group flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm hover:scale-105 hover:shadow-xl transition-all duration-300 w-full sm:w-auto justify-center">
                            <PlusCircle class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" /> 
                            Nouvel article
                        </button>
                    </div>
                </div>

                <!-- Formulaire -->
                <Transition name="slide-fade">
                    <div v-if="isFormOpen" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl sm:rounded-3xl p-5 sm:p-8 shadow-xl">
                        <div class="flex items-center justify-between mb-6 sm:mb-8">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white">Rédiger un article</h3>
                                <p class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1">Partagez votre histoire avec la communauté</p>
                            </div>
                            <button @click="resetForm"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all duration-300 hover:scale-110 hover:rotate-90">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form @submit.prevent="postFormData.post(store().url, { onSuccess: resetForm, preserveScroll: true })" class="space-y-6">
                            <!-- Erreurs -->
                            <div v-if="Object.keys(postFormData.errors).length > 0" class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl">
                                <div class="flex items-center gap-2 text-raosc-red font-semibold text-sm mb-2">
                                    <ShieldAlert class="w-4 h-4" />
                                    Veuillez corriger les erreurs
                                </div>
                                <ul class="text-xs text-raosc-red/80 space-y-1 ml-6 list-disc">
                                    <li v-for="(error, field) in postFormData.errors" :key="field">{{ error }}</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">
                                <!-- Organisation -->
                                <div v-if="organizations.length > 1" class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Organisation <span class="text-raosc-red">*</span>
                                    </label>
                                    <select v-model="postFormData.organization_id" required
                                        class="w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300">
                                        <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
                                    </select>
                                </div>

                                <!-- Titre -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Titre <span class="text-raosc-red">*</span>
                                    </label>
                                    <input v-model="postFormData.title" type="text" required 
                                        placeholder="Un titre accrocheur..."
                                        class="w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300"
                                        :class="{ 'border-raosc-red': postFormData.errors.title }" />
                                    <Transition name="slide-down">
                                        <p v-if="postFormData.errors.title" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.title }}</p>
                                    </Transition>
                                </div>

                                <!-- Catégorie -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        <Tag class="w-3.5 h-3.5 inline mr-1" /> Catégorie
                                    </label>
                                    <select v-model="postFormData.category"
                                        class="w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm transition-all duration-300">
                                        <option value="">-- Choisir --</option>
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                    <Transition name="slide-down">
                                        <p v-if="postFormData.errors.category" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.category }}</p>
                                    </Transition>
                                </div>

                                <!-- Image -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        <Upload class="w-3.5 h-3.5 inline mr-1" /> Image de couverture
                                    </label>
                                    <div class="relative">
                                        <label v-if="!coverPreview"
                                            class="flex items-center gap-3 w-full h-11 sm:h-12 px-4 sm:px-5 rounded-xl border-2 border-dashed border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-500 text-sm cursor-pointer hover:border-raosc-green hover:text-raosc-green transition-all duration-300">
                                            <Newspaper class="w-4 h-4 shrink-0" />
                                            <span class="truncate">Choisir une image...</span>
                                            <input type="file" accept="image/*" @change="handleFile" class="hidden" />
                                        </label>
                                        <div v-else class="relative inline-block">
                                            <img :src="coverPreview" class="h-24 w-full object-cover rounded-xl border border-zinc-200 dark:border-zinc-700" />
                                            <button type="button" @click="removeCoverImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                                <X class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                    <Transition name="slide-down">
                                        <p v-if="postFormData.errors.cover_image" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.cover_image }}</p>
                                    </Transition>
                                </div>

                                <!-- Résumé -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                                        Résumé <span class="text-raosc-red">*</span>
                                    </label>
                                    <textarea v-model="postFormData.summary" required rows="3"
                                        placeholder="Un résumé court et percutant..."
                                        class="w-full px-4 sm:px-5 py-3 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm resize-none transition-all duration-300"
                                        :class="{ 'border-raosc-red': postFormData.errors.summary }"></textarea>
                                    <Transition name="slide-down">
                                        <p v-if="postFormData.errors.summary" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.summary }}</p>
                                    </Transition>
                                </div>

                                <!-- Contenu -->
                                <div class="lg:col-span-2">
                                    <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                            Contenu <span class="text-raosc-red">*</span>
                                        </label>
                                        <div class="flex gap-2">
                                            <button type="button" @click="isPreviewMode = false" 
                                                :class="['px-3 py-1.5 rounded-lg text-xs font-semibold transition-all', !isPreviewMode ? 'bg-raosc-green text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400']">
                                                Écrire
                                            </button>
                                            <button type="button" @click="isPreviewMode = true" 
                                                :class="['px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1', isPreviewMode ? 'bg-raosc-green text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400']">
                                                <Eye class="w-3 h-3" /> Aperçu
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Barre d'outils -->
                                    <div v-if="!isPreviewMode" class="flex flex-wrap gap-1 mb-3 p-2 bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                        <button type="button" @click="insertMarkdown('**', '**', 'texte')" title="Gras" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Bold class="w-3.5 h-3.5" /></button>
                                        <button type="button" @click="insertMarkdown('*', '*', 'texte')" title="Italique" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Italic class="w-3.5 h-3.5" /></button>
                                        <div class="w-px h-6 bg-zinc-300 dark:bg-zinc-600 mx-1"></div>
                                        <button type="button" @click="insertMarkdown('# ', '', 'Titre')" title="Titre 1" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Heading1 class="w-3.5 h-3.5" /></button>
                                        <button type="button" @click="insertMarkdown('## ', '', 'Sous-titre')" title="Titre 2" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Heading2 class="w-3.5 h-3.5" /></button>
                                        <button type="button" @click="insertMarkdown('### ', '', 'Section')" title="Titre 3" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Heading3 class="w-3.5 h-3.5" /></button>
                                        <div class="w-px h-6 bg-zinc-300 dark:bg-zinc-600 mx-1"></div>
                                        <button type="button" @click="insertMarkdown('- ', '', 'Élément')" title="Liste" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><List class="w-3.5 h-3.5" /></button>
                                        <button type="button" @click="insertMarkdown('> ', '', 'citation')" title="Citation" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Quote class="w-3.5 h-3.5" /></button>
                                        <button type="button" @click="insertMarkdown('[', '](https://)', 'lien')" title="Lien" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><LinkIcon class="w-3.5 h-3.5" /></button>
                                        <button type="button" @click="insertMarkdown('```\n', '\n```', 'code')" title="Code" class="h-8 w-8 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"><Code class="w-3.5 h-3.5" /></button>
                                    </div>

                                    <div v-if="isPreviewMode" class="min-h-[400px] p-5 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-auto prose dark:prose-invert max-w-none">
                                        <div v-if="postFormData.content" v-html="marked.parse(postFormData.content)"></div>
                                        <div v-else class="text-center text-zinc-400 italic py-20">Aperçu du contenu...</div>
                                    </div>
                                    <textarea v-else ref="contentTextarea" v-model="postFormData.content" required rows="12"
                                        placeholder="Rédigez votre article en Markdown..."
                                        class="w-full px-4 sm:px-5 py-3 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-raosc-green focus:ring-4 focus:ring-raosc-green/20 outline-none text-sm font-mono transition-all duration-300"
                                        :class="{ 'border-raosc-red': postFormData.errors.content }"></textarea>
                                    <Transition name="slide-down">
                                        <p v-if="postFormData.errors.content" class="text-raosc-red text-xs mt-2">{{ postFormData.errors.content }}</p>
                                    </Transition>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                <button type="button" @click="resetForm"
                                    class="px-5 sm:px-6 py-2 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl text-sm font-semibold transition-all duration-300 order-2 sm:order-1">
                                    Annuler
                                </button>
                                <button type="submit" :disabled="postFormData.processing"
                                    class="group flex items-center justify-center gap-2 px-6 sm:px-8 py-2 bg-raosc-green text-white font-bold rounded-xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300 disabled:opacity-60 order-1 sm:order-2">
                                    <PlusCircle v-if="!postFormData.processing" class="w-4 h-4" />
                                    <span>{{ postFormData.processing ? 'Publication...' : 'Publier' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>

                <!-- Liste des articles -->
                <div v-if="posts.length > 0" class="space-y-4">
                    <div v-for="post in posts" :key="post.id"
                        class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row gap-4 shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-[1.01]">
                        <div class="h-32 sm:h-24 w-full sm:w-32 rounded-xl overflow-hidden shrink-0 bg-zinc-100 dark:bg-zinc-800">
                            <img v-if="post.cover_image" :src="post.cover_image" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            <div v-else class="h-full w-full flex items-center justify-center">
                                <Newspaper class="w-8 h-8 text-zinc-400" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span v-if="post.category"
                                    class="px-2 py-0.5 bg-raosc-green/10 text-raosc-green text-[10px] font-bold uppercase tracking-wider rounded-full">
                                    {{ post.category }}
                                </span>
                                <span v-if="post.read_time" class="flex items-center gap-1 text-[10px] text-zinc-500">
                                    <Clock class="w-3 h-3" /> {{ post.read_time }} min
                                </span>
                            </div>
                            <h4 class="font-bold text-base sm:text-lg text-zinc-900 dark:text-white line-clamp-1 group-hover:text-raosc-green transition-colors">
                                {{ post.title }}
                            </h4>
                            <p class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mt-1">{{ post.summary }}</p>
                        </div>
                        <div class="flex flex-row sm:flex-col gap-2 shrink-0 justify-end">
                            <Link :href="showPost(post.slug).url"
                                class="h-9 w-9 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 hover:text-raosc-green hover:bg-raosc-green/10 transition-all duration-300 hover:scale-110">
                                <Eye class="w-4 h-4" />
                            </Link>
                            <button @click="deletePost(post.id)" :disabled="isDeleting === post.id"
                                class="h-9 w-9 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 hover:text-raosc-red hover:bg-red-50 dark:hover:bg-red-500/10 transition-all duration-300 hover:scale-110 disabled:opacity-50">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- État vide -->
                <div v-else class="text-center py-16 sm:py-20 bg-white dark:bg-zinc-900 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl sm:rounded-3xl">
                    <div class="h-16 w-16 sm:h-20 sm:w-20 bg-zinc-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <Newspaper class="w-8 h-8 sm:w-10 sm:h-10 text-zinc-400" />
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-zinc-900 dark:text-white mb-2">Aucun article</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 max-w-sm mx-auto mb-6">Publiez votre premier article pour partager vos actions</p>
                    <button @click="isFormOpen = true"
                        class="inline-flex items-center gap-2 px-6 sm:px-8 py-2.5 sm:py-3 bg-raosc-green text-white font-bold rounded-xl sm:rounded-2xl text-sm hover:scale-105 hover:shadow-lg transition-all duration-300">
                        <PlusCircle class="w-4 h-4" /> Rédiger un article
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Transitions */
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
</style>