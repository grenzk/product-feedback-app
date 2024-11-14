<script setup lang="ts">
import { useRoute } from 'vue-router'
import { uiStore } from '@/stores/ui'

import Button from 'primevue/button'
import BackLink from './BackLink.vue'
import NewFeedbackLink from './NewFeedbackLink.vue'

const route = useRoute()
</script>

<template>
  <header :class="{ 'roadmap-header | ': route.name === 'roadmap' }" class="l-flex">
    <div class="column">
      <template v-if="route.name === 'home'">
        <h1>Frontend Mentor</h1>
        <span class="description | text-medium">Feedback Board</span>
      </template>
      <template v-else>
        <BackLink />
        <h1>Roadmap</h1>
      </template>
    </div>

    <Button
      v-if="route.name === 'home'"
      text
      @click="uiStore.isSidebarActive = !uiStore.isSidebarActive"
      aria-label="toggle sidebar"
      :aria-expanded="uiStore.isSidebarActive"
    >
      <img
        v-if="uiStore.isSidebarActive"
        src="../../images/shared/mobile/icon-close.svg"
        alt=""
        aria-hidden="true"
      />
      <img v-else src="../../images/shared/mobile/icon-hamburger.svg" alt="" aria-hidden="true" />
    </Button>
    <NewFeedbackLink v-else />
  </header>
</template>

<style lang="scss">
header {
  position: relative;
  background-image: url('../../images/suggestions/mobile/background-header.png');
  background-repeat: no-repeat;
  background-size: cover;
  justify-content: space-between;
  padding: 1rem 1rem 1rem 1.5rem;
  z-index: 2;

  h1 {
    font-size: var(--font-size-s);
    color: var(--color-neutral-white-1);
    letter-spacing: -0.19px;
  }

  .description {
    color: var(--color-neutral-white-1);
    opacity: 75%;
  }

  .p-button.p-button-text {
    padding: 0.5rem;
  }
}

header.roadmap-header {
  background-image: none;
  background-color: var(--color-primary-indigo-dark-1);
  padding: 1.625rem 1.5rem;
  align-items: center;

  h1 {
    font-size: var(--font-size-l);
    letter-spacing: -0.25px;
  }

  .back-link {
    color: var(--color-neutral-white-1);

    .icon {
      filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
    }
  }
}

@media screen and (min-width: 768px) {
  header {
    border-radius: var(--border-radius-m);
    background-image: url('../../images/suggestions/tablet/background-header.png');
    padding-bottom: 1.5rem;
    align-items: flex-end;

    h1 {
      font-size: var(--font-size-xl);
      letter-spacing: -0.25px;
    }

    .description {
      font-size: var(--font-size-s);
    }

    .p-button.p-button-text {
      display: none;
    }
  }

  header.roadmap-header {
    padding-left: 2rem;
    padding-right: 2rem;

    h1 {
      font-size: var(--font-size-xxl);
      letter-spacing: -0.33px;
    }
  }
}
</style>
