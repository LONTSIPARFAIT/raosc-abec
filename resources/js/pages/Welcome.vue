<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { 
    Users, 
    Globe, 
    Heart, 
    ShieldCheck,
    Zap,
    MessageSquare,
    Trophy,
    Building2,
    ArrowRight
} from 'lucide-vue-next';
import HeroSlider from '@/components/HeroSlider.vue';
import OrganizationCard from '@/components/OrganizationCard.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
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

const featuredCategories = [
    { name: 'Éducation', icon: '🎓', count: '45+' },
    { name: 'Santé', icon: '🏥', count: '32+' },
    { name: 'Environnement', icon: '🌱', count: '28+' },
    { name: 'Droits de l\'Homme', icon: '⚖️', count: '19+' },
    { name: 'Développement', icon: '🏗️', count: '54+' },
    { name: 'Jeunesse', icon: '🙌', count: '37+' },
];
</script>

<template>
    <PublicLayout>
        <Head title="Bienvenue sur RAOSC - Réseau Africain de la Société Civile" />
        
        <!-- Hero Section (unchanged) -->
        <HeroSlider :user="$page.props.auth.user" />

        <!-- Stats Section -->
        <div class="bg-white dark:bg-zinc-950 border-b border-zinc-100 dark:border-zinc-800">
            <div class="mx-auto max-w-7xl px-3 py-8 sm:py-12">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <div v-for="stat in stats" :key="stat.id" class="text-center group">
                        <div :class="['mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4 transition-transform group-hover:scale-105', stat.bg]">
                            <component :is="stat.icon" :class="['h-6 w-6', stat.color]" />
                        </div>
                        <dd class="text-3xl font-extrabold text-zinc-900 dark:text-white mb-1">{{ stat.value }}</dd>
                        <dt class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ stat.name }}</dt>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 sm:py-20 bg-zinc-50/50 dark:bg-zinc-900/20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span class="text-raosc-green text-xs font-semibold tracking-[0.2em] uppercase bg-raosc-green/10 px-4 py-1.5 rounded-full mb-4 inline-block">Pourquoi rejoindre le réseau ?</span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-6">
                        Des outils pour transformer votre <span class="text-raosc-yellow">engagement</span>
                    </h2>
                    <p class="text-zinc-600 dark:text-zinc-400 text-base sm:text-lg leading-relaxed">
                        Le RAOSC offre un écosystème complet pour aider les associations africaines à gagner en crédibilité et en efficacité.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="feature in features" :key="feature.name" 
                         class="group bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-raosc-green/20 transition-all duration-200">
                        <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-6 group-hover:scale-105 transition-transform', feature.bg]">
                            <component :is="feature.icon" :class="['w-6 h-6', feature.color]" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">{{ feature.name }}</h3>
                        <p class="text-sm text-zinc-500 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="py-12 sm:py-20 bg-white dark:bg-zinc-950">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">
                            Parcourir par <span class="text-raosc-green">catégorie</span>
                        </h2>
                        <p class="text-sm text-zinc-500 mt-1">Trouvez les organisations qui correspondent à vos intérêts.</p>
                    </div>
                    <Link href="/rao" class="inline-flex items-center gap-2 text-xs font-semibold text-raosc-green hover:text-raosc-green/80 transition-colors bg-raosc-green/10 px-5 py-2.5 rounded-full border border-raosc-green/20 hover:border-raosc-green/30">
                        Voir toutes les catégories
                        <ArrowRight class="w-4 h-4" />
                    </Link>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                    <Link 
                        v-for="cat in featuredCategories" 
                        :key="cat.name" 
                        :href="`/rao?category=${cat.name.toLowerCase()}`"
                        class="group flex flex-col items-center p-6 bg-zinc-50 dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 hover:border-raosc-green/30 hover:shadow-md transition-all duration-200"
                    >
                        <span class="text-3xl mb-4 group-hover:scale-110 transition-transform duration-200">{{ cat.icon }}</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white tracking-tight">{{ cat.name }}</span>
                        <span class="text-[10px] font-medium text-raosc-green mt-2 bg-raosc-green/10 px-2.5 py-1 rounded-full">{{ cat.count }}</span>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Featured Organizations -->
        <div class="py-12 sm:py-20 bg-zinc-50/30 dark:bg-zinc-900/10">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-12">
                    <div class="max-w-2xl">
                        <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white mb-3 tracking-tight">
                            Organisations à la <span class="text-raosc-green">une</span>
                        </h2>
                        <p class="text-zinc-500 text-sm font-medium border-l-2 border-raosc-yellow pl-5 py-1">
                            Découvrez les membres actifs qui œuvrent quotidiennement pour le changement.
                        </p>
                    </div>
                    <Link href="/rao" class="inline-flex items-center gap-2 text-sm font-semibold text-raosc-green hover:text-raosc-green/80 transition-colors bg-raosc-green/10 px-5 py-2.5 rounded-full border border-raosc-green/20 hover:border-raosc-green/30">
                        Voir tout l'annuaire
                        <ArrowRight class="w-4 h-4" />
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <OrganizationCard 
                        v-for="org in organizations" 
                        :key="org.id" 
                        :org="org" 
                    />
                </div>

                <div v-if="!organizations || organizations.length === 0" class="py-24 text-center bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                    <Building2 class="w-12 h-12 text-zinc-300 dark:text-zinc-600 mx-auto mb-4" />
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Bientôt disponible</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">La liste des organisations est en cours de mise à jour.</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-zinc-950 py-12 sm:py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#0f2c1f] to-[#1a3a2a] dark:from-[#0a1f15] dark:to-[#0f2c1f] p-12 sm:p-20 text-center shadow-lg">
                    <div class="absolute top-0 right-0 w-72 h-72 bg-raosc-green/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-72 h-72 bg-raosc-yellow/10 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <h2 class="text-3xl sm:text-5xl font-bold text-white mb-6 max-w-3xl mx-auto leading-tight">
                            Rejoignez la plus grande coalition d'ONG en <span class="text-raosc-yellow">Afrique</span>
                        </h2>
                        <p class="text-white/70 text-base sm:text-lg max-w-2xl mx-auto mb-10">
                            Inscrivez votre organisation gratuitement et devenez un acteur clé du réseau RAOSC.
                        </p>
                        <div class="flex flex-wrap justify-center gap-5">
                            <Link 
                                v-if="!$page.props.auth.user"
                                :href="register()" 
                                class="inline-flex items-center gap-2 bg-white text-zinc-900 px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-white/90 transition-all shadow-md hover:-translate-y-0.5"
                                prefetch
                            >
                                S'inscrire maintenant
                                <ArrowRight class="w-4 h-4" />
                            </Link>
                            <Link href="/contact" class="inline-flex items-center gap-2 text-white font-semibold text-sm bg-white/10 hover:bg-white/20 px-8 py-3.5 rounded-xl transition-all border border-white/20">
                                En savoir plus
                                <ArrowRight class="w-4 h-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>