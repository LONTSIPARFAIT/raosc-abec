<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicHeader from '@/components/PublicHeader.vue';
import PublicFooter from '@/components/PublicFooter.vue';
import { Users, MessageSquare, Share2 } from 'lucide-vue-next';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <Head title="Communauté - RAOSC" />
    <div class="min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans selection:bg-emerald-500/30 overflow-x-hidden">
        <PublicHeader :user="$page.props.auth.user" />

        <main class="flex-grow pt-32 pb-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-6xl mb-8">
                    Espace <span class="text-emerald-600">Communauté</span>
                </h1>
                <p class="text-xl leading-8 text-zinc-600 dark:text-zinc-400 max-w-3xl mx-auto mb-16">
                    Rejoignez les discussions, partagez vos expériences et collaborez avec d'autres organisations engagées.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 mb-6">
                            <Users class="h-6 w-6" />
                        </div>
                        <h3 class="text-xl font-bold mb-3">Forums de Discussion</h3>
                        <p class="text-zinc-500 text-sm">Échangez sur des thématiques variées avec des experts et des bénévoles.</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 mb-6">
                            <MessageSquare class="h-6 w-6" />
                        </div>
                        <h3 class="text-xl font-bold mb-3">Messagerie Directe</h3>
                        <p class="text-zinc-500 text-sm">Communiquez en temps réel avec les responsables d'autres associations.</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 mb-6">
                            <Share2 class="h-6 w-6" />
                        </div>
                        <h3 class="text-xl font-bold mb-3">Partage de Ressources</h3>
                        <p class="text-zinc-500 text-sm">Publiez et consultez des documents utiles pour la gestion de vos projets.</p>
                    </div>
                </div>

                <div class="mt-20 p-12 bg-zinc-900 rounded-[3rem] text-white overflow-hidden relative">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold mb-6">Bientôt disponible pour tous</h2>
                        <p class="text-zinc-400 mb-8 max-w-xl mx-auto italic">Nous finalisons les derniers détails techniques pour vous offrir une expérience communautaire exceptionnelle.</p>
                        <button class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 px-10 rounded-full transition-all">
                            Me notifier de l'ouverture
                        </button>
                    </div>
                    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl"></div>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
