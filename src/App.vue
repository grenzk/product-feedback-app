<script setup lang="ts">
import { RouterView } from 'vue-router'

import SiteHeader from '@/components/SiteHeader.vue'
</script>

<template>
  <SiteHeader v-if="$route.name === 'home'" />

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
  width: 100%;

  &:focus {
    outline-color: var(--color-primary-indigo);
  }
}

.p-button {
  font-size: var(--font-size-xxs);

  &:not(.p-button-text) {
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
        font-weight: var(--font-weight-semi-bold);
      }

      &:hover {
        background-color: var(--color-hover-indigo-light);
      }
    }
  }
}

.p-tag {
  color: var(--color-primary-indigo);
  background-color: var(--color-neutral-white-3);
  border-radius: var(--border-radius-m);
  padding: 0.375rem 1rem;

  .p-tag-value {
    font-weight: var(--font-weight-semi-bold);
  }
}
</style>
