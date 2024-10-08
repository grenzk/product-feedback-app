<script setup lang="ts">
import FeedbackCard from '@/components/FeedbackCard.vue'

const tabsContainer = ref<HTMLDivElement | null>(null)
const tabButtons = ref<HTMLButtonElement[]>([])
const tabPanels = ref<HTMLDivElement[]>([])

const categories = ref([
  { title: 'Planned', description: 'Ideas prioritized for research', count: 2 },
  { title: 'In-Progress', description: 'Features currently being developed', count: 3 },
  { title: 'Live', description: 'Released features', count: 1 }
])

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

function handleActiveTab(e: Event): void {
  const prevTab = tabButtons.value.find(button => button.ariaSelected === 'true')
  const nextTab = e.target as HTMLButtonElement
  const activePanel = tabPanels.value.find(
    tabpanel => tabpanel.id === nextTab.getAttribute('aria-controls')
  )

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
      v-for="(category, index) of categories"
      :key="index"
      ref="tabButtons"
      :id="`tab-${index + 1}`"
      class="text-bold"
      role="tab"
      :aria-selected="index === 0 ? true : undefined"
      :aria-controls="`tabpanel-${index + 1}`"
      @click="handleActiveTab"
    >
      {{ category.title }} ({{ category.count }})
    </button>
  </div>

  <main class="roadmap-content">
    <div
      v-for="(category, index) of categories"
      :key="index"
      ref="tabPanels"
      :id="`tabpanel-${index + 1}`"
      class="l-flex"
      role="tabpanel"
      :tabindex="index === 0 ? 0 : -1"
      :aria-labelledby="`tab-${index + 1}`"
      :data-state="index > 0 ? 'hidden' : null"
    >
      <div class="row">
        <h2>{{ category.title }} ({{ category.count }})</h2>
        <span class="description">{{ category.description }}</span>
      </div>
      <FeedbackCard :category="category.title" />
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
