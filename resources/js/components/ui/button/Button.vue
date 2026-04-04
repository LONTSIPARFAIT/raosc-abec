<!-- components/ui/button/Button.vue -->
<script setup lang="ts">
import type { PrimitiveProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { Primitive } from "reka-ui"
import { cn } from "@/lib/utils"
import { buttonVariants } from "./index"

interface Props extends PrimitiveProps {
  variant?: "default" | "destructive" | "outline" | "secondary" | "ghost" | "link"
  size?: "default" | "sm" | "lg" | "icon"
  class?: HTMLAttributes["class"]
}

const props = withDefaults(defineProps<Props>(), {
  as: "button",
  variant: "default",
  size: "default",
})
</script>

<template>
  <Primitive
    data-slot="button"
    :as="as"
    :as-child="asChild"
    :class="cn(
      buttonVariants({ variant, size }),
      'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition-all duration-200',
      'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-raosc-green/20 focus-visible:ring-offset-2',
      'disabled:pointer-events-none disabled:opacity-50',
      'active:scale-[0.98]',
      props.class
    )"
  >
    <slot />
  </Primitive>
</template>