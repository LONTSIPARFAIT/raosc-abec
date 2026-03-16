<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    UsersIcon, 
    GlobeIcon, 
    HeartHandshakeIcon, 
    ShieldCheckIcon,
    ArrowRightIcon,
    ZapIcon,
    MessageSquareIcon,
    TrophyIcon,
    BuildingIcon
} from 'lucide-vue-next';
import HeroSlider from '@/components/HeroSlider.vue';
import OrganizationCard from '@/components/OrganizationCard.vue';
import PublicFooter from '@/components/PublicFooter.vue';
import PublicHeader from '@/components/PublicHeader.vue';
import { register } from '@/routes';

interface Category {
    id: number;
    name: string;
}

interface Organization {
    id: number;
    name: string;
    slug: string;
    logo?: string;
    cover_image?: string;
    short_description?: string;
    description?: string;
    city?: string;
    categories?: Category[];
}

withDefaults(
    defineProps<{
        canRegister?: boolean;
        organizations?: Organization[];
    }>(),
    {
        canRegister: true,
        organizations: () => [],
    },
);

const stats = [
    { id: 1, name: 'Organisations Actives', value: '150+', icon: UsersIcon },
    { id: 2, name: 'Projets Réalisés', value: '450+', icon: GlobeIcon },
    { id: 3, name: 'Bénévoles Engagés', value: '2.5k', icon: HeartHandshakeIcon },
    { id: 4, name: 'Villes Couvertes', value: '24', icon: ShieldCheckIcon },
];

const features = [
    {
        name: 'Visibilité Accrue',
        description: 'Mettez en avant vos actions et projets auprès d\'un large public et de partenaires potentiels.',
        icon: ZapIcon,
        color: 'text-amber-500',
        bg: 'bg-amber-500/10'
    },
    {
        name: 'Réseautage Stratégique',
        description: 'Connectez-vous avec d\'autres OSC pour collaborer sur des initiatives communes.',
        icon: MessageSquareIcon,
        color: 'text-blue-500',
        bg: 'bg-blue-500/10'
    },
    {
        name: 'Gestion Simplifiée',
        description: 'Utilisez nos outils intégrés pour gérer votre profil, vos membres et vos rapports d\'activités.',
        icon: TrophyIcon,
        color: 'text-emerald-500',
        bg: 'bg-emerald-500/10'
    }
];
</script>

