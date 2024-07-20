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
  display: grid;
}

#app:has(.home) {
  grid-template-rows: 4.5rem 3.5rem;

  .home {
    padding: 2rem 1.5rem 3.438rem 1.5rem;

    &:has(.empty-state) {
      padding-bottom: 2.938rem;
    }
  }
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
  font-size: var(--font-size-xxs);

  .p-tag-value {
    font-weight: var(--font-weight-semi-bold);
  }
}

@media screen and (min-width: 768px) {
  body {
    display: flex;
    justify-content: center;
    font-size: var(--font-size-m);
  }

  #app:has(.home) {
    grid-template: 11.125rem 2.5rem 4.5rem auto / repeat(3, 1fr);
    column-gap: 0.625rem;
    padding-top: 3.5rem;
    width: 43.063rem;

    > aside {
      display: contents;
    }

    > .suggestions {
      grid-area: 3 / 1 / 4 / 4;
    }

    > .home {
      grid-area: 4 / 1 / -1 / 4;
      padding: 1.5rem 0 7.063rem 0;
    }
  }

  .p-button:not(.p-button-secondary) {
    font-size: var(--font-size-xs);
  }
}

@media screen and (min-width: 1200px) {
  #app:has(.home) {
    grid-template: 6rem 2.563rem 11.875rem 12.625rem auto / 15.938rem 1fr;
    width: 69.375rem;
    padding-top: 5.875rem;
    column-gap: 1.875rem;

    > header {
      grid-area: 1 / 1 / 3 / 2;
    }

    > aside > * {
      margin-top: 1.5rem;
    }

    > .suggestions {
      grid-area: 1 / 2 / 2 / 3;
      align-self: start;
    }

    > .home {
      grid-area: 2 / 2 / -1 / 2;
      padding: 0 0 8.063rem 0;
    }
  }
}
</style>
