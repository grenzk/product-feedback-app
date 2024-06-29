<script setup lang="ts">
import { uiStore } from '@/stores/ui'

import Tag from 'primevue/tag'
import SidebarMenu from '@/components/SidebarMenu.vue'
import FeedbackControls from '@/components/FeedbackControls.vue'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <SidebarMenu />
  <FeedbackControls />

  <main id="main" class="l-flex">
    <section v-if="false" class="feedback l-container">
      <div class="column l-flex">
        <div>
          <h3 class="feedback-title">Add tags for solutions</h3>
          <p class="feedback-description">
            Easier to search for solutions based on a specific stack.
          </p>
          <Tag value="Enhancement"></Tag>
        </div>

        <div class="upvote-counter">
          <img src="@/assets/images/shared/icon-arrow-up.svg" alt="" />
          <span>112</span>
        </div>
      </div>

      <div class="comment-counter">
        <img src="@/assets/images/shared/icon-comments.svg" alt="" />
        <span>2</span>
      </div>
    </section>

    <div class="empty-state">
      <img src="../assets/images/suggestions/illustration-empty.svg" alt="" />

      <h3>There is no feedback yet.</h3>
      <p>
        Got a suggestion? Found a bug that needs to be squashed? We love hearing about new ideas to
        improve our app.
      </p>
      <NewFeedbackLink />
    </div>
  </main>

  <Transition name="fade">
    <div v-show="uiStore.isSidebarActive" class="dimmed-layer"></div>
  </Transition>
</template>

<style lang="scss">
#main {
  padding-top: 1rem;
  flex-direction: column;
  gap: 1rem;

  .feedback {
    --counter-padding: 0.375rem;

    position: relative;
    background-color: var(--color-neutral-white-1);
    border-radius: var(--border-radius-m);
    padding: 1.5rem;

    .column {
      flex-direction: column;
      gap: 1rem;
    }

    .feedback-title {
      font-size: var(--font-size-xxs);
      font-weight: 700;
      letter-spacing: -0.18px;
    }

    .feedback-description {
      margin: 0.5rem 0 0.563rem 0;
    }

    .upvote-counter {
      display: inline-flex;
      background-color: var(--color-neutral-white-4);
      color: var(--color-primary-indigo-dark-2);
      font-size: var(--font-size-xxs);
      font-weight: 700;
      letter-spacing: -0.18px;
      align-items: center;
      align-self: flex-start;
      gap: 10px;
      padding: var(--counter-padding) 0.813rem var(--counter-padding) 1rem;
      border-radius: var(--border-radius-m);
    }

    .comment-counter {
      display: inline-flex;
      position: absolute;
      right: 1.5rem;
      bottom: 1.5rem;
      color: var(--color-primary-indigo-dark-2);
      letter-spacing: -0.18px;
      align-items: center;
      align-self: flex-end;
      gap: 8px;
      font-size: var(--font-size-xxs);
      font-weight: 700;
      margin-bottom: var(--counter-padding);
    }
  }
}

.dimmed-layer {
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
