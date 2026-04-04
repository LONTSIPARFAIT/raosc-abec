<!-- components/OrganizationsSection.vue -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Building2 } from 'lucide-vue-next';
import OrganizationCard from '@/components/OrganizationCard.vue';

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
    categories?: { id: number; name: string }[];
}

defineProps<{
    organizations: Organization[];
}>();
</script>

<template>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-5 sm:gap-6">
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
</template>
