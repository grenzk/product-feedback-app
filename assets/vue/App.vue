<script setup lang="ts">
import { RouterView, useRoute } from 'vue-router'
import Toast from 'primevue/toast'

import SiteHeader from '@/components/SiteHeader.vue'
import ScrollToTop from '@/components/ScrollToTop.vue'

const route = useRoute()

const isRestrictedPage = computed(() => route.name === 'home' || route.name === 'roadmap')
</script>

<template>
  <Toast position="top-center" />
  <SiteHeader v-if="isRestrictedPage" />
  <ScrollToTop v-if="route.name === 'roadmap' || route.name === 'feedback'" />

  <RouterView />
</template>

<style lang="scss">
#app {
  --font-family: var(--font-family-sans);

  display: grid;
  margin: 0 auto;
}

#app:has(.home) {
  grid-template-rows: 4.5rem 3.5rem;

  > .home {
    padding: 0 1.5rem;

    > .feedback-container {
      padding-bottom: 3.438rem;
    }

    &:has(.empty-state) {
      padding-top: 2rem;
      padding-bottom: 2rem;
    }
  }
}

#app:has(.auth) {
  padding: 7rem 0.3rem 0 0.3rem;
  max-width: 20.438rem;
}

#app:has(.feedback-submission) {
  grid-template-rows: 6.75rem;
  padding: 0 1.5rem 4.813rem 1.5rem;
  max-width: 33.75rem;

  > .feedback-submission {
    display: contents;
  }
}

#app:has(.feedback-details) {
  grid-template-rows: 4rem;
  padding: 0 1.5rem 6.75rem 1.5rem;
  row-gap: 1.5rem;
  max-width: 45.625rem;

  > .feedback-details {
    display: contents;
  }
}

#app:has(.roadmap-content) {
  grid-template-rows: 6.25rem;
  max-width: 69.375rem;

  > .roadmap-content {
    padding: 0 1.5rem;

    > .feedback-container {
      padding-bottom: 6.125rem;
    }
  }
}

@media screen and (min-width: 768px) {
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
      padding: 0;

      > .feedback-container {
        padding-bottom: 7.063rem;
      }

      &:has(.empty-state) {
        padding-top: 1.5rem;
      }
    }
  }

  #app:has(.auth) {
    padding: 7rem 0 0 0;
  }

  #app:has(.feedback-submission) {
    grid-template-rows: 9rem;
    padding: 0 0 4.813rem 0;
  }

  #app:has(.feedback-details) {
    grid-template-rows: 6.25rem;
    padding: 0 0 6.75rem 0;
  }

  #app:has(.roadmap-content) {
    grid-template: 7.063rem 2rem / repeat(3, 1fr);
    column-gap: 0.625rem;
    width: 43.063rem;
    padding-top: 3.5rem;
    padding-bottom: 11.188rem;

    > header.roadmap-header {
      grid-area: 1 / 1 / 1 / 4;
    }

    > div[role='tablist'] {
      display: none;
    }

    > .roadmap-content {
      display: contents;

      div[role='tabpanel'] {
        grid-row: 3 / -1;
      }
    }
  }
}

@media screen and (min-width: 1200px) {
  #app:has(.home) {
    grid-template: 4.5rem 4.063rem 11.875rem 12.625rem auto / 15.938rem 1fr;
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
    }

    > .home {
      grid-area: 2 / 2 / -1 / 2;

      > .feedback-container {
        padding-bottom: 8.063rem;
      }
    }
  }

  #app:has(.roadmap-content) {
    grid-template: 7.063rem 3rem / repeat(3, 1fr);
    column-gap: 1.875rem;
    width: auto;
    padding-top: 4.875rem;

    > header.roadmap-header {
      grid-area: 1 / 1 / 1 / 4;
    }

    > div[role='tablist'] {
      display: none;
    }

    > .roadmap-content {
      display: contents;

      div[role='tabpanel'] {
        grid-row: 3 / -1;
      }
    }
  }
}
</style>
