<script setup lang="ts">
import { RouterView } from 'vue-router'

import SiteHeader from '@/components/SiteHeader.vue'
</script>

<template>
  <SiteHeader v-if="$route.name === 'home'" />

  <RouterView />
</template>

<style lang="scss">
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

#app:has(.feedback-submission) {
  grid-template-rows: 6.75rem;
  padding: 0 1.5rem 4.813rem 1.5rem;
}

@media screen and (min-width: 768px) {
  body {
    display: flex;
    justify-content: center;
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

  #app:has(.feedback-submission) {
    grid-template-rows: 9rem;
    padding: 0;
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
