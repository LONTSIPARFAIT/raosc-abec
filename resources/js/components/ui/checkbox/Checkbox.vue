<!-- components/ui/checkbox/Checkbox.vue -->
<script setup lang="ts">
import type { CheckboxRootEmits, CheckboxRootProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { reactiveOmit } from "@vueuse/core"
import { Check } from "lucide-vue-next"
import { CheckboxIndicator, CheckboxRoot, useForwardPropsEmits } from "reka-ui"
import { cn } from "@/lib/utils"

const props = defineProps<CheckboxRootProps & { class?: HTMLAttributes["class"] }>()
const emits = defineEmits<CheckboxRootEmits>()

const delegatedProps = reactiveOmit(props, "class")
const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
  <CheckboxRoot
    v-slot="slotProps"
    data-slot="checkbox"
    v-bind="forwarded"
    :class="cn(
      'peer size-4 shrink-0 rounded-md border border-zinc-300 bg-white',
      'transition-all duration-200',
      'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-raosc-green/20 focus-visible:border-raosc-green',
      'disabled:cursor-not-allowed disabled:opacity-50',
      'data-[state=checked]:bg-raosc-green data-[state=checked]:border-raosc-green data-[state=checked]:text-white',
      'hover:border-raosc-green/50 hover:bg-raosc-green/5',
      'dark:border-zinc-600 dark:bg-zinc-900',
      'dark:data-[state=checked]:bg-raosc-green dark:data-[state=checked]:border-raosc-green',
      'dark:hover:border-raosc-green/50 dark:hover:bg-raosc-green/10',
      props.class
    )"
  >
    <CheckboxIndicator
      data-slot="checkbox-indicator"
      class="flex items-center justify-center text-current transition-none"
    >
      <slot v-bind="slotProps">
        <Check class="size-3.5" />
      </slot>
    </CheckboxIndicator>
  </CheckboxRoot>
</template>