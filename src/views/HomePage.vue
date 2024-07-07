<script setup lang="ts">
import { uiStore } from '@/stores/ui'

import SidebarMenu from '@/components/SidebarMenu.vue'
import ContentCard from '@/components/ContentCard.vue'
import FeedbackCard from '@/components/FeedbackCard.vue'
import FeedbackControls from '@/components/FeedbackControls.vue'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <SidebarMenu />
  <FeedbackControls />

  <main class="home | l-flex">
    <FeedbackCard />

    <ContentCard v-if="false" class="empty-state | l-container">
      <img src="@/assets/images/suggestions/illustration-empty.svg" alt="" aria-hidden="true" />
      <h3 class="text-l">There is no feedback yet.</h3>
      <p>
        Got a suggestion? Found a bug that needs to be squashed? We love hearing about new ideas to
        improve our app.
      </p>
      <NewFeedbackLink />
    </ContentCard>
  </main>

  <Transition name="fade">
    <div v-show="uiStore.isSidebarActive" class="dimmed-layer" data-state="active"></div>
  </Transition>
</template>

<style lang="scss">
.home {
  padding-top: 1rem;
  flex-direction: column;
  row-gap: 1rem;

  .empty-state {
    padding: 4.75rem 1.5rem;
    text-align: center;

    > :nth-child(2) {
      margin: 2.438rem 0 0.875rem 0;
    }

    > :nth-child(3) {
      margin-bottom: 1.5rem;
    }

    img {
      margin: 0 auto;
    }

    h3 {
      letter-spacing: -0.25px;
    }
  }
}

.dimmed-layer[data-state='active'] {
  position: fixed;
  background-color: rgba(0, 0, 0, 0.5);
  height: 100%;
  width: 100%;
  top: 0;
  z-index: 1;

  &.fade-enter-active,
  &.fade-leave-active {
    transition: opacity 0.3s ease;
  }

  &.fade-enter-from,
  &.fade-leave-to {
    opacity: 0;
  }
}
</style>
