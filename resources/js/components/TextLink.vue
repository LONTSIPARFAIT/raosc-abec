<!-- components/TextLink.vue -->
<script setup lang="ts">
import type { LinkComponentBaseProps, Method } from '@inertiajs/core';
import { Link } from '@inertiajs/vue3';

type Props = {
    href: LinkComponentBaseProps['href'];
    tabindex?: number | string;
    method?: Method;
    as?: string;
};

defineProps<Props>();
</script>

<template>
    <Link
        :href="href"
        :tabindex="tabindex"
        :method="method"
        :as="as"
        class="text-raosc-green font-medium transition-all duration-200 hover:text-raosc-green/80 hover:underline underline-offset-4"
    >
        <slot />
    </Link>
</template>