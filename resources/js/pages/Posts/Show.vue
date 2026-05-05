<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Clock, Building2, Calendar, Tag } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { marked } from 'marked';

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
            projects?: {
                id: number;
                title: string;
                type: string;
                cover_image: string | null;
            }[];
        } | null;
    };
}>();
</script>

<template>
    <PublicLayout>
        <Head :title="post.title + ' — RAOSC'" />

        <article class="bg-zinc-50 dark:bg-zinc-950 min-h-screen">

            <!-- Premium Hero Section -->
            <div v-if="post.cover_image" class="relative w-full h-[60vh] min-h-[500px] overflow-hidden">
                <img :src="post.cover_image" :alt="post.title" class="absolute inset-0 w-full h-full object-cover" />
                <!-- Overlay with gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent" />
                
                <!-- Hero Content -->
                <div class="absolute inset-0 flex flex-col justify-end">
                    <div class="mx-auto max-w-4xl w-full px-6 pb-16 sm:pb-24">
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            <span v-if="post.category" class="px-3 py-1 bg-raosc-green text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-raosc-green/20">
                                {{ post.category }}
                            </span>
                            <span class="flex items-center gap-1.5 text-white/80 text-xs font-medium">
                                <Clock class="w-3.5 h-3.5" /> {{ post.read_time }} min de lecture
                            </span>
                        </div>
                        <h1 class="text-4xl sm:text-6xl font-black text-white leading-[1.1] tracking-tight mb-8">
                            {{ post.title }}
                        </h1>
                        
                        <!-- Author/Org Info in Hero -->
                        <div class="flex items-center gap-4 pt-8 border-t border-white/10">
                            <Link v-if="post.organization" :href="`/rao/orga/${post.organization.slug}`" class="group flex items-center gap-3">
                                <div class="h-12 w-12 rounded-2xl overflow-hidden bg-white/10 backdrop-blur-md border border-white/20 p-1 group-hover:scale-105 transition-transform">
                                    <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-contain rounded-xl" />
                                    <div v-else class="h-full w-full flex items-center justify-center">
                                        <Building2 class="w-6 h-6 text-white/40" />
                                    </div>
                                </div>
                                <div>
                                    <p class="text-white/60 text-[10px] font-bold uppercase tracking-wider">Publié par</p>
                                    <p class="text-white font-bold group-hover:text-raosc-green transition-colors">{{ post.organization.name }}</p>
                                </div>
                            </Link>
                            <div class="ml-auto flex items-center gap-2 text-white/60 text-sm">
                                <Calendar class="w-4 h-4" /> {{ post.created_at }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="relative z-10 -mt-10 sm:-mt-16 mx-auto max-w-4xl px-4 sm:px-6">
                <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl shadow-black/5 dark:shadow-black/20 p-6 sm:p-12 lg:p-16 border border-zinc-100 dark:border-zinc-800">
                    
                    <!-- Breadcrumbs & Actions -->
                    <div class="flex items-center justify-between mb-12">
                        <Link href="/posts" class="inline-flex items-center gap-2 text-xs font-bold text-zinc-400 hover:text-raosc-green transition-colors uppercase tracking-widest">
                            <ArrowLeft class="w-4 h-4" /> Retour aux actualités
                        </Link>
                    </div>

                    <!-- Summary box -->
                    <div v-if="post.summary" class="relative mb-12">
                        <div class="absolute -left-4 sm:-left-8 top-0 bottom-0 w-1 bg-raosc-yellow rounded-full" />
                        <p class="text-xl sm:text-2xl text-zinc-800 dark:text-zinc-200 font-bold leading-relaxed italic opacity-90">
                            "{{ post.summary }}"
                        </p>
                    </div>

                    <!-- Main Content -->
                    <div
                        class="content-render text-lg sm:text-xl text-zinc-600 dark:text-zinc-400 leading-[1.8] prose prose-zinc dark:prose-invert max-w-none 
                        [&>p]:mb-8
                        [&>h2]:text-2xl [&>h2]:sm:text-3xl [&>h2]:font-black [&>h2]:text-zinc-900 [&>h2]:dark:text-white [&>h2]:mt-12 [&>h2]:mb-6 [&>h2]:tracking-tight
                        [&>h3]:text-xl [&>h3]:font-bold [&>h3]:text-zinc-900 [&>h3]:dark:text-white [&>h3]:mt-8 [&>h3]:mb-4
                        [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-8 [&>ul]:space-y-2
                        [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mb-8 [&>ol]:space-y-2
                        [&>blockquote]:border-l-4 [&>blockquote]:border-raosc-green [&>blockquote]:bg-zinc-50 [&>blockquote]:dark:bg-zinc-950 [&>blockquote]:p-6 [&>blockquote]:rounded-r-2xl [&>blockquote]:italic [&>blockquote]:text-zinc-700 [&>blockquote]:dark:text-zinc-300 [&>blockquote]:mb-8
                        [&>a]:text-raosc-green [&>a]:font-bold [&>a]:no-underline [&>a]:border-b-2 [&>a]:border-raosc-green/20 [&>a]:hover:border-raosc-green [&>a]:transition-colors"
                        v-html="marked.parse(post.content)"
                    ></div>

                    <!-- Footer / Author Bio -->
                    <div class="mt-20 pt-12 border-t border-zinc-100 dark:border-zinc-800">
                        <div v-if="post.organization" class="flex flex-col sm:flex-row items-center gap-8 bg-zinc-50 dark:bg-zinc-950/50 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800">
                            <div class="h-24 w-24 shrink-0 rounded-2xl overflow-hidden bg-white dark:bg-zinc-900 shadow-sm border border-zinc-100 dark:border-zinc-800 p-2">
                                <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-contain" />
                                <Building2 v-else class="w-full h-full text-zinc-300 p-4" />
                            </div>
                            <div class="text-center sm:text-left flex-1">
                                <h4 class="text-xl font-black text-zinc-900 dark:text-white mb-2">{{ post.organization.name }}</h4>
                                <p class="text-zinc-500 dark:text-zinc-400 text-sm mb-4">Cette organisation est membre de la coalition RAOSC et contribue activement au développement social en Afrique.</p>
                                <Link :href="`/rao/orga/${post.organization.slug}`" class="inline-flex items-center gap-2 text-raosc-green font-bold text-sm hover:translate-x-1 transition-transform">
                                    Voir le profil complet <ArrowLeft class="w-4 h-4 rotate-180" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Projects of Org -->
                <div v-if="post.organization && post.organization.projects && post.organization.projects.length > 0" class="mt-20 mb-20">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-2xl sm:text-3xl font-black text-zinc-900 dark:text-white tracking-tight">Plus de {{ post.organization.name }}</h3>
                        <Link :href="`/rao/orga/${post.organization.slug}`" class="text-sm font-bold text-raosc-green hover:underline">Voir tout</Link>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <Link v-for="project in post.organization.projects" :key="project.id" :href="`/rao/orga/${post.organization.slug}`" class="group bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-zinc-100 dark:border-zinc-800 flex flex-col h-full">
                            <div class="h-48 overflow-hidden relative">
                                <img v-if="project.cover_image" :src="project.cover_image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                                <div v-else class="w-full h-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400">
                                    <Building2 class="w-10 h-10" />
                                </div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-zinc-900 dark:text-white shadow-sm">
                                        {{ project.type }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 line-clamp-2 group-hover:text-raosc-green transition-colors">{{ project.title }}</h4>
                                <div class="mt-auto pt-4 flex items-center gap-2 text-raosc-green text-xs font-bold group-hover:gap-3 transition-all">
                                    En savoir plus <ArrowLeft class="w-3 h-3 rotate-180" />
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>

        </article>
    </PublicLayout>
</template>
