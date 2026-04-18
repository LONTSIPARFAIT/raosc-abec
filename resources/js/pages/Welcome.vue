<!-- WelcomePage.vue - Design optimisé 2026 -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Users, Globe, ShieldCheck, Zap, MessageSquare, Trophy, Sparkles } from 'lucide-vue-next';
import CategoriesSection from '@/components/CategoriesSection.vue';
import CTASection from '@/components/CTASection.vue';
import FeaturesSection from '@/components/FeaturesSection.vue';
import HeroSlider from '@/components/HeroSlider.vue';
import OrganizationsSection from '@/components/OrganizationsSection.vue';
import StatsSection from '@/components/StatsSection.vue';
import RecentNewsSection from '@/components/RecentNewsSection.vue';
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
        recentNews?: any[];
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
        recentNews: () => [],
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
    { id: 2, name: "Domaines d'Action", value: props.stats?.categories_count + '', icon: Trophy, color: 'text-raosc-yellow', bg: 'bg-raosc-yellow/10' },
    { id: 3, name: 'Projets Actifs', value: props.stats?.projects_count + '', icon: Globe, color: 'text-raosc-red', bg: 'bg-raosc-red/10' },
    { id: 4, name: 'Pays Couverts', value: props.stats?.countries_count + '', icon: ShieldCheck, color: 'text-zinc-600 dark:text-zinc-400', bg: 'bg-zinc-100 dark:bg-zinc-800' },
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

const backgroundImage = '/img-bg/bg-1.png';
const overlayOpacity = 0.35;
</script>

<template>
    <PublicLayout :backgroundImage="backgroundImage" :overlayOpacity="overlayOpacity">
        <Head title="Bienvenue sur RAOSC - Réseau Africain des Organisations de la Société Civile" />

        <!-- Motif décoratif amélioré -->
        <div class="fixed inset-0 z-[0] pointer-events-none opacity-[0.03] dark:opacity-[0.05]"
             style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 1px); background-size: 50px 50px;"></div>

        <!-- Effets de fond dynamiques -->
        <div class="fixed inset-0 pointer-events-none z-[0] opacity-30 dark:opacity-10">
            <div class="absolute top-20 left-10 w-96 h-96 bg-raosc-green rounded-full blur-[150px] animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-raosc-yellow rounded-full blur-[150px] animate-float-delay"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-raosc-brown rounded-full blur-[200px] opacity-50"></div>
        </div>

        <div class="relative z-10">
            <!-- Hero Section avec animation d'entrée -->
            <div class="animate-fade-in">
                <HeroSlider :user="$page.props.auth.user" />
            </div>

            <!-- Stats Section avec glassmorphism -->
            <div class="transform transition-all duration-500 hover:translate-y-[-4px]">
                <StatsSection :stats="resolvedStats" />
            </div>

            <!-- Recent News Section -->
            <div class="animate-on-scroll">
                <RecentNewsSection :news="recentNews" />
            </div>

            <!-- Features Section améliorée -->
            <div class="py-8 animate-on-scroll stagger-delay-1">
                <FeaturesSection :features="features" />
            </div>

            <!-- Categories Section -->
            <div class="animate-on-scroll stagger-delay-2">
                <CategoriesSection />
            </div>

            <!-- Organizations Section -->
            <div class="animate-on-scroll stagger-delay-3">
                <OrganizationsSection :organizations="organizations" />
            </div>

            <!-- CTA Section avec glassmorphism -->
            <div class="transform transition-all duration-500 hover:scale-[1.01]">
                <CTASection :is-authenticated="!!$page.props.auth.user" />
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
/* Animations d'entrée */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(20px, -20px) scale(1.1);
    }
}

@keyframes floatDelay {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(-20px, 20px) scale(1.1);
    }
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

.animate-float-delay {
    animation: floatDelay 10s ease-in-out infinite;
}

/* Animation au scroll */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeIn 0.8s ease-out forwards;
    animation-play-state: paused;
}

/* Stagger delays pour un effet cascade */
.stagger-delay-1 {
    animation-delay: 0.15s;
}

.stagger-delay-2 {
    animation-delay: 0.3s;
}

.stagger-delay-3 {
    animation-delay: 0.45s;
}

/* Activation des animations au scroll */
@media (prefers-reduced-motion: no-preference) {
    .animate-on-scroll {
        animation-play-state: running;
    }
}

/* Transition globale améliorée */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Effet de brillance au survol sur les sections */
.stats-card:hover,
.feature-card:hover,
.category-card:hover,
.organization-card:hover {
    transition: all 0.3s ease-out;
}
</style>