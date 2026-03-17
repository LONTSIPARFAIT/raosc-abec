<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Mail, Phone, MapPin, Send } from 'lucide-vue-next';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <PublicLayout>
        <Head title="Contact - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen">
            <!-- Header section -->
            <div class="bg-zinc-950 py-20 sm:py-32 px-6 text-center">
                <div class="mx-auto max-w-7xl">
                    <span class="text-[#008751] font-bold tracking-[0.2em] text-[10px] mb-4 block">Nous Contacter</span>
                    <h1 class="text-3xl sm:text-5xl font-bold text-white mb-6 tracking-tight">
                        Une question ? Parlons-en <span class="text-[#FFCB05]">ensemble</span>
                    </h1>
                    <p class="text-zinc-400 text-sm sm:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                        Notre équipe est à votre disposition pour vous accompagner dans votre utilisation du réseau.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-12 pb-24 relative z-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Info Cards -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-8">Coordonnées de l'ONG ABEC</h3>
                            
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="h-10 w-10 bg-zinc-50 dark:bg-zinc-800 rounded-xl flex items-center justify-center text-[#008751] shrink-0">
                                        <Mail class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-zinc-400 tracking-tight">Email</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">contact@raosc.org</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="h-10 w-10 bg-zinc-50 dark:bg-zinc-800 rounded-xl flex items-center justify-center text-[#FFCB05] shrink-0">
                                        <Phone class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-zinc-400 tracking-tight">Téléphone</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">+229 97 00 00 00</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="h-10 w-10 bg-zinc-50 dark:bg-zinc-800 rounded-xl flex items-center justify-center text-[#E4002B] shrink-0">
                                        <MapPin class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-zinc-400 tracking-tight">Localisation</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">Haie Vive, Cotonou, Bénin</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#310808] p-8 rounded-3xl text-white">
                            <h3 class="font-bold mb-2">Support Technique</h3>
                            <p class="text-xs text-zinc-400 mb-6">Besoin d'aide pour l'administration de votre fiche organisation ?</p>
                            <a href="#" class="text-xs font-bold text-[#FFCB05] tracking-widest hover:underline">Support WhatsApp →</a>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="lg:col-span-7">
                        <div class="bg-white dark:bg-zinc-900 p-8 sm:p-12 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-zinc-400 tracking-tight ml-1">Nom Complet</label>
                                        <input type="text" placeholder="John Doe" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#008751] outline-none transition-all dark:text-white" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-zinc-400 tracking-tight ml-1">Email</label>
                                        <input type="email" placeholder="john@example.com" class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#008751] outline-none transition-all dark:text-white" />
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-zinc-400 tracking-tight ml-1">Sujet</label>
                                    <select class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#008751] outline-none appearance-none dark:text-white">
                                        <option>Question générale</option>
                                        <option>Assistance technique</option>
                                        <option>Devenir partenaire</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-zinc-400 tracking-tight ml-1">Message</label>
                                    <textarea rows="4" placeholder="Votre message..." class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#008751] outline-none transition-all dark:text-white resize-none"></textarea>
                                </div>
                                <button type="button" class="w-full sm:w-auto bg-[#008751] text-white font-bold py-4 px-10 rounded-2xl transition-all hover:bg-[#006b40] shadow-lg shadow-[#008751]/20 flex items-center justify-center gap-2 text-xs hover:-translate-y-0.5">
                                    Envoyer le message
                                    <Send class="w-3.5 h-3.5" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>
