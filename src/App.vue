<script setup lang="ts">
import { uiStore } from '@/stores/ui'

import SiteHeader from '@/components/SiteHeader.vue'
</script>

<template>
  <SiteHeader v-model:sidebar-active="uiStore.isSidebarActive" />

  <RouterView />
</template>

<style lang="scss">
// Customize PrimeVue theme

#app {
  --font-family: var(--font-family-sans);
}

.p-inputtext.p-variant-filled,
.p-dropdown.p-variant-filled,
.p-inputtextarea.p-variant-filled {
  background-color: var(--color-neutral-white-2);
  color: var(--color-primary-indigo-dark-2);
  border-radius: var(--border-radius-s);
  border: none;

  &:focus {
    outline-color: var(--color-primary-indigo);
  }
}

.p-button:not(.p-button-text) {
  background-color: var(--color-primary-purple);
  border-radius: var(--border-radius-m);
  border: none;

  &:hover {
    background-color: var(--color-hover-purple);
  }

  &.p-button-secondary {
    color: var(--color-primary-indigo);
    background-color: var(--color-neutral-white-3);

    .p-button-label {
      font-weight: 600;
    }

    &:hover {
      background-color: var(--color-hover-indigo-light);
    }
  }
}

.p-tag {
  color: var(--color-primary-indigo);
  background-color: var(--color-neutral-white-3);
  border-radius: var(--border-radius-m);
  padding: 0.375rem 1rem;

  .p-tag-value {
    font-weight: 600;
  }
}
</style>
