<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Stats/Overview -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="i in 4" :key="i" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                            <PlaceholderPattern class="w-6 h-6 text-emerald-600" />
                        </div>
                        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <div class="text-2xl font-bold">--</div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Statistique {{ i }}</div>
                </div>
            </div>

            <div class="grid auto-rows-min gap-6 md:grid-cols-3">
                <!-- Action Cards -->
                <div class="group relative overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-emerald-500/5 transition-all group-hover:scale-150"></div>
                    <h3 class="text-xl font-bold mb-2">Annuaire RAO</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">Explorez la base de données des associations et ONG partenaires.</p>
                    <Link href="/rao" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 dark:text-emerald-400 group-hover:gap-3 transition-all">
                        Consulter l'annuaire <span>→</span>
                    </Link>
                </div>

                <div class="group relative overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-blue-500/5 transition-all group-hover:scale-150"></div>
                    <h3 class="text-xl font-bold mb-2">Ma Structure</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">Gérez les informations, les membres et les projets de votre organisation.</p>
                    <Link href="/rao/join" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 dark:text-blue-400 group-hover:gap-3 transition-all">
                        Gérer mon profil <span>→</span>
                    </Link>
                </div>

                <div class="group relative overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-amber-500/5 transition-all group-hover:scale-150"></div>
                    <h3 class="text-xl font-bold mb-2">Espace Communauté</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">Participez aux discussions et partagez vos expériences avec les autres membres.</p>
                    <Link href="/community" class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 dark:text-amber-400 group-hover:gap-3 transition-all">
                        Accéder au forum <span>→</span>
                    </Link>
                </div>
            </div>

            <!-- Recent Activity Placeholder -->
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">
                <h3 class="text-lg font-bold mb-6">Activités récentes</h3>
                <div class="space-y-6">
                    <div v-for="i in 3" :key="i" class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                            <PlaceholderPattern class="h-5 w-5 text-zinc-400" />
                        </div>
                        <div class="flex-1">
                            <div class="h-4 w-1/3 bg-zinc-100 dark:bg-zinc-800 rounded animate-pulse mb-2"></div>
                            <div class="h-3 w-1/2 bg-zinc-50 dark:bg-zinc-900 rounded animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
