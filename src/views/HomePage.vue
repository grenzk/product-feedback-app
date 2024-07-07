<script setup lang="ts">
import { uiStore } from '@/stores/ui'

import Tag from 'primevue/tag'
import SidebarMenu from '@/components/SidebarMenu.vue'
import ContentCard from '@/components/ContentCard.vue'
import FeedbackControls from '@/components/FeedbackControls.vue'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <SidebarMenu />
  <FeedbackControls />

  <main class="home | l-flex">
    <ContentCard class="feedback | l-container">
      <div class="column | l-flex">
        <div>
          <h3>Add tags for solutions</h3>
          <p>Easier to search for solutions based on a specific stack.</p>
          <Tag value="Enhancement"></Tag>
        </div>

        <div class="upvote-counter | text-bold">
          <img src="@/assets/images/shared/icon-arrow-up.svg" alt="" aria-hidden="true" />
          <span>112</span>
        </div>
      </div>

      <div class="comment-counter | text-bold">
        <img src="@/assets/images/shared/icon-comments.svg" alt="" aria-hidden="true" />
        <span>2</span>
      </div>
    </ContentCard>

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

  .feedback {
    --counter-padding: 0.375rem;

    position: relative;
    padding: 1.5rem;

    .column {
      flex-direction: column;
      row-gap: 1rem;

      h3 {
        font-size: inherit;
        letter-spacing: -0.18px;
      }

      p {
        margin: 0.563rem 0 0.5rem 0;
      }

      .upvote-counter {
        display: inline-flex;
        background-color: var(--color-neutral-white-4);
        color: var(--color-primary-indigo-dark-2);
        letter-spacing: -0.18px;
        align-items: center;
        align-self: flex-start;
        column-gap: 10px;
        padding: var(--counter-padding) 0.813rem var(--counter-padding) 1rem;
        border-radius: var(--border-radius-m);
      }
    }

    .comment-counter {
      display: inline-flex;
      position: absolute;
      right: 2rem;
      bottom: 1.5rem;
      color: var(--color-primary-indigo-dark-2);
      letter-spacing: -0.18px;
      align-items: center;
      align-self: flex-end;
      column-gap: 8px;
      margin-bottom: var(--counter-padding);
    }
  }

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
