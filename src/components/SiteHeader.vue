<script setup lang="ts">
import { uiStore } from '@/stores/ui'

import Button from 'primevue/button'
</script>

<template>
  <header id="header" class="l-flex">
    <div class="column l-flex">
      <h1 class="header-title">Frontend Mentor</h1>
      <span class="header-description">Feedback Board</span>
    </div>

    <Button text aria-label="toggle sidebar" @click="uiStore.isSidebarActive = !uiStore.isSidebarActive">
      <img v-if="uiStore.isSidebarActive" src="@/assets/images/shared/mobile/icon-close.svg" alt="" />
      <img v-else src="@/assets/images/shared/mobile/icon-hamburger.svg" alt="" />
    </Button>
  </header>
</template>

<style lang="scss">
#header {
  position: relative;
  background-image: url('../assets/images/suggestions/mobile/background-header.png');
  background-repeat: no-repeat;
  height: 4.5rem;
  justify-content: space-between;
  padding: 1rem 1rem 1rem 1.5rem;
  z-index: 2;

  .column {
    flex-direction: column;
  }

  .header-title {
    color: var(--color-neutral-white-1);
    font-size: var(--font-size-s);
    font-weight: 700;
    letter-spacing: -0.19px;
  }

  .header-description {
    color: var(--color-neutral-white-1);
    font-size: var(--font-size-xxs);
    font-weight: 500;
    opacity: 75%;
  }

  .p-button {
    padding: 0.5rem;
  }
}
</style>
