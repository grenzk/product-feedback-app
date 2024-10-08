<script setup lang="ts">
import Button from 'primevue/button'
import Textarea from 'primevue/textarea'
import FeedbackCard from '@/components/FeedbackCard.vue'
import BackLink from '@/components/BackLink.vue'
import ContentCard from '@/components/ContentCard.vue'
import UserComment from '@/components/UserComment.vue'
</script>

<template>
  <main class="feedback-details">
    <div class="row | l-flex">
      <BackLink />
      <RouterLink to="#"><Button label="Edit Feedback" /></RouterLink>
    </div>

    <FeedbackCard />

    <ContentCard>
      <h3>4 Comments</h3>
      <UserComment />
    </ContentCard>

    <ContentCard>
      <h3>Add Comment</h3>
      <Textarea auto-resize placeholder="Type your comment here" />

      <div class="row | l-flex">
        <span>250 Characters left</span>
        <Button label="Post Comment" />
      </div>
    </ContentCard>
  </main>
</template>

<style lang="scss">
.feedback-details {
  a > .p-button {
    height: 2.5rem;
  }

  > .row:first-child {
    align-self: end;
    justify-content: space-between;
    align-items: center;

    a > .p-button {
      background-color: var(--color-primary-indigo);

      &:hover {
        background-color: var(--color-hover-indigo);
      }
    }
  }

  article:not(.feedback) {
    padding: 1.5rem;

    h3 {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
      margin-bottom: 1.5rem;
    }
  }

  > article:last-child {
    .p-inputtextarea {
      height: 5rem !important;
      margin-bottom: 1rem;
    }

    .p-button {
      width: 7.438rem;
      height: 2.5rem;
    }

    .row {
      justify-content: space-between;
      align-items: center;
      column-gap: 3.313rem;
      color: var(--color-neutral-gray);
      text-align: center;
    }
  }
}

@media screen and (min-width: 768px) {
  .feedback-details {
    a > .p-button {
      height: 2.75rem;
    }

    article:not(.feedback) {
      padding: 1.5rem 2rem 2rem 2rem;
    }

    > article:last-child {
      .p-button {
        width: 8.875rem;
        height: 2.75rem;
      }
    }
  }
}
</style>
