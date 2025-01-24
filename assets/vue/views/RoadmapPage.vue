<script setup lang="ts">
import { useContentStore } from '@/stores/content'

import FeedbackCard from '@/components/FeedbackCard.vue'
import Skeleton from 'primevue/skeleton'

const contentStore = useContentStore()

const tabsContainer = ref<HTMLDivElement | null>(null)
const tabButtons = ref<HTMLButtonElement[]>([])
const tabPanels = ref<HTMLDivElement[]>([])

// Primary tab interaction handler
function handleActiveTab(event: Event): void {
  const prevTab = tabButtons.value.find(button => button.ariaSelected === 'true')
  const nextTab = event.target as HTMLButtonElement
  const activePanel = tabPanels.value.find(tabpanel => {
    return tabpanel.id === nextTab.getAttribute('aria-controls')
  })

  if (nextTab.ariaSelected === 'true') return

  tabButtons.value.forEach(button => {
    button.setAttribute('aria-selected', 'false')
    button.setAttribute('tabindex', '-1')
  })

  tabPanels.value.forEach(panel => panel.setAttribute('data-state', 'hidden'))

  activePanel?.removeAttribute('data-state')

  nextTab.setAttribute('aria-selected', 'true')
  nextTab.setAttribute('tabindex', '0')
  nextTab.focus()

  moveFocus(prevTab!, nextTab)
}

// Helper functions
function moveFocus(prevTab: HTMLButtonElement, nextTab: HTMLButtonElement): void {
  const nextTabPos = prevTab.compareDocumentPosition(nextTab)
  const nextTabWidth = nextTab.offsetWidth / tabsContainer.value?.offsetWidth! || 0
  let transitionWidth = 0

  if (nextTabPos === 4) {
    transitionWidth = nextTab.offsetLeft + nextTab.offsetWidth - prevTab.offsetLeft
  } else {
    transitionWidth = prevTab.offsetLeft + prevTab.offsetWidth - nextTab.offsetLeft
    tabsContainer.value?.style.setProperty('--left', `${nextTab.offsetLeft}px`)
  }

  tabsContainer.value?.style.setProperty(
    '--width',
    `${transitionWidth / tabsContainer.value.offsetWidth}`
  )

  setTimeout(() => {
    tabsContainer.value?.style.setProperty('--left', `${nextTab.offsetLeft}px`)
    tabsContainer.value?.style.setProperty('--width', `${nextTabWidth}`)
  }, 220)
}

function handleResize(): void {
  const activeTab = tabButtons.value.find(button => button.ariaSelected === 'true')
  if (activeTab) moveFocus(activeTab, activeTab)
}

onMounted(() => window.addEventListener('resize', handleResize))
onUnmounted(() => window.removeEventListener('resize', handleResize))
</script>

<template>
  <div ref="tabsContainer" class="l-flex" role="tablist">
    <button
      v-for="(status, index) of contentStore.statuses"
      :key="status.title"
      ref="tabButtons"
      :id="`tab-${index + 1}`"
      class="text-bold"
      role="tab"
      :aria-selected="index === 0 ? true : undefined"
      :aria-controls="`tabpanel-${index + 1}`"
      @click="handleActiveTab"
    >
      <Skeleton v-if="contentStore.isLoading" width="3rem"></Skeleton>
      <template v-else>{{ status.title }} ({{ status.count }})</template>
    </button>
  </div>

  <main class="roadmap-content">
    <div
      v-for="(status, index) of contentStore.statuses"
      :key="status.title"
      ref="tabPanels"
      :id="`tabpanel-${index + 1}`"
      class="l-flex"
      role="tabpanel"
      :tabindex="index === 0 ? 0 : -1"
      :aria-labelledby="`tab-${index + 1}`"
      :data-state="index > 0 ? 'hidden' : null"
    >
      <div class="row">
        <template v-if="contentStore.isLoading">
          <Skeleton width="6rem" height="1.5rem"></Skeleton>
          <Skeleton width="7.5rem"></Skeleton>
        </template>

        <template v-else>
          <h2>{{ status.title }} ({{ status.count }})</h2>
          <span class="description">{{ status.description }}</span>
        </template>
      </div>

      <template v-if="contentStore.isLoading">
        <Skeleton height="15rem" border-radius="0.625rem"></Skeleton>
      </template>

      <template v-else>
        <FeedbackCard
          v-for="feedback of contentStore.filterFeedbackByStatus(status.title)"
          :feedback="feedback"
          :key="feedback.id"
        />
      </template>
    </div>
  </main>
</template>

<style lang="scss">
div[role='tablist'] {
  position: relative;
  border-bottom: 1px solid hsla(231, 20%, 63%, 0.25);

  &::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 4px;
    background-color: var(--color-primary-purple);
    scale: var(--width, 0.333) 1;
    translate: var(--left, 0) 0;
    transform-origin: left;
    transition:
      scale 150ms,
      translate 150ms;
  }

  &:has(#tab-1[aria-selected='true'])::after {
    background-color: var(--color-secondary-orange-light);
  }
  &:has(#tab-3[aria-selected='true'])::after {
    background-color: var(--color-secondary-blue-light);
  }

  button[role='tab'] {
    background-color: transparent;
    border: none;
    color: var(--color-primary-indigo-dark-2);
    opacity: 0.4;
    padding: 1.25rem 0;
    letter-spacing: -0.18px;
    flex: 1;
    cursor: pointer;

    &[aria-selected='true'] {
      opacity: 1;
    }

    > .p-skeleton {
      display: block;
      margin: 0 auto;
    }
  }
}

.roadmap-content {
  div[role='tabpanel'] {
    flex-direction: column;
    row-gap: 1rem;

    .row {
      margin-bottom: 0.5rem;

      h2 {
        font-size: var(--font-size-l);
        letter-spacing: -0.25px;
        margin-bottom: 4px;
      }

      .p-skeleton:first-child {
        margin-bottom: 1rem;
      }

      .description {
        color: var(--color-neutral-gray);
      }
    }

    .feedback {
      position: relative;
      overflow: hidden;
      border-top-left-radius: var(--border-radius-s);
      border-top-right-radius: var(--border-radius-s);

      &::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background-color: var(--color-primary-purple);
      }
    }

    &#tabpanel-1 .circle,
    &#tabpanel-1 .feedback::after {
      background-color: var(--color-secondary-orange-light);
    }

    &#tabpanel-3 .circle,
    &#tabpanel-3 .feedback::after {
      background-color: var(--color-secondary-blue-light);
    }
  }
}

@media screen and (max-width: 767px) {
  div[role='tabpanel'][data-state='hidden'] {
    display: none;
  }
}

@media screen and (min-width: 768px) {
  .roadmap-content {
    div[role='tabpanel'] {
      .row {
        h2 {
          font-size: var(--font-size-xs);
          letter-spacing: -0.19px;
        }

        .description {
          font-size: var(--font-size-xs);
        }
      }
    }
  }
}

@media screen and (min-width: 1200px) {
  .roadmap-content {
    div[role='tabpanel'] {
      row-gap: 1.5rem;

      .row {
        h2 {
          font-size: var(--font-size-l);
          letter-spacing: -0.25px;
        }

        .description {
          font-size: var(--font-size-m);
        }
      }
    }
  }
}
</style>
