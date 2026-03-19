<script setup lang="ts">
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { Bell } from 'lucide-vue-next';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

const page = usePage();
const notifications = computed(() => page.props.auth.notifications || []);
const unreadCount = computed(() => page.props.auth.unread_notifications_count || 0);

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit'
  });
};
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger class="relative p-2 text-zinc-500 hover:text-[#008751] transition-colors focus:outline-none">
      <Bell class="h-5 w-5" />
      <span v-if="unreadCount > 0" class="absolute top-1.5 right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white border-2 border-white dark:border-zinc-950">
        {{ unreadCount }}
      </span>
    </DropdownMenuTrigger>
    <DropdownMenuContent class="w-80 rounded-xl" align="end">
      <DropdownMenuLabel class="font-bold">Notifications</DropdownMenuLabel>
      <DropdownMenuSeparator />
      <div v-if="notifications.length > 0" class="max-h-96 overflow-y-auto">
        <DropdownMenuItem v-for="notif in notifications" :key="notif.id" class="flex flex-col items-start p-4 gap-1 cursor-default">
          <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">{{ notif.data.message }}</p>
          <div class="flex justify-between w-full items-center mt-1">
             <span class="text-[10px] text-zinc-400 font-medium">{{ formatDate(notif.created_at) }}</span>
             <span v-if="!notif.read_at" class="h-1.5 w-1.5 rounded-full bg-[#008751]"></span>
          </div>
        </DropdownMenuItem>
      </div>
      <div v-else class="p-8 text-center">
        <Bell class="h-8 w-8 text-zinc-200 mx-auto mb-2" />
        <p class="text-xs text-zinc-500 font-medium">Aucune notification</p>
      </div>
      <DropdownMenuSeparator />
      <DropdownMenuItem as-child>
        <Link href="/notifications" class="w-full text-center text-xs font-bold text-[#008751] py-2 hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-colors">
          Voir tout
        </Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
