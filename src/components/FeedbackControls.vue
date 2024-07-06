<script setup lang="ts">
import Button from 'primevue/button'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <div class="feedback-controls l-flex">
    <!-- <div>
      <img src="@/assets/images/suggestions/icon-suggestions.svg" alt="" />
      <h2>Suggestions</h2>
    </div> -->
    <div class="sort-by">
      <Button text>
        <span>Sort by :</span>
        <span class="text-bold">Most Upvotes</span>
        <img
          src="@/assets/images/shared/icon-arrow-down.svg"
          alt=""
          class="icon"
          aria-hidden="true"
        />
      </Button>
    </div>
    <NewFeedbackLink />
  </div>
</template>

<style lang="scss">
.feedback-controls {
  background-color: var(--color-primary-indigo-dark-1);
  justify-content: space-between;
  align-items: center;
  height: 3.5rem;
  padding: 0.5rem 1.5rem;

  .sort-by {
    .p-button {
      display: inline-flex;
      color: var(--color-neutral-white-4);
      padding: 0;
      cursor: pointer;
      column-gap: 5px;

      .icon {
        margin-left: 2px;
        filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
      }

      &:hover {
        opacity: 75%;
      }
    }
  }
}
</style>
