<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { toUrl } from '@/lib/utils';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editProfile } from '@/routes/profile';
import { show } from '@/routes/two-factor';
import { edit as editPassword } from '@/routes/user-password';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profil',
        href: editProfile(),
    },
    {
        title: 'Mot de passe',
        href: editPassword(),
    },
    {
        title: 'Double authentification',
        href: show(),
    },
    {
        title: 'Apparence',
        href: editAppearance(),
    },
];

const { isCurrentOrParentUrl } = useCurrentUrl();
</script>

<template>
    <div class="px-4 py-6 lg:px-8">
        <Heading
            title="Paramètres"
            description="Gérez votre profil et les paramètres de votre compte"
        />

        <div class="flex flex-col lg:flex-row lg:gap-12">
            <aside class="w-full max-w-xl lg:w-56">
                <nav class="flex flex-col space-y-1" aria-label="Settings">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        variant="ghost"
                        :class="[
                            'w-full justify-start rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200',
                            isCurrentOrParentUrl(item.href)
                                ? 'bg-raosc-green/10 text-raosc-green hover:bg-raosc-green/20'
                                : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-raosc-green'
                        ]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" class="mr-2 h-4 w-4" />
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1">
                <section class="max-w-2xl space-y-6">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>