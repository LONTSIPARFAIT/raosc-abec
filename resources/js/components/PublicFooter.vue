<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Mail, Phone, MapPin, Twitter, Instagram, Facebook } from 'lucide-vue-next';
</script>

<template>
    <footer class="bg-zinc-950 pt-16 pb-8 text-zinc-400 border-t border-zinc-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">
                <!-- Brand Column -->
                <div class="md:col-span-12 lg:col-span-5">
                    <Link href="/" class="flex items-center gap-3 mb-6 group" prefetch>
                        <div class="flex h-16 w-16 items-center justify-center transition-transform group-hover:scale-105">
                            <img src="/images/Logo_Raosc-removebg-preview.png" alt="RAOSC Logo" class="h-full w-full" />
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-white leading-none">
                                RAOSC
                            </span>
                            <span class="text-[9px] font-medium text-raosc-green tracking-wide leading-none mt-1">
                                Initiative ONG ABEC
                            </span>
                        </div>
                    </Link>
                    <p class="text-sm leading-relaxed text-zinc-500 max-w-md mb-6">
                        Bâtir une société civile africaine forte, connectée et capable d'influencer le changement social à travers l'innovation technologique et la collaboration stratégique.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="h-8 w-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-raosc-green hover:text-white transition-colors">
                            <Facebook class="h-4 w-4" />
                        </a>
                        <a href="#" class="h-8 w-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-raosc-green hover:text-white transition-colors">
                            <Twitter class="h-4 w-4" />
                        </a>
                        <a href="#" class="h-8 w-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-raosc-red hover:text-white transition-colors">
                            <Instagram class="h-4 w-4" />
                        </a>
                    </div>
                </div>

                <!-- Links Column 1 -->
                <div class="md:col-span-4 lg:col-span-2">
                    <h3 class="text-white font-semibold text-xs tracking-wide mb-5">Navigation</h3>
                    <ul class="space-y-3 text-sm">
                        <li><Link href="/" class="hover:text-raosc-green transition-colors">Accueil</Link></li>
                        <li><Link href="/rao" class="hover:text-raosc-green transition-colors">Annuaire OSC</Link></li>
                        <li><Link href="/posts" class="hover:text-raosc-green transition-colors">Actualités</Link></li>
                        <li><Link href="/community" class="hover:text-raosc-green transition-colors">Communauté</Link></li>
                    </ul>
                </div>

                <!-- Links Column 2 -->
                <div class="md:col-span-4 lg:col-span-2">
                    <h3 class="text-white font-semibold text-xs tracking-wide mb-5">L'Organisation</h3>
                    <ul class="space-y-3 text-sm">
                        <li><Link href="/about" class="hover:text-raosc-green transition-colors">Charte éthique</Link></li>
                        <li><Link href="/about" class="hover:text-raosc-green transition-colors">Nos Valeurs</Link></li>
                        <li><Link href="/contact" class="hover:text-raosc-green transition-colors">Contact</Link></li>
                        <li><Link href="/mentions-legales" class="hover:text-raosc-green transition-colors">Légal</Link></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div class="md:col-span-4 lg:col-span-3">
                    <h3 class="text-white font-semibold text-xs tracking-wide mb-5">Siège Global</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <MapPin class="h-4 w-4 text-raosc-yellow shrink-0 mt-0.5" />
                            <span class="text-sm leading-relaxed">Yaoundé, Cameroun</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Mail class="h-4 w-4 text-raosc-green shrink-0" />
                            <a href="mailto:contact@raosc.org" class="text-sm hover:text-raosc-green transition-colors">contact@raosc.org</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <Phone class="h-4 w-4 text-raosc-red shrink-0" />
                            <a href="tel:+237697000000" class="text-sm hover:text-raosc-green transition-colors">+237 697 00 00 00</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="pt-8 border-t border-zinc-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-zinc-500">
                <p>
                    Propulsé par 
                    <a target="_blank" href="https://universalwelfare.org/" class="text-raosc-green hover:text-raosc-green/80 font-medium transition-colors">l'ONG ABEC</a>. 
                    &copy; {{ new Date().getFullYear() }} Tous droits réservés.
                </p>
                <div class="flex gap-6">
                    <Link href="/privacy" class="hover:text-white transition-colors">Confidentialité</Link>
                    <Link href="/terms" class="hover:text-white transition-colors">Conditions</Link>
                    <Link href="/cookies" class="hover:text-white transition-colors">Cookies</Link>
                </div>
            </div>
        </div>
    </footer>
</template>