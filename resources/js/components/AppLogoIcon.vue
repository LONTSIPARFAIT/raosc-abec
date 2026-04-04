<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <img 
        src="/images/Logo_Raosc-removebg-preview.png" 
        alt="Logo RAOSC"
        :class="className"
        v-bind="$attrs"
    />
</template>