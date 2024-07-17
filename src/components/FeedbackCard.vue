<script setup lang="ts">
import Tag from 'primevue/tag'
import ContentCard from './ContentCard.vue'
</script>

<template>
  <ContentCard class="feedback">
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
  cursor: pointer;

  &:hover h3 {
    color: var(--color-primary-indigo);
  }

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
      cursor: pointer;

      &:hover {
        background-color: var(--color-hover-indigo-light);
      }
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
    column-gap: 8px;
    margin-bottom: var(--counter-padding);
  }
}

@media screen and (min-width: 768px) {
  .feedback {
    padding: 1.75rem 2rem;

    .column {
      flex-direction: row-reverse;
      justify-content: flex-end;
      column-gap: 2.5rem;

      h3 {
        font-size: var(--font-size-l);
        letter-spacing: -0.25px;
      }

      p {
        margin: 0.25rem 0 0.75rem 0;
      }

      .upvote-counter {
        flex-direction: column;
        justify-content: center;
        row-gap: 8px;
        width: 2.5rem;
        height: 3.313rem;
        padding: 0.875rem 0.563rem 0.5rem 0.563rem;
        font-size: var(--font-size-xxs);
      }
    }

    .comment-counter {
      letter-spacing: -0.22px;
      column-gap: 12px;
      top: 0;
      bottom: 0;
      margin: 0;
    }
  }
}
</style>
