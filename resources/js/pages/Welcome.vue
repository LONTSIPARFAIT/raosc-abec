<!-- WelcomePage.vue - Version professionnelle révisée -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Users, Globe, ShieldCheck, Zap, MessageSquare, Trophy } from 'lucide-vue-next';
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
    { id: 2, name: "Domaines d'Action", value: props.stats?.categories_count + '', icon: Trophy, color: 'text-raosc-yellow', bg: 'bg-raosc-yellow/10' },
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

        <!-- Motif décoratif subtil -->
        <div class="fixed top-0 left-0 right-0 z-[0] pointer-events-none opacity-[0.02] dark:opacity-[0.04]" 
             style="background-image: radial-gradient(circle at 1px 1px, currentColor 1px, transparent 1px); background-size: 40px 40px;"></div>

        <div class="relative z-10">
            <HeroSlider :user="$page.props.auth.user" />

            <StatsSection :stats="resolvedStats" />

            <FeaturesSection :features="features" />

            <CategoriesSection />

            <OrganizationsSection :organizations="organizations" />

            <RecentNewsSection />

            <CTASection :is-authenticated="!!$page.props.auth.user" />
        </div>
    </PublicLayout>
</template>