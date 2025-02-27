<script setup lang="ts">
import { uiStore } from '@/stores/ui'
import { useContentStore } from '@/stores/content'

import SidebarMenu from '@/components/SidebarMenu.vue'
import ContentCard from '@/components/ContentCard.vue'
import FeedbackCard from '@/components/FeedbackCard.vue'
import FeedbackControls from '@/components/FeedbackControls.vue'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
import Skeleton from 'primevue/skeleton'

const contentStore = useContentStore()

onUnmounted(() => {
  contentStore.$reset()
})
</script>

<template>
  <SidebarMenu />
  <FeedbackControls />

  <main class="home">
    <div class="feedback-container">
      <template v-if="contentStore.isLoading">
        <Skeleton v-for="i of 4" :key="i" height="10rem" border-radius="0.625rem"></Skeleton>
      </template>

      <template v-else>
        <ContentCard v-if="contentStore.allFeedback.length === 0" class="empty-state">
          <img src="../../images/suggestions/illustration-empty.svg" alt="" aria-hidden="true" />
          <h3>There is no feedback yet.</h3>
          <p>
            Got a suggestion? Found a bug that needs to be squashed? We love hearing about new ideas
            to improve our app.
          </p>
          <NewFeedbackLink />
        </ContentCard>

        <FeedbackCard
          v-else
          v-for="feedback of contentStore.allFeedback"
          :feedback="feedback"
          :key="feedback.id"
        />
      </template>
    </div>
  </main>

  <Transition name="fade">
    <div v-show="uiStore.isSidebarActive" class="dimmed-layer" data-state="active"></div>
  </Transition>
</template>

<style lang="scss">
.home {
  .feedback-container {
    height: calc(100vh - 8rem);
    overflow-y: auto;
    padding-top: 2rem;
    scroll-padding-top: 1rem;
    scroll-snap-type: y mandatory;

    &:not(:hover) {
      scrollbar-gutter: stable;
    }

    > * {
      display: block;
      margin-bottom: 1rem;
      scroll-snap-align: start;

      &:first-child {
        scroll-snap-align: end;
      }

      &:last-child {
        margin-bottom: 0;
      }
    }
  }

  .empty-state {
    padding: 4.75rem 1.5rem;
    text-align: center;

    > img {
      margin: 0 auto;
    }

    h3 {
      font-size: var(--font-size-l);
      margin: 2.438rem 0 0.875rem 0;
      letter-spacing: -0.25px;
    }

    p {
      margin-bottom: 1.5rem;
      max-width: 25.625rem;
      margin-left: auto;
      margin-right: auto;
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

@media screen and (min-width: 768px) {
  .home {
    .feedback-container {
      height: calc(100vh - 21.625rem);
      padding-top: 1.5rem;
    }

    .empty-state {
      padding: 6.938rem 0;

      > img {
        width: 129.64px;
        height: 136.74px;
      }

      h3 {
        font-size: var(--font-size-xxl);
        margin: 3.329rem 0 1rem 0;
        letter-spacing: -0.33px;
      }

      p {
        margin-bottom: 3rem;
        font-size: var(--font-size-m);
      }
    }
  }
}

@media screen and (min-width: 1200px) {
  .home {
    .feedback-container {
      height: calc(100vh - 10.375rem);
      scroll-padding-top: 1.25rem;

      > * {
        margin-bottom: 1.25rem;
      }
    }
  }
}
</style>
