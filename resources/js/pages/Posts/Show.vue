<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Clock, Building2, Calendar, Tag } from 'lucide-vue-next';
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
        <Head :title="post.title + ' — RAOSC'" />

        <article class="bg-white dark:bg-zinc-950 min-h-screen">

            <!-- Cover image -->
            <div v-if="post.cover_image" class="relative w-full h-[45vh] max-h-[480px] overflow-hidden bg-zinc-900">
                <img :src="post.cover_image" :alt="post.title" class="absolute inset-0 w-full h-full object-cover opacity-70" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent" />
                <!-- Titre en bas du hero sur grand écran -->
                <div class="absolute bottom-0 left-0 right-0 px-6 sm:px-10 pb-10 max-w-3xl mx-auto">
                    <p v-if="post.category" class="text-xs font-bold uppercase tracking-[0.15em] text-raosc-green mb-3 flex items-center gap-1.5">
                        <Tag class="w-3.5 h-3.5" /> {{ post.category }}
                    </p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight tracking-tight">
                        {{ post.title }}
                    </h1>
                </div>
            </div>

            <!-- Corps de l'article -->
            <div class="mx-auto max-w-3xl px-5 sm:px-8 py-10">

                <!-- Fil d'Ariane -->
                <Link href="/posts" class="inline-flex items-center gap-1.5 text-sm text-zinc-400 hover:text-raosc-green transition-colors mb-8 font-medium">
                    <ArrowLeft class="w-4 h-4" /> Toutes les actualités
                </Link>

                <!-- Titre (si pas de cover image) -->
                <div v-if="!post.cover_image">
                    <p v-if="post.category" class="text-xs font-bold uppercase tracking-[0.15em] text-raosc-green mb-3 flex items-center gap-1.5">
                        <Tag class="w-3.5 h-3.5" /> {{ post.category }}
                    </p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-zinc-900 dark:text-white leading-tight tracking-tight mb-6">
                        {{ post.title }}
                    </h1>
                </div>

                <!-- Meta (date + lecture + organisation) -->
                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-zinc-400 mt-4 mb-8 pb-8 border-b border-zinc-100 dark:border-zinc-800">
                    <span class="flex items-center gap-1.5">
                        <Calendar class="w-3.5 h-3.5" /> {{ post.created_at }}
                    </span>
                    <span v-if="post.read_time" class="flex items-center gap-1.5">
                        <Clock class="w-3.5 h-3.5" /> {{ post.read_time }} min de lecture
                    </span>
                    <Link
                        v-if="post.organization"
                        :href="`/rao/orga/${post.organization.slug}`"
                        class="ml-auto flex items-center gap-2 hover:text-raosc-green transition-colors"
                    >
                        <div class="h-6 w-6 rounded-full overflow-hidden bg-zinc-100 dark:bg-zinc-800 shrink-0 flex items-center justify-center border border-zinc-200 dark:border-zinc-700">
                            <img v-if="post.organization.logo" :src="post.organization.logo" class="h-full w-full object-cover" />
                            <Building2 v-else class="w-3 h-3 text-zinc-400" />
                        </div>
                        <span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ post.organization.name }}</span>
                    </Link>
                </div>

                <!-- Résumé / chapeau -->
                <p v-if="post.summary" class="text-lg sm:text-xl text-zinc-700 dark:text-zinc-300 font-medium leading-relaxed mb-8">
                    {{ post.summary }}
                </p>

                <!-- Contenu -->
                <div
                    class="text-base sm:text-lg text-zinc-600 dark:text-zinc-400 leading-[1.9] space-y-5 [&>p]:mb-5"
                    v-html="post.content.replace(/\n\n+/g, '</p><p>').replace(/\n/g, '<br>')"
                ></div>

                <!-- Pied de page -->
                <div class="mt-16 pt-8 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between flex-wrap gap-4">
                    <Link href="/posts" class="inline-flex items-center gap-1.5 text-sm font-semibold text-zinc-400 hover:text-raosc-green transition-colors">
                        <ArrowLeft class="w-4 h-4" /> Retour aux actualités
                    </Link>
                    <Link v-if="post.organization" :href="`/rao/orga/${post.organization.slug}`" class="text-sm font-bold text-raosc-green hover:underline">
                        Découvrir {{ post.organization.name }} →
                    </Link>
                </div>
            </div>

        </article>
    </PublicLayout>
</template>
