<!-- AdminComingSoon.vue - Module en Construction -->
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Construction, ArrowLeft, Clock, Hammer, Calendar } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs = [
    { title: 'Tableau de bord', href: '/dashboard' },
    { title: 'Bientôt disponible', href: '#' }
];
</script>

<template>
    <Head title="Module en construction" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
            
            <!-- ============================================ -->
            <!-- HEADER SECTION -->
            <!-- ============================================ -->
            <div class="border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                <div class="container mx-auto px-6 lg:px-12 py-6">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                            <Hammer class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">Module en développement</h1>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Fonctionnalité bientôt disponible</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- CONTENU PRINCIPAL -->
            <!-- ============================================ -->
            <div class="container mx-auto px-6 lg:px-12 py-16">
                <div class="flex flex-col items-center justify-center text-center max-w-2xl mx-auto">
                    
                    <!-- Animation d'icône -->
                    <div class="relative mb-8">
                        <div class="h-32 w-32 rounded-[2rem] bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center shadow-xl border border-amber-100 dark:border-amber-500/20 animate-pulse">
                            <Construction class="w-16 h-16 text-amber-500 animate-bounce" />
                        </div>
                        <div class="absolute -top-2 -right-2 h-8 w-8 rounded-full bg-amber-400 flex items-center justify-center text-white text-xs font-bold animate-ping">
                            !
                        </div>
                    </div>

                    <h2 class="text-3xl lg:text-4xl font-black text-zinc-900 dark:text-white tracking-tight mb-4">
                        Module en construction
                    </h2>
                    
                    <p class="text-lg text-zinc-500 max-w-md mx-auto mb-6">
                        Cette fonctionnalité d'administration est actuellement en cours de développement. Elle sera disponible très prochainement dans une future mise à jour.
                    </p>

                    <!-- Infos supplémentaires -->
                    <div class="flex gap-4 mb-8 text-center">
                        <div class="flex flex-col items-center">
                            <div class="h-10 w-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-2">
                                <Clock class="w-5 h-5 text-zinc-500" />
                            </div>
                            <span class="text-xs text-zinc-500">Mise à jour Q2 2026</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="h-10 w-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-2">
                                <Calendar class="w-5 h-5 text-zinc-500" />
                            </div>
                            <span class="text-xs text-zinc-500">Prévue pour mai</span>
                        </div>
                    </div>
                    
                    <!-- Bouton retour -->
                    <Link href="/dashboard" class="inline-flex items-center gap-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-6 py-3 rounded-xl font-bold hover:scale-105 transition-all shadow-lg">
                        <ArrowLeft class="w-4 h-4" />
                        Retour au tableau de bord
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}
@keyframes ping {
    0% { transform: scale(1); opacity: 1; }
    75%, 100% { transform: scale(1.5); opacity: 0; }
}
.animate-bounce {
    animation: bounce 1s ease-in-out infinite;
}
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
.animate-ping {
    animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
}
</style>