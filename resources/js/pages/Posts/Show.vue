<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Clock, Building2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

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
        } | null;
    };
}>();
</script>

<template>
    <PublicLayout>
        <Head :title="post.title + ' - RAOSC'" />

        <article class="bg-white dark:bg-zinc-950 min-h-screen">

            <!-- Image de une -->
            <div v-if="post.cover_image" class="w-full h-[50vh] max-h-[520px] overflow-hidden">
                <img :src="post.cover_image" :alt="post.title" class="w-full h-full object-cover" />
            </div>

            <!-- Corps -->
            <div class="mx-auto max-w-2xl px-6 py-14">

                <!-- Fil d'ariane -->
                <Link href="/posts" class="inline-flex items-center gap-1.5 text-sm text-zinc-400 hover:text-raosc-green transition-colors mb-10 font-medium">
                    <ArrowLeft class="w-4 h-4" /> Actualités
                </Link>

                <!-- Catégorie -->
                <p v-if="post.category" class="text-xs font-bold uppercase tracking-[0.15em] text-raosc-green mb-4">
                    {{ post.category }}
                </p>

                <!-- Titre -->
                <h1 class="text-4xl sm:text-5xl font-extrabold text-zinc-900 dark:text-white leading-tight tracking-tight mb-6">
                    {{ post.title }}
                </h1>

                <!-- Meta ligne -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-400 mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                    <span>{{ post.created_at }}</span>
                    <span v-if="post.read_time" class="flex items-center gap-1.5">
                        <Clock class="w-3.5 h-3.5" /> {{ post.read_time }} min de lecture
                    </span>
                    <Link v-if="post.organization" :href="`/rao/orga/${post.organization.slug}`" class="flex items-center gap-2 hover:text-raosc-green transition-colors ml-auto">
                        <div class="h-6 w-6 rounded-full overflow-hidden bg-zinc-100 dark:bg-zinc-800 shrink-0 flex items-center justify-center">
                            <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-cover" />
                            <Building2 v-else class="w-3 h-3 text-zinc-400" />
                        </div>
                        <span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ post.organization.name }}</span>
                    </Link>
                </div>

                <!-- Résumé -->
                <p v-if="post.summary" class="text-xl text-zinc-600 dark:text-zinc-300 leading-relaxed mb-10 font-medium">
                    {{ post.summary }}
                </p>

                <!-- Contenu -->
                <div
                    class="text-zinc-700 dark:text-zinc-300 text-lg leading-[1.9] space-y-5"
                    v-html="post.content.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br>')"
                ></div>

                <!-- Pied de page -->
                <div class="mt-16 pt-8 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                    <Link href="/posts" class="text-sm font-semibold text-zinc-500 hover:text-raosc-green transition-colors flex items-center gap-1.5">
                        <ArrowLeft class="w-4 h-4" /> Toutes les actualités
                    </Link>
                    <div v-if="post.organization">
                        <Link :href="`/rao/orga/${post.organization.slug}`" class="text-sm font-semibold text-raosc-green hover:underline">
                            Voir l'organisation →
                        </Link>
                    </div>
                </div>
            </div>
        </article>
    </PublicLayout>
</template>
