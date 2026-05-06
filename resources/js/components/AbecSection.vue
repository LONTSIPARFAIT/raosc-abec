<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Sparkles, Heart, Globe, ShieldCheck } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

const abecFeatures = [
    {
        title: "Éveil des Consciences",
        description: "Promouvoir une citoyenneté active et responsable pour un impact durable.",
        icon: Sparkles,
        color: "text-raosc-green",
        bg: "bg-raosc-green/10"
    },
    {
        title: "Soutien aux OSC",
        description: "Accompagner les organisations dans leur professionnalisation et leur croissance.",
        icon: Heart,
        color: "text-raosc-red",
        bg: "bg-raosc-red/10"
    },
    {
        title: "Réseautage Africain",
        description: "Bâtir des ponts entre les acteurs du changement à travers tout le continent.",
        icon: Globe,
        color: "text-raosc-yellow",
        bg: "bg-raosc-yellow/10"
    }
];
</script>

<template>
    <section class="relative py-24 overflow-hidden bg-white dark:bg-zinc-950">
        <!-- Fond décoratif -->
        <div class="absolute inset-0 -z-10 opacity-30 dark:opacity-100">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-raosc-green/5 blur-[120px] rounded-full translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-1/2 h-full bg-raosc-yellow/5 blur-[120px] rounded-full -translate-x-1/2"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Texte ABEC -->
                <div class="space-y-8 animate-fade-in">
                    <div class="inline-flex items-center gap-2 bg-zinc-100 dark:bg-white/5 backdrop-blur-sm px-4 py-2 rounded-full border border-zinc-200 dark:border-white/10">
                        <ShieldCheck class="w-4 h-4 text-raosc-green" />
                        <span class="text-xs font-bold tracking-widest text-zinc-600 dark:text-white uppercase">À propos de l'ABEC</span>
                    </div>
                    
                    <h2 class="text-4xl sm:text-5xl font-black text-zinc-900 dark:text-white leading-tight tracking-tight">
                        L'Association du Bien-Être Communautaire (<span class="text-raosc-green text-gradient">ABEC</span>)
                    </h2>
                    
                    <p class="text-zinc-600 dark:text-zinc-400 text-lg leading-relaxed">
                        L'Association du Bien-Être Communautaire (ABEC) est une organisation internationale à but non lucratif, légalement reconnue et enregistrée auprès des institutions locales sous le numéro de déclaration 00001901/RDA/J06/SAAJP/BAPP. Fondée par des jeunes visionnaires, elle rassemble des membres de plusieurs nationalités et place l'équité femmes-hommes au cœur de sa gouvernance.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                        <div v-for="(feature, idx) in abecFeatures" :key="idx" class="flex gap-4">
                            <div :class="['h-10 w-10 shrink-0 rounded-xl flex items-center justify-center', feature.bg]">
                                <component :is="feature.icon" :class="['w-5 h-5', feature.color]" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-1">{{ feature.title }}</h4>
                                <p class="text-xs text-zinc-500 leading-relaxed">{{ feature.description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <Link href="https://universalwelfare.org/" target="_blank">
                            <Button class="bg-zinc-950 dark:bg-white hover:bg-zinc-800 dark:hover:bg-zinc-200 text-white dark:text-zinc-950 font-bold rounded-xl px-8 py-6 group transition-all duration-300">
                                En savoir plus sur l'ABEC
                                <ArrowRight class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" />
                            </Button>
                        </Link>
                    </div>
                </div>

                <!-- Image / Visuel ABEC -->
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-raosc-green/20 to-raosc-yellow/20 rounded-[2.5rem] blur-2xl opacity-30 dark:opacity-50 group-hover:opacity-100 transition-opacity duration-700"></div>
                    <div class="relative rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-white/10 shadow-2xl">
                        <img 
                            src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?q=80&w=2070&auto=format&fit=crop" 
                            alt="Réunion ABEC" 
                            class="w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/60 via-transparent to-transparent"></div>
                        
                        <!-- Badge flottant -->
                        <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/10 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/20 dark:border-white/10">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-full bg-raosc-green flex items-center justify-center text-white font-black text-xl shadow-lg">A</div>
                                <div>
                                    <p class="text-white font-bold text-sm">Vision ABEC 2030</p>
                                    <p class="text-zinc-200 text-xs mt-0.5">Plus de 1000 OSC accompagnées à travers l'Afrique.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<style scoped>
.text-gradient {
    background: linear-gradient(to right, #2ecc71, #f1c40f);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
