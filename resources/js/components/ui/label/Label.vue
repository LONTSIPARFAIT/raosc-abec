<!-- components/ui/label/Label.vue -->
<script setup lang="ts">
import type { LabelProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { reactiveOmit } from "@vueuse/core"
import { Label } from "reka-ui"
import { cn } from "@/lib/utils"

const props = defineProps<LabelProps & { class?: HTMLAttributes["class"] }>()

const delegatedProps = reactiveOmit(props, "class")
</script>

<template>
  <Label
    data-slot="label"
    v-bind="delegatedProps"
    :class="cn(
      'block text-sm font-semibold text-zinc-700 mb-1.5',
      'dark:text-zinc-300',
      props.class,
    )"
  >
    <slot />
  </Label>
</template>