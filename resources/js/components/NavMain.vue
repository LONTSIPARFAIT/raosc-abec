<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    title?: string;
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel v-if="title" class="text-[11px] font-bold text-zinc-400 dark:text-zinc-500 tracking-tight px-3 py-2">{{ title }}</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentUrl(item.href)"
                    :tooltip="item.title"
                    class="h-10 group/item"
                >
                    <Link :href="item.href" prefetch class="flex items-center gap-3">
                        <component :is="item.icon" class="h-4.5 w-4.5 text-zinc-500 dark:text-zinc-400 group-hover/item:text-[#008751] transition-colors" />
                        <span class="text-sm font-medium tracking-tight">{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
