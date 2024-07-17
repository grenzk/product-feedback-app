<script setup lang="ts">
import Button from 'primevue/button'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <section class="suggestions | l-flex">
    <div class="column">
      <img src="@/assets/images/suggestions/icon-suggestions.svg" alt="" aria-hidden="true" />
      <h2>6 Suggestions</h2>
    </div>

    <div class="column">
      <Button text>
        <span>Sort by :</span>
        <span class="text-bold">
          Most Upvotes
          <img
            src="@/assets/images/shared/icon-arrow-down.svg"
            alt=""
            class="icon"
            aria-hidden="true"
          />
        </span>
      </Button>
    </div>
    <NewFeedbackLink />
  </section>
</template>

<style lang="scss">
.suggestions {
  background-color: var(--color-primary-indigo-dark-1);
  align-items: center;
  padding: 0.5rem 1.5rem;

  .column:first-child {
    display: none;
    align-items: center;
    column-gap: 1rem;

    h2 {
      font-size: var(--font-size-l);
      color: var(--color-neutral-white-1);
      letter-spacing: -0.25px;
    }
  }

  .column:nth-child(2) {
    .p-button {
      color: var(--color-neutral-white-4);
      padding: 0;
      cursor: pointer;
      column-gap: 5px;

      .icon {
        display: inline;
        margin-left: 3px;
        filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
      }

      &:hover {
        opacity: 75%;
      }
    }
  }

  a {
    margin-left: auto;
  }
}

@media screen and (max-width: 350px) {
  .column:nth-child(2) > .p-button {
    flex-direction: column;
  }
}

@media screen and (min-width: 768px) {
  .suggestions {
    border-radius: var(--border-radius-m);
    padding: 0.875rem 0.75rem 0.875rem 1.5rem;
    column-gap: 2.375rem;

    .column:first-child {
      display: inline-flex;

      h2 {
        padding-bottom: 2px;
      }
    }

    .column:nth-child(2) {
      .p-button {
        font-size: var(--font-size-xs);
      }
    }
  }
}

@media screen and (min-width: 1200px) {
  .suggestions {
    padding-right: 1rem;
  }
}
</style>
