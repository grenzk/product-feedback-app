<script setup lang="ts">
import FeedbackCard from '@/components/FeedbackCard.vue'
</script>

<template>
  <div class="l-flex" role="tablist">
    <button id="tab-1" class="text-bold" role="tab" aria-selected="true" aria-controls="tabpanel-1">
      Planned (2)
    </button>
    <button
      id="tab-2"
      class="text-bold"
      role="tab"
      aria-selected="false"
      aria-controls="tabpanel-2"
    >
      In-Progress (3)
    </button>
    <button
      id="tab-3"
      class="text-bold"
      role="tab"
      aria-selected="false"
      aria-controls="tabpanel-3"
    >
      Live (1)
    </button>
  </div>

  <main class="roadmap-content">
    <div id="tabpanel-1" class="l-flex" role="tabpanel" tabindex="0" aria-labelledby="tab-1">
      <div class="row">
        <h2>Planned (2)</h2>
        <span class="description">Ideas prioritized for research</span>
      </div>
      <FeedbackCard />
    </div>
    <!-- <div id="tabpanel-2" role="tabpanel" tabindex="0" aria-labelledby="tab-2">
      <h2>In-Progress (3)</h2>
      <span>Features currently being developed</span>
    </div>
    <div id="tabpanel-3" role="tabpanel" tabindex="0" aria-labelledby="tab-3">
      <h2>Live (1)</h2>
      <span>Released features</span>
    </div> -->
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
</style>
