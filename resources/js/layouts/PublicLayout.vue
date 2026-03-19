<script setup lang="ts">
import PublicHeader from '@/components/PublicHeader.vue';
import PublicFooter from '@/components/PublicFooter.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
</script>

<template>
    <div class="min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans selection:bg-raosc-green/30 overflow-x-hidden">
        <PublicHeader :user="user" />
        
        <main class="flex-grow pt-20 sm:pt-24">
            <slot />
        </main>

        <PublicFooter />
    </div>
</template>

<style>
/* Global Poppins Enforcement */
html, body, #app, *, .font-sans {
    font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
}
</style>

