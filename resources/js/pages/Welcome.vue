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
    { id: 1, name: 'Organisations', value: '150+', icon: Users, color: 'text-[#008751]', bg: 'bg-[#008751]/10' },
    { id: 2, name: 'Projets Active', value: '450+', icon: Globe, color: 'text-[#FFCB05]', bg: 'bg-[#FFCB05]/10' },
    { id: 3, name: 'Bénévoles', value: '2.5k', icon: Heart, color: 'text-[#E4002B]', bg: 'bg-[#E4002B]/10' },
    { id: 4, name: 'Villes', value: '24', icon: ShieldCheck, color: 'text-zinc-400', bg: 'bg-zinc-100 dark:bg-zinc-800' },
];

const features = [
    {
        name: 'Visibilité Accrue',
        description: 'Amplifiez votre voix et vos actions auprès des bailleurs et du grand public à travers notre annuaire.',
        icon: Zap,
        color: 'text-[#008751]',
        bg: 'bg-[#008751]/10'
    },
    {
        name: 'Synergie Locale',
        description: 'Identifiez des partenaires stratégiques nationaux et régionaux pour des projets à fort impact social.',
        icon: MessageSquare,
        color: 'text-[#FFCB05]',
        bg: 'bg-[#FFCB05]/10'
    },
    {
        name: 'Excellence Opérationnelle',
        description: 'Accédez à des ressources et outils de gestion modernes pour professionnaliser votre structure.',
        icon: Trophy,
        color: 'text-[#E4002B]',
        bg: 'bg-[#E4002B]/10'
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
        
        <!-- Hero Section -->
        <HeroSlider :user="$page.props.auth.user" />

        <!-- Stats Section -->
        <div class="bg-white dark:bg-zinc-950 border-b border-zinc-100 dark:border-zinc-800">
            <div class="mx-auto max-w-7xl px-6 py-12 sm:py-20">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <div v-for="stat in stats" :key="stat.id" class="text-center group">
                        <div :class="['mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4 transition-transform group-hover:scale-110 shadow-inner', stat.bg]">
                            <component :is="stat.icon" :class="['h-6 w-6', stat.color]" />
                        </div>
                        <dd class="text-3xl font-extrabold text-zinc-900 dark:text-white mb-1">{{ stat.value }}</dd>
                        <dt class="text-[11px] font-bold text-zinc-400 tracking-tight">{{ stat.name }}</dt>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-24 sm:py-32 bg-zinc-50 dark:bg-zinc-900/30">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <h2 class="text-[#008751] font-bold text-[10px] tracking-[0.2em] mb-4">Pourquoi rejoindre le réseau ?</h2>
                    <h3 class="text-3xl sm:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-6 leading-none">
                        Des outils pour transformer votre <span class="text-[#FFCB05]">engagement</span>
                    </h3>
                    <p class="text-zinc-600 dark:text-zinc-400 text-base sm:text-lg">
                        Le RAOSC offre un écosystème complet pour aider les associations africaines à gagner en crédibilité et en efficacité.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-24">
                    <div v-for="feature in features" :key="feature.name" class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all">
                        <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-6', feature.bg]">
                            <component :is="feature.icon" :class="['w-6 h-6', feature.color]" />
                        </div>
                        <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-4">{{ feature.name }}</h4>
                        <p class="text-sm text-zinc-500 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>

                <!-- Featured Categories Grid -->
                <div class="bg-white dark:bg-zinc-900/50 rounded-[3rem] p-8 sm:p-16 border border-zinc-200 dark:border-zinc-800 shadow-xl shadow-zinc-200/50 dark:shadow-none">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12 text-center md:text-left">
                        <div>
                            <h4 class="text-2xl font-bold text-zinc-900 dark:text-white tracking-tight">Parcourir par <span class="text-[#008751]">Catégorie</span></h4>
                            <p class="text-[13px] font-medium text-zinc-500 mt-1">Trouvez les organisations qui correspondent à vos intérêts.</p>
                        </div>
                        <Link href="/rao" class="text-[10px] font-bold text-[#008751] hover:text-[#006b40] transition-colors bg-[#008751]/10 px-6 py-2.5 rounded-xl border border-[#008751]/10">Voir toutes les catégories</Link>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                        <Link 
                            v-for="cat in featuredCategories" 
                            :key="cat.name" 
                            :href="`/rao?category=${cat.name.toLowerCase()}`"
                            class="group flex flex-col items-center p-6 bg-zinc-50 dark:bg-zinc-950 rounded-3xl border border-zinc-100 dark:border-zinc-800 hover:border-[#008751]/30 transition-all hover:bg-white dark:hover:bg-zinc-900 hover:shadow-2xl hover:shadow-[#008751]/10"
                        >
                            <span class="text-3xl mb-4 group-hover:scale-125 transition-transform duration-500">{{ cat.icon }}</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white tracking-tight">{{ cat.name }}</span>
                            <span class="text-[9px] font-bold text-[#008751] mt-2 bg-[#008751]/10 px-2.5 py-1 rounded-lg border border-[#008751]/10">{{ cat.count }}</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Organizations -->
        <div class="py-24 sm:py-32 bg-white dark:bg-zinc-950">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-16">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-4 tracking-tight">Organisations à la <span class="text-[#008751]">Une</span></h2>
                        <p class="text-zinc-500 text-sm font-medium border-l-3 border-[#FFCB05] pl-5 py-1">Découvrez les membres actifs qui œuvrent quotidiennement pour le changement.</p>
                    </div>
                    <Link href="/rao" class="text-xs font-bold text-[#008751] hover:text-[#006b40] flex items-center gap-2 bg-[#008751]/5 px-5 py-2.5 rounded-xl transition-all hover:-translate-y-0.5">
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

                <div v-if="!organizations || organizations.length === 0" class="py-24 text-center bg-zinc-50 dark:bg-zinc-900 rounded-[2.5rem] border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                    <Building2 class="w-12 h-12 text-zinc-300 mx-auto mb-4" />
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Bientôt disponible</h3>
                    <p class="text-sm text-zinc-500 mt-2">La liste des organisations est en cours de mise à jour.</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-zinc-950 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="bg-[#310808] rounded-[3rem] p-12 sm:p-20 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#008751] opacity-10 rounded-full blur-[80px]"></div>
                    <div class="relative z-10">
                        <h2 class="text-3xl sm:text-5xl font-bold text-white mb-8 max-w-3xl mx-auto">
                            Rejoignez la plus grande coalition d'ONG en <span class="text-[#FFCB05]">Afrique</span>
                        </h2>
                        <p class="text-zinc-400 text-sm sm:text-lg max-w-2xl mx-auto mb-12">
                            Inscrivez votre organisation gratuitement et devenez un acteur clé du réseau RAOSC.
                        </p>
                        <div class="flex flex-wrap justify-center gap-6">
                            <Link 
                                v-if="!$page.props.auth.user"
                                :href="register()" 
                                class="bg-[#008751] text-white px-10 py-4.5 rounded-2xl font-bold text-sm hover:bg-[#006b40] transition-all shadow-xl shadow-[#008751]/20 hover:-translate-y-1"
                                prefetch
                            >
                                S'inscrire maintenant
                            </Link>
                            <Link href="/contact" class="flex items-center gap-2 text-white font-bold text-sm bg-white/5 hover:bg-white/10 px-8 py-4 rounded-2xl transition-all border border-white/5 tracking-tight">
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
