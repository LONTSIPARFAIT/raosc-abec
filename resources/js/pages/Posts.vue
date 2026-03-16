<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicHeader from '@/components/PublicHeader.vue';
import PublicFooter from '@/components/PublicFooter.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <Head title="Actualités - RAOSC" />
    <div class="min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans selection:bg-emerald-500/30 overflow-x-hidden">
        <PublicHeader :user="$page.props.auth.user" />

        <main class="flex-grow pt-32 pb-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-6xl mb-6">
                        Actualités du <span class="text-emerald-600">Réseau</span>
                    </h1>
                    <p class="text-xl text-zinc-600 dark:text-zinc-400">
                        Restez informé des dernières actions et projets des associations membres.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="i in 3" :key="i" class="bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-sm animate-pulse">
                        <div class="h-48 bg-zinc-200 dark:bg-zinc-800"></div>
                        <div class="p-6">
                            <div class="h-4 w-24 bg-zinc-200 dark:bg-zinc-800 rounded mb-4"></div>
                            <div class="h-6 w-full bg-zinc-200 dark:bg-zinc-800 rounded mb-4"></div>
                            <div class="h-20 w-full bg-zinc-200 dark:bg-zinc-800 rounded"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-16 text-center py-12 bg-emerald-50 dark:bg-emerald-950/20 rounded-3xl border border-emerald-100 dark:border-emerald-900/30">
                    <p class="text-emerald-800 dark:text-emerald-300 font-medium">Les articles seront bientôt disponibles.</p>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
