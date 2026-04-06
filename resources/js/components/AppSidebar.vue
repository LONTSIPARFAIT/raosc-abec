<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { 
    BookOpen, 
    LayoutGrid, 
    Home, 
    Users, 
    MessageSquare, 
    Bell, 
    Globe, 
    Building2, 
    Newspaper,
    Settings2,
    PlusCircle,
    ShieldCheck,
    Briefcase
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
        title: 'Tableau de bord',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Mes Structures',
        href: '/rao/mes-structures',
        icon: Building2,
    },
    {
        title: 'Projets & Bénévolats',
        href: '/dashboard/projects',
        icon: Briefcase,
    },
    {
        title: 'Inscrire une OSC',
        href: '/rao/join',
        icon: PlusCircle,
    },
];

const adminNavItems: NavItem[] = [
    {
        title: 'Validation OSC',
        href: '/admin/organizations',
        icon: ShieldCheck,
    },
    {
        title: 'Gestion Utilisateurs',
        href: '/admin/users',
        icon: Users,
    },
    {
        title: 'Paramètres du site',
        href: '/admin/settings',
        icon: Settings2,
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
        href: '/dashboard/notifications',
        icon: Bell,
    },
];

// const footerNavItems: NavItem[] = [
//     {
//         title: 'Paramètres',
//         href: '/settings/profile',
//         icon: Settings2,
//     },
//     {
//         title: 'Documentation',
//         href: 'https://laravel.com/docs',
//         icon: BookOpen,
//     },
// ];
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
            <NavMain v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'" title="Administration" :items="adminNavItems" />
            <NavMain title="Personnel" :items="personalNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <!-- <NavFooter :items="footerNavItems" /> -->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

