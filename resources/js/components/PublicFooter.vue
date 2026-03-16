<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BuildingIcon } from 'lucide-vue-next';
</script>

<template>
<footer class="bg-zinc-950 pt-20 pb-10 border-t border-zinc-800 dark:bg-black text-zinc-400">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-2">
                <Link href="/" class="flex items-center gap-3 mb-6 group" prefetch>
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-emerald-600 text-white shadow-lg shadow-emerald-600/20 grayscale group-hover:grayscale-0 transition-all">
                        <BuildingIcon class="h-6 w-6" />
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-white">
                        RAOSC
                    </span>
                </Link>
                <p class="text-sm leading-7 max-w-sm mb-6">
                    Le Réseau des Associations et ONG de la Société Civile est une plateforme d'échange et de collaboration dédiée au renforcement des capacités des organisations communautaires.
                </p>
                <div class="flex gap-4">
                    <!-- Placeholder for Social Icons -->
                    <div class="h-8 w-8 rounded-full bg-zinc-800 flex items-center justify-center hover:bg-emerald-600 transition-colors cursor-pointer">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-zinc-800 flex items-center justify-center hover:bg-emerald-600 transition-colors cursor-pointer">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.412.56.216.96.472 1.381.893.42.42.677.82.893 1.38.163.422.358 1.057.412 2.227.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.249 1.805-.412 2.227-.216.56-.472.96-.893 1.381-.42.42-.82.677-1.38.893-.422.163-1.057.358-2.227.412-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.805-.249-2.227-.412-.56-.216-.96-.472-1.381-.893-.42-.42-.677-.82-.893-1.38-.163-.422-.358-1.057-.412-2.227-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.054-1.17.249-1.805.412-2.227.216-.56.472-.96.893-1.381.42-.42.82-.677 1.38-.893.422-.163 1.057-.358 2.227-.412 1.266-.058 1.646-.07 4.85-.07m0-2.163c-3.259 0-3.667.014-4.947.072-1.277.057-2.148.258-2.911.554-.788.305-1.456.714-2.122 1.38-.666.666-1.075 1.334-1.38 2.122-.296.763-.497 1.634-.554 2.911-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.057 1.277.258 2.148.554 2.911.305.788.714 1.456 1.38 2.122.666.666 1.334 1.075 2.122 1.38.763.296 1.634.497 2.911.554 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.277-.057 2.148-.258 2.911-.554.788-.305 1.456-.714 2.122-1.38.666-.666 1.075-1.334 1.38-2.122.296-.763.497-1.634.554-2.911.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.057-1.277-.258-2.148-.554-2.911-.305-.788-.714-1.456-1.38-2.122-.666-.666-1.334-1.075-2.122-1.38-.763-.296-1.634-.497-2.911-.554-1.28-.058-1.688-.072-4.947-.072z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Links Column 1 -->
            <div>
                <h3 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Navigation</h3>
                <ul class="space-y-4 text-sm font-medium">
                    <li><Link href="/" class="hover:text-emerald-400 transition-colors" prefetch>Accueil</Link></li>
                    <li><Link href="/rao" class="hover:text-emerald-400 transition-colors" prefetch>Annuaire OSC</Link></li>
                    <li><Link href="/posts" class="hover:text-emerald-400 transition-colors" prefetch>Actualités</Link></li>
                    <li><Link href="/about" class="hover:text-emerald-400 transition-colors" prefetch>À propos</Link></li>
                    <li><Link href="/contact" class="hover:text-emerald-400 transition-colors" prefetch>Contact</Link></li>
                </ul>
            </div>

            <!-- Links Column 2 -->
            <div>
                <h3 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">L'ONG ABEC</h3>
                <ul class="space-y-4 text-sm font-medium">
                    <li><a href="https://universalwelfare.org/a-propos" target="_blank" class="hover:text-emerald-400 transition-colors">Notre Mission</a></li>
                    <li><a href="https://universalwelfare.org/nos-actions" target="_blank" class="hover:text-emerald-400 transition-colors">Nos Actions</a></li>
                    <li><a href="https://universalwelfare.org/contact" target="_blank" class="hover:text-emerald-400 transition-colors">Devenir Membre</a></li>
                    <li><Link href="/mentions-legales" class="hover:text-emerald-400 transition-colors" prefetch>Mentions Légales</Link></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-zinc-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs text-zinc-500 text-center">
                Plateforme propulsée par 
                <a href="https://universalwelfare.org/" target="_blank" class="text-emerald-500 hover:text-emerald-400 font-bold ml-1 transition-all hover:underline underline-offset-4 decoration-emerald-500/30">
                    L'ONG ABEC
                </a>. &copy; {{ new Date().getFullYear() }} Tous droits réservés.
            </p>
            <div class="flex gap-6 text-xs text-zinc-600">
                <Link href="/privacy" class="hover:text-zinc-400" prefetch>Vie privée</Link>
                <Link href="/terms" class="hover:text-zinc-400" prefetch>Conditions</Link>
                <Link href="/cookies" class="hover:text-zinc-400" prefetch>Cookies</Link>
            </div>
        </div>
    </div>
</footer>
</template>
