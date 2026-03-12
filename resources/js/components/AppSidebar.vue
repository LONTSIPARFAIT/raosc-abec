<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { 
    BookOpen, 
    FolderGit2, 
    LayoutGrid, 
    Home, 
    Users, 
    MessageSquare, 
    Bell, 
    Globe, 
    Building2, 
    Newspaper,
    Settings2
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Accueil',
        href: '/',
        icon: Home,
    },
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const raoNavItems: NavItem[] = [
    {
        title: 'Annuaire OSC',
        href: '/rao',
        icon: Globe,
    },
    {
        title: 'Ma Structure',
        href: '/rao/join',
        icon: Building2,
    },
    {
        title: 'Communauté',
        href: '/community',
        icon: Users,
    },
    {
        title: 'Actualités',
        href: '/posts',
        icon: Newspaper,
    },
];

const personalNavItems: NavItem[] = [
    {
        title: 'Messages',
        href: '/messages',
        icon: MessageSquare,
    },
    {
        title: 'Notifications',
        href: '/notifications',
        icon: Bell,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Paramètres',
        href: '/settings/profile',
        icon: Settings2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain title="Navigation" :items="mainNavItems" />
            <NavMain title="Réseau" :items="raoNavItems" />
            <NavMain title="Personnel" :items="personalNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
