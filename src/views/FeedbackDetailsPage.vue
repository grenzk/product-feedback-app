<script setup lang="ts">
import Button from 'primevue/button'
import Textarea from 'primevue/textarea'
import FeedbackCard from '@/components/FeedbackCard.vue'
import BackLink from '@/components/BackLink.vue'
import ContentCard from '@/components/ContentCard.vue'
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
      <div class="comment">
        <div class="row | l-flex">
          <img src="../assets/images/user-images/image-elijah.jpg" alt="" aria-hidden="true" />
          <div class="author">
            <span class="name | text-bold">Elijah Moss</span> <br />
            <span class="handle">@hexagon.bestagon</span>
          </div>
          <button class="text-semi-bold">Reply</button>
        </div>
        <p>
          Also, please allow styles to be applied based on system preferences. I would love to be
          able to browse Frontend Mentor in the evening after my device’s dark mode turns on without
          the bright background it currently has.
        </p>
      </div>

      <hr />
    </ContentCard>

    <ContentCard>
      <h3>Add Comment</h3>
      <Textarea auto-resize placeholder="Type your comment here" />

      <div class="row | l-flex">
        <span>250 Characters left</span>
        <RouterLink><Button label="Post Comment" /></RouterLink>
      </div>
    </ContentCard>
  </main>
</template>

<style lang="scss">
.feedback-details {
  display: contents;

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

  article {
    padding: 1.5rem;

    h3 {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
      margin-bottom: 1.5rem;
    }
  }

  article:nth-child(3) {
    .comment {
      // margin-bottom: 1.5rem;

      .row {
        justify-content: flex-start;
        column-gap: 1rem;
        margin-bottom: 1rem;
      }

      img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
      }

      .author > .name {
        letter-spacing: -0.18px;
        color: var(--color-primary-indigo-dark-2);
      }
      .author > .handle {
        color: var(--color-neutral-gray);
      }

      button {
        background-color: transparent;
        border: none;
        color: var(--color-primary-indigo);
        margin-left: auto;
        cursor: pointer;

        &:hover {
          text-decoration: underline;
        }
      }
    }

    hr {
      display: none;
      border: none;
      height: 1px;
      background-color: hsla(231, 20%, 63%, 0.25);
    }
  }

  article:last-child {
    .p-inputtextarea {
      height: 5rem !important;
      margin-bottom: 1rem;
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
</style>
