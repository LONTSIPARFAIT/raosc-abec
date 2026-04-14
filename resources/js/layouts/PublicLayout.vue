<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import PublicFooter from '@/components/PublicFooter.vue';
import PublicHeader from '@/components/PublicHeader.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);

// Prop optionnelle pour l'image d'arrière-plan
defineProps<{
    backgroundImage?: string;
    overlayOpacity?: number; // 0 à 1, défaut 0.4
}>();
</script>

<template>
    <div
        class="min-h-screen flex flex-col font-sans selection:bg-raosc-green/30 overflow-x-hidden relative"
        :style="backgroundImage ? `background-image: url('${backgroundImage}'); background-size: contain; background-position: center; background-repeat: no-repeat;` : ''"
        :class="{ 'bg-zinc-50 dark:bg-zinc-950': !backgroundImage }"
    >
        <!-- Overlay conditionnel -->
        <div v-if="backgroundImage" class="absolute inset-0" :style="`background-color: rgba(0,0,0,${overlayOpacity || 0.4});`"></div>

        <div class="relative z-10 flex flex-col min-h-screen">
            <PublicHeader :user="user" />

            <main class="flex-grow pt-20 sm:pt-24">
                <slot />
            </main>

            <PublicFooter />
        </div>
    </div>
</template>
