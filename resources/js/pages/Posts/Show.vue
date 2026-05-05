<!-- ArticleShow.vue - Design Full Width avec colonnes structurées -->
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Clock, Building2, Calendar, Tag, Share2, Bookmark, Heart, Eye, ChevronRight, User, Mail, Phone, MapPin } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { marked } from 'marked';
import { ref, onMounted, onUnmounted } from 'vue';

defineProps<{
    post: {
        id: number;
        slug: string;
        title: string;
        summary: string;
        content: string;
        cover_image: string | null;
        category: string | null;
        read_time: number | null;
        created_at: string;
        organization: {
            name: string;
            slug: string;
            logo: string | null;
            description?: string;
            email?: string;
            phone?: string;
            address?: string;
            projects?: {
                id: number;
                title: string;
                type: string;
                cover_image: string | null;
            }[];
        } | null;
    };
}>();

const isBookmarked = ref(false);
const isLiked = ref(false);
const scrollProgress = ref(0);

const updateProgress = () => {
    const winScroll = document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    scrollProgress.value = (winScroll / height) * 100;
};

onMounted(() => {
    window.addEventListener('scroll', updateProgress);
});

onUnmounted(() => {
    window.removeEventListener('scroll', updateProgress);
});
</script>

<template>
    <PublicLayout>
        <Head :title="`${post.title} | RAOSC`" />

        <article class="bg-white dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- BARRE DE PROGRESSION FIXE EN HAUT -->
            <!-- ============================================ -->
            <div class="fixed top-0 left-0 right-0 h-1 bg-zinc-200 dark:bg-zinc-800 z-50">
                <div class="h-full bg-raosc-green transition-all duration-200" :style="{ width: scrollProgress + '%' }"></div>
            </div>

            <!-- ============================================ -->
            <!-- HERO SECTION FULL WIDTH -->
            <!-- ============================================ -->
            <div class="relative w-full min-h-[70vh] lg:min-h-[80vh] overflow-hidden">
                <!-- Image de fond -->
                <div v-if="post.cover_image" class="absolute inset-0">
                    <img :src="post.cover_image" :alt="post.title" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/20"></div>
                </div>
                <div v-else class="absolute inset-0 bg-gradient-to-br from-raosc-green via-raosc-green/80 to-raosc-yellow/40"></div>
                
                <!-- Contenu Hero - Structure en colonnes -->
                <div class="relative z-10 container mx-auto px-6 lg:px-12 py-20 lg:py-32 min-h-[70vh] lg:min-h-[80vh] flex flex-col justify-end">
                    <!-- Métadonnées en ligne -->
                    <div class="max-w-4xl">
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            <span v-if="post.category" class="px-4 py-1.5 bg-raosc-green text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-lg">
                                {{ post.category }}
                            </span>
                            <span class="flex items-center gap-1.5 text-white/80 text-sm">
                                <Clock class="w-4 h-4" /> {{ post.read_time || 3 }} min de lecture
                            </span>
                            <span class="flex items-center gap-1.5 text-white/80 text-sm">
                                <Calendar class="w-4 h-4" /> {{ new Date(post.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                            </span>
                        </div>
                        
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-[1.15] tracking-tight mb-8">
                            {{ post.title }}
                        </h1>
                    </div>
                    
                    <!-- Info auteur -->
                    <div class="flex flex-wrap items-center justify-between gap-6 pt-8 border-t border-white/20 max-w-4xl">
                        <Link v-if="post.organization" :href="`/rao/orga/${post.organization.slug}`" class="group flex items-center gap-4">
                            <div class="h-14 w-14 rounded-xl overflow-hidden bg-white/10 backdrop-blur-sm border-2 border-white/30">
                                <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-contain p-1" />
                                <Building2 v-else class="w-full h-full text-white/60 p-2" />
                            </div>
                            <div>
                                <p class="text-white/50 text-xs font-semibold uppercase tracking-wider">Publié par</p>
                                <p class="text-white font-bold text-lg group-hover:text-raosc-yellow transition-colors">
                                    {{ post.organization.name }}
                                </p>
                            </div>
                        </Link>
                        
                        <div class="flex items-center gap-3">
                            <button @click="isBookmarked = !isBookmarked" class="p-2.5 rounded-full bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all hover:scale-105">
                                <Bookmark :class="['w-5 h-5', isBookmarked ? 'text-raosc-yellow fill-raosc-yellow' : 'text-white']" />
                            </button>
                            <button @click="isLiked = !isLiked" class="p-2.5 rounded-full bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all hover:scale-105">
                                <Heart :class="['w-5 h-5', isLiked ? 'text-red-500 fill-red-500' : 'text-white']" />
                            </button>
                            <button class="p-2.5 rounded-full bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all hover:scale-105">
                                <Share2 class="w-5 h-5 text-white" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU PRINCIPAL - STRUCTURE EN COLONNES FULL WIDTH -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-12 lg:py-16">
                
                <!-- Navigation breadcrumb -->
                <div class="mb-12 pb-6 border-b border-zinc-200 dark:border-zinc-800">
                    <Link href="/posts" class="group inline-flex items-center gap-2 text-sm font-medium text-zinc-500 hover:text-raosc-green transition-colors">
                        <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" /> 
                        Retour aux actualités
                    </Link>
                </div>

                <!-- Layout en 2 colonnes : Contenu (70%) + Sidebar (30%) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                    
                    <!-- ======================================== -->
                    <!-- COLONNE PRINCIPALE - CONTENU (70%) -->
                    <!-- ======================================== -->
                    <div class="lg:col-span-8">
                        
                        <!-- Résumé mis en avant -->
                        <div v-if="post.summary" class="mb-12 p-8 bg-gradient-to-r from-raosc-green/5 to-transparent rounded-2xl border-l-4 border-raosc-green">
                            <p class="text-xl lg:text-2xl text-zinc-800 dark:text-zinc-200 font-semibold leading-relaxed">
                                « {{ post.summary }} »
                            </p>
                        </div>

                        <!-- Contenu principal -->
                        <div class="prose prose-lg dark:prose-invert max-w-none
                                    prose-headings:font-black prose-headings:tracking-tight
                                    prose-h1:text-4xl prose-h1:lg:text-5xl
                                    prose-h2:text-3xl prose-h2:lg:text-4xl prose-h2:mt-12 prose-h2:mb-6
                                    prose-h3:text-2xl prose-h3:mt-10 prose-h3:mb-4
                                    prose-p:text-zinc-600 dark:prose-p:text-zinc-400 prose-p:leading-relaxed prose-p:mb-6
                                    prose-a:text-raosc-green prose-a:no-underline prose-a:border-b-2 prose-a:border-raosc-green/30 prose-a:hover:border-raosc-green
                                    prose-strong:text-zinc-900 dark:prose-strong:text-white
                                    prose-ul:list-disc prose-ul:pl-6 prose-ul:space-y-2
                                    prose-ol:list-decimal prose-ol:pl-6 prose-ol:space-y-2
                                    prose-blockquote:border-l-4 prose-blockquote:border-raosc-green prose-blockquote:bg-zinc-50 dark:prose-blockquote:bg-zinc-800/50 
                                    prose-blockquote:p-6 prose-blockquote:rounded-r-2xl prose-blockquote:italic
                                    prose-img:rounded-2xl prose-img:shadow-lg prose-img:my-8
                                    prose-code:bg-zinc-100 dark:prose-code:bg-zinc-800 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded
                                    prose-pre:bg-zinc-900 prose-pre:text-zinc-100 prose-pre:rounded-xl prose-pre:p-6">
                            <div v-html="marked.parse(post.content)"></div>
                        </div>

                        <!-- Tags -->
                        <div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-800">
                            <div class="flex flex-wrap items-center gap-3">
                                <Tag class="w-4 h-4 text-zinc-400" />
                                <span class="text-sm text-zinc-500 font-medium">Tags :</span>
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="tag in [post.category, 'Développement', 'Afrique'].filter(Boolean)" :key="tag"
                                          class="px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 text-xs rounded-lg hover:bg-raosc-green/10 hover:text-raosc-green transition-colors cursor-pointer">
                                        #{{ tag }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE LATÉRALE - SIDEBAR (30%) -->
                    <!-- ======================================== -->
                    <div class="lg:col-span-4 space-y-8">
                        
                        <!-- Carte Auteur / Organisation -->
                        <div v-if="post.organization" class="bg-zinc-50 dark:bg-zinc-900 rounded-2xl p-6 border border-zinc-200 dark:border-zinc-800">
                            <div class="text-center mb-6">
                                <div class="h-24 w-24 mx-auto rounded-2xl overflow-hidden bg-white dark:bg-zinc-800 shadow-lg mb-4">
                                    <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-contain p-2" />
                                    <Building2 v-else class="w-full h-full text-zinc-400 p-4" />
                                </div>
                                <h4 class="text-xl font-black text-zinc-900 dark:text-white">{{ post.organization.name }}</h4>
                                <p class="text-xs text-raosc-green font-semibold mt-1">Membre RAOSC</p>
                            </div>
                            
                            <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed mb-6 text-center">
                                {{ post.organization.description || "Organisation membre de la coalition RAOSC, engagée dans le développement social en Afrique." }}
                            </p>
                            
                            <Link :href="`/rao/orga/${post.organization.slug}`" 
                                  class="inline-flex w-full items-center justify-center gap-2 bg-raosc-green text-white font-bold py-3 rounded-xl hover:bg-raosc-green/90 transition-all hover:scale-[1.02]">
                                Voir le profil
                                <ChevronRight class="w-4 h-4" />
                            </Link>
                        </div>

                        <!-- Statistiques de l'article -->
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl p-6 border border-zinc-200 dark:border-zinc-800">
                            <h5 class="text-sm font-bold text-zinc-400 uppercase tracking-wider mb-4">Statistiques</h5>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-zinc-600 dark:text-zinc-400">
                                        <Eye class="w-4 h-4" />
                                        <span class="text-sm">Vues</span>
                                    </div>
                                    <span class="font-bold text-zinc-900 dark:text-white">1,234</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-zinc-600 dark:text-zinc-400">
                                        <Heart class="w-4 h-4" />
                                        <span class="text-sm">Likes</span>
                                    </div>
                                    <span class="font-bold text-zinc-900 dark:text-white">89</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-zinc-600 dark:text-zinc-400">
                                        <Bookmark class="w-4 h-4" />
                                        <span class="text-sm">Sauvegardes</span>
                                    </div>
                                    <span class="font-bold text-zinc-900 dark:text-white">45</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION PROJETS CONNEXES - FULL WIDTH -->
                <!-- ============================================ -->
                <div v-if="post.organization?.projects?.length" class="mt-20 pt-12 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-12">
                        <div>
                            <span class="text-raosc-green text-sm font-bold uppercase tracking-wider">Projets connexes</span>
                            <h3 class="text-3xl lg:text-4xl font-black text-zinc-900 dark:text-white mt-2">
                                À découvrir chez <span class="text-raosc-green">{{ post.organization.name }}</span>
                            </h3>
                        </div>
                        <Link :href="`/rao/orga/${post.organization.slug}`" 
                              class="inline-flex items-center gap-2 px-6 py-3 bg-raosc-green text-white font-bold rounded-xl hover:bg-raosc-green/90 transition-all hover:scale-105">
                            Voir tous les projets
                            <ChevronRight class="w-4 h-4" />
                        </Link>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <Link v-for="project in post.organization.projects.slice(0, 3)" 
                              :key="project.id" 
                              :href="`/rao/orga/${post.organization.slug}`" 
                              class="group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-zinc-200 dark:border-zinc-800">
                            
                            <div class="h-52 overflow-hidden relative bg-zinc-100 dark:bg-zinc-800">
                                <img v-if="project.cover_image" 
                                     :src="project.cover_image" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                                <Building2 v-else class="w-full h-full p-12 text-zinc-300 dark:text-zinc-700" />
                                
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-sm rounded-lg text-[11px] font-black uppercase tracking-wider text-raosc-green">
                                        {{ project.type }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 group-hover:text-raosc-green transition-colors">
                                    {{ project.title }}
                                </h4>
                                <div class="flex items-center gap-2 text-raosc-green font-semibold text-sm group-hover:gap-3 transition-all">
                                    Découvrir 
                                    <ChevronRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

            </div>

        </article>
    </PublicLayout>
</template>