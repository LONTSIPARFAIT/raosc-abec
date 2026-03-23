<script setup lang="ts">
import { computed } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';

type Props = {
    user: User;
    showEmail?: boolean;
    compact?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
    showEmail: false,
    compact: false,
});

const { getInitials } = useInitials();

// Determine if we should show the avatar image
const showAvatar = computed(() => !!props.user.avatar);
</script>

<template>
    <div :class="[!compact ? 'flex items-center gap-3' : 'inline-flex']">
        
        <Avatar 
            :class="[
                'overflow-hidden bg-zinc-100 dark:bg-zinc-800',
                compact ? 'h-6 w-6' : 'h-8 w-8',
                compact ? 'rounded-full' : 'rounded-full'
            ]"
        >
            <AvatarImage 
                v-if="showAvatar" 
                :src="user.avatar!" 
                :alt="user.name" 
                class="object-cover"
            />
            <AvatarFallback 
                :class="[
                    'flex items-center justify-center text-xs font-medium',
                    compact ? 'text-[10px]' : 'text-xs',
                    'text-zinc-700 dark:text-zinc-300'
                ]"
            >
                {{ getInitials(user.name) }}
            </AvatarFallback>
        </Avatar>
        <div v-if="!compact" class="grid flex-1 text-left text-sm leading-tight">
            <span class="truncate font-semibold text-zinc-900 dark:text-white">{{ user.name }}</span>
            <span v-if="showEmail" class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                {{ user.email }}
            </span>
        </div>
    </div>
</template>