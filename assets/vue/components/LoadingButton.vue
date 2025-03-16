<script setup lang="ts">
import { useContentStore } from '@/stores/content'
import type { HintedString } from 'primevue/ts-helpers'

import Button from 'primevue/button';

withDefaults(
  defineProps<{
    severity?:
      | HintedString<'secondary' | 'success' | 'info' | 'warning' | 'help' | 'danger' | 'contrast'>
      | undefined
    label: string
    hasSpinner?: boolean
    type?: 'submit' | 'reset' | 'button'
  }>(),
  {
    type: 'button'
  }
)

const contentStore = useContentStore()
</script>

<template>
  <Button
    class="loading-button"
    :type="type"
    :severity="severity"
    :loading="contentStore.isLoading"
  >
    <i v-if="hasSpinner && contentStore.isLoading" class="pi pi-spin pi-spinner"></i>
    <span class="text-bold">{{ label }}</span>
  </Button>
</template>

<style lang="scss" scoped>
.loading-button {
  justify-content: center;
  column-gap: 0.5rem;
}
</style>
