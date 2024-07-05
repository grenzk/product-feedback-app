<script setup lang="ts">
import { uiStore } from '@/stores/ui'

import Button from 'primevue/button'
</script>

<template>
  <header class="l-flex">
    <div class="column">
      <h1 class="text-s text-bold">Frontend Mentor</h1>
      <span class="description | text-medium">Feedback Board</span>
    </div>

    <Button
      text
      @click="uiStore.isSidebarActive = !uiStore.isSidebarActive"
      aria-label="toggle sidebar"
      :aria-expanded="uiStore.isSidebarActive"
    >
      <img
        v-if="uiStore.isSidebarActive"
        src="@/assets/images/shared/mobile/icon-close.svg"
        alt=""
        aria-hidden="true"
      />
      <img
        v-else
        src="@/assets/images/shared/mobile/icon-hamburger.svg"
        alt=""
        aria-hidden="true"
      />
    </Button>
  </header>
</template>

<style lang="scss">
header {
  position: relative;
  background-image: url('../assets/images/suggestions/mobile/background-header.png');
  background-repeat: no-repeat;
  height: 4.5rem;
  justify-content: space-between;
  padding: 1rem 1rem 1rem 1.5rem;
  z-index: 2;

  h1 {
    color: var(--color-neutral-white-1);
    letter-spacing: -0.19px;
  }

  .description {
    color: var(--color-neutral-white-1);
    opacity: 75%;
  }

  .p-button {
    padding: 0.5rem;
  }
}
</style>
