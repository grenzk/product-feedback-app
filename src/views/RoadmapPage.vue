<script setup lang="ts">
import { RouterLink } from 'vue-router'

import Tag from 'primevue/tag'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <header id="roadmap-header" class="l-flex">
    <div>
      <RouterLink to="/" class="back-link l-flex">
        <img src="@/assets/images/shared/icon-arrow-left.svg" alt="" class="icon" />
        <span>Go Back</span>
      </RouterLink>
      <h1>Roadmap</h1>
    </div>
    <NewFeedbackLink />
  </header>

  <nav>
    <ul class="l-flex">
      <li>Planned (2)</li>
      <li>In-Progress (3)</li>
      <li>Live (1)</li>
    </ul>
  </nav>

  <main id="main">
    <div class="text-group l-container">
      <h2>In-Progress (3)</h2>
      <p>Features currently being developed.</p>
    </div>

    <section class="feedback l-container">
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
  </main>
</template>

<style lang="scss">
#roadmap-header {
  background-color: var(--color-primary-indigo-dark-1);
  padding: 1.625rem 1.5rem;
  justify-content: space-between;
  align-items: center;
  row-gap: 3px;

  .back-link {
    align-items: center;
    column-gap: 1rem;
    text-decoration: none;
    font-weight: 700;
    font-size: var(--font-size-xxs);
    color: var(--color-neutral-white-1);

    .icon {
      filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
    }
  }

  h1 {
    font-size: var(--font-size-l);
    color: var(--color-neutral-white-1);
    letter-spacing: -0.25px;
  }
}

nav {
  padding: 1.25rem 2.5rem 1.25rem 1.5rem;
  border-bottom: 1px solid hsla(231, 20%, 63%, 0.25);
  margin-bottom: 1rem;

  ul {
    justify-content: space-between;

    li {
      color: var(--color-primary-indigo-dark-2);
      font-weight: 700;
      letter-spacing: -0.18px;
      text-align: center;
    }
  }
}

.text-group {
  margin-bottom: 1rem;

  h2 {
    letter-spacing: -0.25px;
  }
}

.card {
}
</style>
