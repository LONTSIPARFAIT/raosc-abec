<!-- components/PasswordInput.vue -->
<script setup lang="ts">
import { Eye, EyeOff } from 'lucide-vue-next';
import { ref, useTemplateRef } from 'vue';
import type { HTMLAttributes } from 'vue';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();

const showPassword = ref(false);
const inputRef = useTemplateRef('inputRef');

defineExpose({
    $el: inputRef,
    focus: () => inputRef.value?.$el?.focus(),
});
</script>

<template>
    <div class="relative">
        <Input
            ref="inputRef"
            :type="showPassword ? 'text' : 'password'"
            :class="cn('pr-11', props.class)"
            v-bind="$attrs"
        />
        <button
            type="button"
            @click="showPassword = !showPassword"
            :class="cn(
                'absolute inset-y-0 right-0 flex items-center rounded-r-xl px-3 text-zinc-400',
                'hover:text-raosc-green transition-colors duration-200',
                'focus:outline-none focus:text-raosc-green',
            )"
            :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
            :tabindex="-1"
        >
            <EyeOff v-if="showPassword" class="size-4" />
            <Eye v-else class="size-4" />
        </button>
    </div>
</template>