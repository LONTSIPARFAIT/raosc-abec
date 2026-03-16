<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicHeader from '@/components/PublicHeader.vue';
import PublicFooter from '@/components/PublicFooter.vue';
import { Mail, Phone, MapPin } from 'lucide-vue-next';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <Head title="Contact - RAOSC" />
    <div class="min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans selection:bg-emerald-500/30 overflow-x-hidden">
        <PublicHeader :user="$page.props.auth.user" />

        <main class="flex-grow pt-32 pb-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div>
                        <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-6xl mb-8">
                            Contactez <span class="text-emerald-600">RAOSC</span>
                        </h1>
                        <p class="text-xl text-zinc-600 dark:text-zinc-400 mb-12">
                            Une question sur le réseau ou besoin d'assistance ? Notre équipe est là pour vous aider.
                        </p>
                        
                        <div class="space-y-8">
                            <div class="flex items-center gap-6">
                                <div class="h-12 w-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                    <Mail class="h-6 w-6" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-zinc-900 dark:text-white">Email</h3>
                                    <p class="text-zinc-500">contact@universalwelfare.org</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="h-12 w-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                    <Phone class="h-6 w-6" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-zinc-900 dark:text-white">Téléphone</h3>
                                    <p class="text-zinc-500">+229 00 00 00 00</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="h-12 w-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                    <MapPin class="h-6 w-6" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-zinc-900 dark:text-white">Siège</h3>
                                    <p class="text-zinc-500">Cotonou, Bénin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
                        <form class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold mb-2">Nom Complet</label>
                                <input type="text" class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none transition-all" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Email</label>
                                <input type="email" class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none transition-all" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Message</label>
                                <textarea rows="4" class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none transition-all"></textarea>
                            </div>
                            <button type="button" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-600/20 transition-all">
                                Envoyer le Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <PublicFooter />
    </div>
</template>