<template>
    <Head title="RAOSC - Réseau des Associations et ONG" />
    <div class="min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans selection:bg-emerald-500/30 overflow-x-hidden">
        
        <!-- En-tête Public -->
        <PublicHeader :user="$page.props.auth.user" :can-register="canRegister" />

        <main class="flex-grow">
            <!-- Hero Slider -->
            <HeroSlider :user="$page.props.auth.user" />

            <!-- Stats Section -->
            <div class="relative z-20 -mt-16 mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 bg-white dark:bg-zinc-900 p-8 rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-800">
                    <div v-for="stat in stats" :key="stat.id" class="text-center group">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-500/10 mb-3 group-hover:scale-110 transition-transform">
                            <component :is="stat.icon" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <dt class="text-sm font-medium leading-6 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ stat.name }}</dt>
                        <dd class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ stat.value }}</dd>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-24 sm:py-32 relative">
                <!-- Background Decoration -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 pointer-events-none overflow-hidden">
                    <div class="absolute top-1/2 left-0 w-72 h-72 bg-emerald-500/5 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
                </div>

                <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
                    <div class="mx-auto max-w-2xl">
                        <h2 class="text-base font-semibold leading-7 text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Pourquoi nous rejoindre ?</h2>
                        <p class="mt-2 text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                            Une plateforme dédiée à <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-blue-600">votre impact social</span>
                        </p>
                        <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                            Le RAOSC offre des outils modernes pour amplifier la voix de la société civile et faciliter la synergie entre les acteurs du développement.
                        </p>
                    </div>

                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                            <div v-for="feature in features" :key="feature.name" class="flex flex-col items-center bg-white dark:bg-zinc-900/50 p-8 rounded-2xl border border-zinc-100 dark:border-zinc-800 transition-all hover:shadow-lg hover:-translate-y-1">
                                <dt class="text-base font-bold leading-7 text-zinc-900 dark:text-white flex flex-col items-center">
                                    <div :class="['mb-6 flex h-16 w-16 items-center justify-center rounded-xl shadow-inner', feature.bg]">
                                        <component :is="feature.icon" :class="['h-8 w-8', feature.color]" aria-hidden="true" />
                                    </div>
                                    {{ feature.name }}
                                </dt>
                                <dd class="mt-4 text-center leading-7 text-zinc-600 dark:text-zinc-400">
                                    {{ feature.description }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Section d'affichages des associations -->
            <div class="bg-zinc-100/50 dark:bg-zinc-900/20 py-24 sm:py-32 border-y border-zinc-200 dark:border-zinc-800/50">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                        <div class="max-w-2xl">
                            <h2 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-4xl">Organisations à la une</h2>
                            <p class="mt-4 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Découvrez les associations et ONG récemment ajoutées sur notre réseau coopératif.</p>
                        </div>
                        <Link href="/rao" class="text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-2 hover:gap-3 transition-all group" prefetch>
                            Voir tout l'annuaire <ArrowRightIcon class="h-4 w-4" />
                        </Link>
                    </div>
                    
                    <div class="mx-auto mt-12 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-12 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        <OrganizationCard 
                            v-for="org in organizations" 
                            :key="org.id" 
                            :org="org" 
                        />
                    </div>

                    <div v-if="!organizations || organizations.length === 0" class="mt-20 py-24 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-3xl bg-white/50 dark:bg-zinc-900/50">
                        <div class="mx-auto h-20 w-20 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-6">
                            <BuildingIcon class="h-10 w-10 text-zinc-400" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Aucune organisation pour le moment</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 mt-2 max-w-xs mx-auto">Nous préparons l'arrivée des premières associations partenaires.</p>
                        <Link href="/rao" class="text-emerald-600 dark:text-emerald-400 mt-6 inline-block font-semibold" prefetch>Voir tout de même la liste →</Link>
                    </div>
                </div>
            </div>

            <!-- Global CTA Section -->
            <div class="py-24 sm:py-32 overflow-hidden relative">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="relative isolate overflow-hidden bg-emerald-700 px-6 py-24 shadow-2xl rounded-3xl sm:px-24 xl:py-32">
                        <h2 class="mx-auto max-w-2xl text-center text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            Faites passer votre organisation au niveau supérieur.
                        </h2>
                        <p class="mx-auto mt-6 max-w-xl text-center text-lg leading-8 text-emerald-100">
                            Rejoignez la plus grande communauté numérique des OSC et bénéficiez d'une visibilité nationale pour vos projets.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <Link 
                                v-if="!$page.props.auth.user"
                                :href="register()" 
                                class="rounded-full bg-white px-8 py-4 text-sm font-bold text-emerald-700 shadow-sm hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all transform hover:scale-105"
                                prefetch
                            >
                                Inscrire mon organisation
                            </Link>
                            <Link href="/about" class="text-sm font-semibold leading-6 text-white hover:text-emerald-200 transition-colors" prefetch>
                                En savoir plus <span aria-hidden="true">→</span>
                            </Link>
                        </div>
                        
                        <!-- Abstract Background Decoration -->
                        <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]" aria-hidden="true">
                            <circle cx="512" cy="512" r="512" fill="url(#gradient)" fill-opacity="0.3" />
                            <defs>
                                <radialGradient id="gradient">
                                    <stop stop-color="white" />
                                    <stop offset="1" stop-color="#10b981" />
                                </radialGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </main>

        <!-- Pied de page Public -->
        <PublicFooter />
    </div>
</template>
