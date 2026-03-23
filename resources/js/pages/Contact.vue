<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Mail, Phone, MapPin, ArrowRight, Send } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    user?: any;
}>();
</script>

<template>
    <PublicLayout>
        <Head title="Contact - RAOSC" />

        <main class="bg-zinc-50 dark:bg-zinc-950 min-h-screen">
            <!-- Header Section -->
            <div class="bg-zinc-950 py-20 sm:py-28 px-6 overflow-hidden relative">
                <div class="absolute inset-0 z-0">
                    <div class="absolute top-0 right-1/4 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>
                </div>

                <div class="mx-auto max-w-4xl relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <div class="flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 border border-white/20">
                            <span class="text-[10px] font-bold tracking-[0.2em] text-raosc-yellow uppercase">Contactez l'ABEC</span>
                        </div>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                        Une question ? Parlons-en <span class="text-raosc-yellow">ensemble</span>
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-400 max-w-2xl mx-auto font-medium">
                        Notre équipe est à votre disposition pour vous accompagner dans votre utilisation du réseau RAOSC.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8 -mt-12 sm:-mt-16 pb-24 relative z-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Info Cards -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Coordonnées de l'ONG ABEC</h3>
                            
                            <div class="space-y-5">
                                <div class="flex items-start gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-raosc-green shrink-0">
                                        <Mail class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Email</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">contact@raosc.org</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-raosc-yellow shrink-0">
                                        <Phone class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Téléphone</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">+237 697 00 00 00</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-raosc-red shrink-0">
                                        <MapPin class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Localisation</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">Yaoundé, Cameroun</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-[#310808] to-black p-6 rounded-2xl text-white shadow-sm">
                            <h3 class="font-bold mb-2">Support Technique</h3>
                            <p class="text-xs text-zinc-400 mb-5 leading-relaxed">Besoin d'aide pour l'administration de votre fiche organisation ?</p>
                            <a href="#" class="inline-flex items-center gap-2 text-xs font-semibold text-raosc-yellow hover:underline transition-colors">
                                Support WhatsApp
                                <ArrowRight class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="lg:col-span-7">
                        <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                            <form class="space-y-5">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5">Nom Complet</label>
                                        <input 
                                            type="text" 
                                            placeholder="John Doe" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5">Email</label>
                                        <input 
                                            type="email" 
                                            placeholder="john@example.com" 
                                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white" 
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5">Sujet</label>
                                    <select class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none appearance-none dark:text-white">
                                        <option>Question générale</option>
                                        <option>Assistance technique</option>
                                        <option>Devenir partenaire</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5">Message</label>
                                    <textarea 
                                        rows="4" 
                                        placeholder="Votre message..." 
                                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green outline-none transition-all dark:text-white resize-none"
                                    ></textarea>
                                </div>
                                <div class="pt-2">
                                    <button 
                                        type="button" 
                                        class="inline-flex items-center gap-2 bg-raosc-green text-white font-semibold py-2.5 px-6 rounded-full text-sm hover:bg-raosc-green/90 transition-all shadow-sm"
                                    >
                                        Envoyer le message
                                        <Send class="w-4 h-4" />
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>