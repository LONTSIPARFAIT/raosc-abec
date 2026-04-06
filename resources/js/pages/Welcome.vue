<!-- WelcomePage.vue (le composant principal simplifié) -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Users, Globe, Heart, ShieldCheck, Zap, MessageSquare, Trophy } from 'lucide-vue-next';
import CategoriesSection from '@/components/CategoriesSection.vue';
import CTASection from '@/components/CTASection.vue';
import FeaturesSection from '@/components/FeaturesSection.vue';
import HeroSlider from '@/components/HeroSlider.vue';
import OrganizationsSection from '@/components/OrganizationsSection.vue';
import StatsSection from '@/components/StatsSection.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

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
    country?: string;
    categories?: Category[];
}

const props = withDefaults(
    defineProps<{
        canRegister?: boolean;
        organizations?: Organization[];
        stats?: {
            organizations_count: number;
            categories_count: number;
            projects_count: number;
            countries_count: number;
        };
    }>(),
    {
        canRegister: true,
        organizations: () => [],
        stats: () => ({
            organizations_count: 0,
            categories_count: 0,
            projects_count: 0,
            countries_count: 0,
        }),
    },
);

const resolvedStats = [
    { id: 1, name: 'Organisations Approuvées', value: props.stats?.organizations_count + '+', icon: Users, color: 'text-raosc-green', bg: 'bg-raosc-green/10' },
    { id: 2, name: 'Domaines d\'Action', value: props.stats?.categories_count + '', icon: Trophy, color: 'text-raosc-yellow', bg: 'bg-raosc-yellow/10' },
    { id: 3, name: 'Projets Actifs', value: props.stats?.projects_count + '', icon: Globe, color: 'text-raosc-red', bg: 'bg-raosc-red/10' },
    { id: 4, name: 'Pays Couverts', value: props.stats?.countries_count + '', icon: ShieldCheck, color: 'text-zinc-600', bg: 'bg-zinc-100 dark:bg-zinc-800' },
];

const features = [
    {
        name: 'Visibilité Accrue',
        description: 'Amplifiez votre voix et vos actions auprès des bailleurs et du grand public à travers notre annuaire.',
        icon: Zap,
        color: 'text-raosc-green',
        bg: 'bg-raosc-green/10'
    },
    {
        name: 'Synergie Locale',
        description: 'Identifiez des partenaires stratégiques nationaux et régionaux pour des projets à fort impact social.',
        icon: MessageSquare,
        color: 'text-raosc-yellow',
        bg: 'bg-raosc-yellow/10'
    },
    {
        name: 'Excellence Opérationnelle',
        description: 'Accédez à des ressources et outils de gestion modernes pour professionnaliser votre structure.',
        icon: Trophy,
        color: 'text-raosc-red',
        bg: 'bg-raosc-red/10'
    }
];
</script>

<template>
    <PublicLayout>
        <Head title="Bienvenue sur RAOSC - Réseau Africain des Organisations de la Société Civile" />

        <HeroSlider :user="$page.props.auth.user" />

        <StatsSection :stats="resolvedStats" />

        <FeaturesSection :features="features" />

        <CategoriesSection />

        <OrganizationsSection :organizations="organizations" />

        <!-- Actualités Récentes -->
        <section class="py-16 sm:py-24 bg-zinc-50 dark:bg-zinc-950 border-t border-zinc-100 dark:border-zinc-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center md:text-left mb-12">
                    <h2 class="text-3xl font-black text-zinc-900 dark:text-white mb-4 uppercase tracking-tighter">Actualités <span class="text-raosc-green">Récentes</span></h2>
                    <p class="text-zinc-500 font-medium max-w-2xl">Découvrez les dernières avancées, événements et succès des organisations membres de notre réseau.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Article 1 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-lg shadow-zinc-200/50 dark:shadow-none hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="h-48 bg-zinc-200 dark:bg-zinc-800 w-full relative">
                            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover" alt="Actualité 1" />
                            <div class="absolute top-4 left-4 bg-raosc-green text-white text-[10px] font-bold px-3 py-1 rounded-full">Solidarité</div>
                        </div>
                        <div class="p-6">
                            <p class="text-[10px] font-bold text-zinc-400 mb-2 uppercase tracking-widest">Le 04 Avril 2026</p>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 hover:text-raosc-green cursor-pointer">Lancement du programme d'accès à l'eau potable en zone rurale</h3>
                            <p class="text-sm text-zinc-500 line-clamp-3 mb-6">De nombreuses ONG se sont réunies pour initier ce grand projet visant à fournir de l'eau potable à plus de 50 villages...</p>
                            <a href="#" class="text-raosc-green font-semibold text-sm hover:underline">Lire la suite &rarr;</a>
                        </div>
                    </div>
                    <!-- Article 2 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-lg shadow-zinc-200/50 dark:shadow-none hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="h-48 bg-zinc-200 dark:bg-zinc-800 w-full relative">
                            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover" alt="Actualité 2" />
                            <div class="absolute top-4 left-4 bg-raosc-yellow text-zinc-900 text-[10px] font-bold px-3 py-1 rounded-full">Éducation</div>
                        </div>
                        <div class="p-6">
                            <p class="text-[10px] font-bold text-zinc-400 mb-2 uppercase tracking-widest">Le 02 Avril 2026</p>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 hover:text-raosc-yellow cursor-pointer">Nouvelle convention de partenariat pour la scolarisation des jeunes filles</h3>
                            <p class="text-sm text-zinc-500 line-clamp-3 mb-6">Un accord historique a été signé aujourd'hui pour soutenir financièrement les familles et encourager la scolarisation continuelle des jeunes filles.</p>
                            <a href="#" class="text-raosc-yellow font-semibold text-sm hover:underline">Lire la suite &rarr;</a>
                        </div>
                    </div>
                    <!-- Article 3 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-lg shadow-zinc-200/50 dark:shadow-none hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="h-48 bg-zinc-200 dark:bg-zinc-800 w-full relative">
                            <img src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover" alt="Actualité 3" />
                            <div class="absolute top-4 left-4 bg-raosc-red text-white text-[10px] font-bold px-3 py-1 rounded-full">Santé</div>
                        </div>
                        <div class="p-6">
                            <p class="text-[10px] font-bold text-zinc-400 mb-2 uppercase tracking-widest">Le 30 Mars 2026</p>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-3 line-clamp-2 hover:text-raosc-red cursor-pointer">Campagne de vaccination gratuite et de prévention communautaire</h3>
                            <p class="text-sm text-zinc-500 line-clamp-3 mb-6">Les équipes médicales bénévoles se déploient dans plusieurs régions pour des consultations gratuites et de la prévention médicale.</p>
                            <a href="#" class="text-raosc-red font-semibold text-sm hover:underline">Lire la suite &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <CTASection :is-authenticated="!!$page.props.auth.user" />
    </PublicLayout>
</template>
