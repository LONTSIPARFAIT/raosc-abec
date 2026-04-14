<!-- PublicLayout.vue -->
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import PublicFooter from '@/components/PublicFooter.vue';
import PublicHeader from '@/components/PublicHeader.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);

defineProps<{
    backgroundImage?: string;
    overlayOpacity?: number;
}>();
</script>

<template>
    <div
        class="min-h-screen flex flex-col font-sans selection:bg-raosc-green/30 overflow-x-hidden relative"
        :style="backgroundImage ? `background-image: url('${backgroundImage}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;` : ''"
        :class="{ 'bg-zinc-50 dark:bg-zinc-950': !backgroundImage }"
    >
        <div v-if="backgroundImage" class="absolute inset-0" :style="`background-color: rgba(0,0,0,${overlayOpacity || 0.4});`"></div>

        <!-- SVG décoratif en haut - PAS fixe, suit le scroll -->
        <div class="absolute top-0 left-0 right-0 z-0 pointer-events-none">
            <img
                src="/img-bg/header.svg"
                alt=""
                class="w-full"
                :style="{
                    width: '100%',
                    height: 'auto',
                    maxHeight: '150px',
                    objectFit: 'cover',
                    objectPosition: 'top',
                    opacity: '0.6'
                }"
            />
        </div>

        <div class="relative z-10 flex flex-col min-h-screen">
            <PublicHeader :user="user" />
            <main class="flex-grow pt-20 sm:pt-24">
                <slot />
            </main>
            <PublicFooter />
        </div>

        <!-- SVG décoratif en bas - PAS fixe, suit le scroll -->
        <div class="absolute bottom-0 left-0 right-0 z-0 pointer-events-none">
            <img
                src="/img-bg/footer.svg"
                alt=""
                class="w-full"
                :style="{
                    width: '100%',
                    height: 'auto',
                    maxHeight: '150px',
                    objectFit: 'cover',
                    objectPosition: 'bottom',
                    opacity: '0.6',
                    transform: 'rotate(180deg)'
                }"
            />
        </div>
    </div>
</template>
