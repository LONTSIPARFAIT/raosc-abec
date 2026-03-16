<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicHeader from '@/components/PublicHeader.vue';
import PublicFooter from '@/components/PublicFooter.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <Head title="À Propos - RAOSC" />
    <div class="min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans selection:bg-emerald-500/30 overflow-x-hidden">
        <PublicHeader :user="$page.props.auth.user" />

        <main class="flex-grow pt-32 pb-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-6xl mb-8">
                    À Propos de <span class="text-emerald-600">RAOSC</span>
                </h1>
                <p class="text-xl leading-8 text-zinc-600 dark:text-zinc-400 max-w-3xl mx-auto">
                    Le Réseau des Associations et ONG de la Société Civile est une initiative de l'ONG ABEC visant à fédérer les acteurs du développement.
                </p>
                
                <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-12 text-left">
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <h2 class="text-2xl font-bold mb-4">Notre Mission</h2>
                        <p class="text-zinc-600 dark:text-zinc-400">
                            Renforcer les capacités des organisations de la société civile par la mise en réseau, le partage d'expérience et l'accès à des ressources numériques modernes.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <h2 class="text-2xl font-bold mb-4">Notre Vision</h2>
                        <p class="text-zinc-600 dark:text-zinc-400">
                            Une société civile dynamique, solidaire et technologiquement outillée pour un impact social durable et mesurable.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
