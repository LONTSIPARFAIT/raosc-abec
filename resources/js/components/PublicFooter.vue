<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Mail, Phone, MapPin, Twitter, Instagram, Facebook } from 'lucide-vue-next';
</script>

<template>
<footer class="bg-zinc-950 pt-24 pb-12 text-zinc-400 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute bottom-0 right-0 translate-y-1/2 translate-x-1/2 w-96 h-96 bg-raosc-green opacity-5 rounded-full blur-[100px]"></div>

    <div class="mx-auto max-w-7xl px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-20">
            <!-- Brand Column -->
            <div class="md:col-span-12 lg:col-span-5">
                <Link href="/" class="flex items-center gap-4 mb-8 group" prefetch>
                    <div class="flex h-14 w-14 items-center justify-center transition-all group-hover:scale-110">
                        <img src="/images/Logo_Raosc-removebg-preview.png" alt="RAOSC Logo" class="h-14 w-auto drop-shadow-2xl" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black tracking-tighter text-white leading-none">
                            RAOSC
                        </span>
                        <span class="text-[10px] font-black text-raosc-green tracking-[0.2em] uppercase leading-none mt-1">
                            Initiative ONG ABEC
                        </span>
                    </div>
                </Link>
                <p class="text-sm leading-relaxed max-w-md mb-10 font-medium text-zinc-500 tracking-tight border-l-3 border-raosc-green/30 pl-6 py-1">
                    Bâtir une société civile africaine forte, connectée et capable d'influencer le changement social à travers l'innovation technologique et la collaboration stratégique.
                </p>
                <div class="flex gap-4">
                    <div class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-raosc-green hover:text-white transition-all cursor-pointer border border-white/10 group drop-shadow-xl">
                        <Facebook class="h-4 w-4" />
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-raosc-green hover:text-white transition-all cursor-pointer border border-white/10 group drop-shadow-xl">
                        <Twitter class="h-4 w-4" />
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-raosc-red hover:text-white transition-all cursor-pointer border border-white/10 group drop-shadow-xl">
                        <Instagram class="h-4 w-4" />
                    </div>
                </div>
            </div>

            <!-- Links Column 1 -->
            <div class="md:col-span-4 lg:col-span-2">
                <h3 class="text-white font-bold mb-8 tracking-tight text-sm">Navigation</h3>
                <ul class="space-y-4 text-sm font-medium">
                    <li><Link href="/" class="hover:text-raosc-green transition-colors" prefetch>Accueil</Link></li>
                    <li><Link href="/rao" class="hover:text-raosc-green transition-colors" prefetch>Annuaire OSC</Link></li>
                    <li><Link href="/posts" class="hover:text-raosc-green transition-colors" prefetch>Actualités</Link></li>
                    <li><Link href="/community" class="hover:text-raosc-green transition-colors" prefetch>Communauté</Link></li>
                </ul>
            </div>

            <!-- Links Column 2 -->
            <div class="md:col-span-4 lg:col-span-2">
                <h3 class="text-white font-bold mb-8 tracking-tight text-sm">L'Organisation</h3>
                <ul class="space-y-4 text-sm font-medium">
                    <li><Link href="/about" class="hover:text-raosc-green transition-colors" prefetch>Charte éthique</Link></li>
                    <li><Link href="/about" class="hover:text-raosc-green transition-colors" prefetch>Nos Valeurs</Link></li>
                    <li><Link href="/contact" class="hover:text-raosc-green transition-colors" prefetch>Contact</Link></li>
                    <li><Link href="/mentions-legales" class="hover:text-raosc-green transition-colors" prefetch>Légal</Link></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="md:col-span-4 lg:col-span-3">
                <h3 class="text-white font-bold mb-8 tracking-tight text-sm">Siège Global</h3>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4">
                        <div class="h-8 w-8 rounded-lg bg-white/5 flex items-center justify-center text-raosc-yellow shrink-0">
                            <MapPin class="h-4 w-4" />
                        </div>
                        <span class="text-xs font-semibold leading-relaxed tracking-tight">Quartier Haie Vive, Cotonou, <br/>République du Bénin</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="h-8 w-8 rounded-lg bg-white/5 flex items-center justify-center text-raosc-green shrink-0">
                            <Mail class="h-4 w-4" />
                        </div>
                        <span class="text-xs font-semibold tracking-tight">contact@raosc.org</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="h-8 w-8 rounded-lg bg-white/5 flex items-center justify-center text-raosc-red shrink-0">
                            <Phone class="h-4 w-4" />
                        </div>
                        <span class="text-xs font-semibold tracking-tight">+229 97 00 00 00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="text-[10px] font-medium text-zinc-500 tracking-tight">
                Propulsé par 
                <a href="#" class="text-raosc-green hover:text-[#006b40] font-bold ml-1 transition-all hover:underline underline-offset-4 decoration-raosc-green">
                    l'ONG ABEC
                </a>. &copy; {{ new Date().getFullYear() }} Tous droits réservés.
            </p>
            <div class="flex gap-8 text-[10px] font-medium text-zinc-600 tracking-tight">
                <Link href="/privacy" class="hover:text-white transition-colors" prefetch>Confidentialité</Link>
                <Link href="/terms" class="hover:text-white transition-colors" prefetch>Conditions</Link>
                <Link href="/cookies" class="hover:text-white transition-colors" prefetch>Cookies</Link>
            </div>
        </div>
    </div>
</footer>
</template>

