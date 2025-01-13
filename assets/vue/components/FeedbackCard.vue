<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useContentStore } from '@/stores/content'
import { http } from '@/utils/api'

import Tag from 'primevue/tag'
import Button from 'primevue/button'
import ContentCard from './ContentCard.vue'

const props = defineProps<{
  feedback: Feedback
}>()

const authStore = useAuthStore()
const contentStore = useContentStore()
const route = useRoute()

const disableHover = computed(() => {
  return route.name === 'feedback' ? 'no-hover' : null
})

const upvote = computed(() => {
  return authStore.user?.upvotes.find((upvote: Upvote) => {
    return upvote.feedback.id === props.feedback.id
  })
})

async function toggleUpvote(id: number, upvote: Upvote | undefined): Promise<void> {
  if (!authStore.user) throw new Error('User is not defined.')

  const newUpvote = { feedback: { id: id } }

  try {
    if (upvote) {
      authStore.user.upvotes.pop()

      await http.delete(`/api/upvotes/${upvote.id}`)
    } else {
      authStore.user.upvotes.push(newUpvote)

      const response = await http.post(`/api/upvotes`, {
        feedback: `/api/feedback/${id}`
      })
      const data = await response.json()

      const index = authStore.user.upvotes.findIndex((upvote: Upvote) => {
        return upvote.feedback.id === newUpvote.feedback.id
      })

      authStore.user.upvotes[index] = { ...newUpvote, id: data.id }
    }

    contentStore.loadAllFeedback()
  } catch (error) {
    authStore.showErrorMessage(error)
  }
}
</script>

<template>
  <RouterLink :to="`/feedback/${feedback.id}`">
    <ContentCard class="feedback" :data-state="disableHover">
      <div class="column | l-flex">
        <div>
          <div class="category" v-if="route.name === 'roadmap'">
            <span class="circle"></span>
            <span class="name">{{ feedback.status }}</span>
          </div>

          <h2>{{ feedback.title }}</h2>
          <p>{{ feedback.detail }}</p>
          <Tag :value="feedback.category"></Tag>
        </div>

        <Button
          class="upvote-counter | text-bold"
          :data-state="upvote ? 'upvoted' : null"
          @click.prevent="toggleUpvote(feedback.id, upvote)"
        >
          <img src="../../images/shared/icon-arrow-up.svg" alt="" aria-hidden="true" />
          <span>{{ feedback.upvotes }}</span>
        </Button>
      </div>

      <div class="comment-counter | text-bold">
        <img src="../../images/shared/icon-comments.svg" alt="" aria-hidden="true" />
        <span>{{ feedback.commentCount }}</span>
      </div>
    </ContentCard>
  </RouterLink>
</template>

<style lang="scss">
a:has(.feedback) {
  text-decoration: none;
}

a:has(.feedback[data-state='no-hover']) {
  display: contents;
}

.feedback {
  --counter-padding: 0.375rem;

  position: relative;
  padding: 1.5rem;
  cursor: pointer;

  &:hover h2 {
    color: var(--color-primary-indigo);
  }

  &[data-state='no-hover'] h2 {
    color: var(--color-primary-indigo-dark-2);
  }

  .column {
    flex-direction: column;
    row-gap: 1rem;

    .category {
      display: inline-flex;
      color: var(--color-neutral-gray);
      align-items: center;
      column-gap: 0.5rem;
      margin-bottom: 1rem;
    }

    .category > .circle {
      border-radius: 50%;
      width: 0.5rem;
      height: 0.5rem;
      background-color: var(--color-primary-purple);
    }

    h2 {
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
      border: 0;
      cursor: pointer;

      &:hover {
        background-color: var(--color-hover-indigo-light);
      }

      &[data-state='upvoted'] {
        color: var(--color-neutral-white-1);
        background-color: var(--color-primary-indigo);
      }

      &[data-state='upvoted'] > img {
        filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
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
  .home .feedback,
  .feedback-details .feedback {
    padding: 1.75rem 2rem;

    .column {
      flex-direction: row-reverse;
      justify-content: flex-end;
      column-gap: 2.5rem;

      h2 {
        font-size: var(--font-size-l);
        letter-spacing: -0.25px;
      }

      p {
        font-size: var(--font-size-m);
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
      font-size: var(--font-size-m);
      letter-spacing: -0.22px;
      column-gap: 12px;
      top: 0;
      bottom: 0;
      margin: 0;
    }
  }

  .roadmap-content .feedback {
    padding: 1.5rem 1.25rem 1.5rem 1.25rem;

    .column {
      .category {
        column-gap: 1rem;
        margin-bottom: 0.75rem;
      }

      p {
        margin: 0.563rem 0 1.5rem 0;
      }
    }

    .comment-counter {
      right: 1.5rem;
    }
  }
}

@media screen and (min-width: 1200px) {
  .roadmap-content .feedback {
    padding: 2rem;
    --counter-padding: 0.625rem;

    .column {
      .category {
        font-size: var(--font-size-m);
        margin-bottom: 0.5rem;
      }

      h2 {
        font-size: var(--font-size-l);
        letter-spacing: -0.25px;
      }

      p {
        font-size: var(--font-size-m);
        margin: 0.25rem 0 1rem 0;
      }
    }

    .comment-counter {
      font-size: var(--font-size-m);
      letter-spacing: -0.22px;
      column-gap: 12px;
      right: 2rem;
      bottom: 2rem;
      margin-bottom: 0.5rem;
    }
  }
}
</style>
