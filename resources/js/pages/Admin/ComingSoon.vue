<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Construction, ArrowLeft } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs = [
    { title: 'Tableau de bord', href: '/dashboard' },
    { title: 'Bientôt disponible', href: '#' }
];
</script>

<template>
    <Head title="En construction" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center gap-6 p-6 lg:p-10 text-center">
            <div class="h-32 w-32 rounded-[2rem] bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500 shadow-xl shadow-amber-500/5 mb-8 border border-amber-100 dark:border-amber-500/20">
                <Construction class="w-16 h-16 animate-bounce" />
            </div>
            
            <h1 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tight">Module en construction</h1>
            <p class="text-zinc-500 max-w-lg mx-auto text-lg">
                Cette fonctionnalité d'administration est en cours de développement. Elle sera disponible très prochainement dans une future mise à jour.
            </p>
            
            <div class="mt-8">
                <Link href="/dashboard" class="inline-flex items-center gap-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-6 py-3 rounded-xl font-bold hover:scale-105 transition-all shadow-lg">
                    <ArrowLeft class="w-4 h-4" />
                    Retour au tableau de bord
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
