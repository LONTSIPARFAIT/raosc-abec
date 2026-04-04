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
    { id: 1, name: 'Organisations', value: '150+', icon: Users, color: 'text-raosc-green', bg: 'bg-raosc-green/10' },
    { id: 2, name: 'Projets Active', value: '450+', icon: Globe, color: 'text-raosc-yellow', bg: 'bg-raosc-yellow/10' },
    { id: 3, name: 'Bénévoles', value: '2.5k', icon: Heart, color: 'text-raosc-red', bg: 'bg-raosc-red/10' },
    { id: 4, name: 'Villes', value: '24', icon: ShieldCheck, color: 'text-zinc-400', bg: 'bg-zinc-100 dark:bg-zinc-800' },
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

        <StatsSection :stats="stats" />

        <FeaturesSection :features="features" />

        <CategoriesSection />

        <OrganizationsSection :organizations="organizations" />

        <CTASection :is-authenticated="!!$page.props.auth.user" />
    </PublicLayout>
</template>
