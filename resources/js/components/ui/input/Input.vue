<!-- components/ui/input/Input.vue -->
<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { useVModel } from "@vueuse/core"
import { cn } from "@/lib/utils"

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes["class"]
}>()

const emits = defineEmits<{
  (e: "update:modelValue", payload: string | number): void
}>()

const modelValue = useVModel(props, "modelValue", emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <input
    v-model="modelValue"
    data-slot="input"
    :class="cn(
      'w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-base text-zinc-900 placeholder:text-zinc-400',
      'transition-all duration-200 ease-in-out',
      'hover:border-zinc-300 hover:bg-zinc-50/50',
      'focus:border-raosc-green focus:outline-none focus:ring-2 focus:ring-raosc-green/20 focus:bg-white',
      'disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-zinc-50',
      'dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500',
      'dark:hover:border-zinc-600 dark:hover:bg-zinc-900/50',
      'dark:focus:border-raosc-green dark:focus:ring-raosc-green/20',
      props.class,
    )"
  >
</template>