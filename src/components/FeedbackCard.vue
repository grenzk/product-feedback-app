<script setup lang="ts">
import Tag from 'primevue/tag'
import ContentCard from './ContentCard.vue'
</script>

<template>
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
</template>

<style lang="scss">
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
</style>
