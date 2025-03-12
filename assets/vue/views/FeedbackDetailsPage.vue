<script setup lang="ts">
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { useContentStore } from '@/stores/content'

import Button from 'primevue/button'
import Textarea from 'primevue/textarea'
import FeedbackCard from '@/components/FeedbackCard.vue'
import BackLink from '@/components/BackLink.vue'
import ContentCard from '@/components/ContentCard.vue'
import UserComment from '@/components/UserComment.vue'

const props = defineProps<{
  id: string
}>()

const authStore = useAuthStore()
const contentStore = useContentStore()
const { feedback } = storeToRefs(contentStore)

const commentLabel = computed(() => (feedback.value?.commentCount === 1 ? 'Comment' : 'Comments'))
const canEditFeedback = computed(() => authStore.user?.id === feedback.value?.ownedBy.id)

const schema = { comment: yup.string().max(250).label('Add Comment') }

const { defineField, handleSubmit, resetForm } = useForm<{ comment: string }>({
  validationSchema: schema,
  initialValues: {
    comment: ''
  }
})

const [comment] = defineField('comment')

const onSubmit = handleSubmit((values): void => {
  contentStore.postComment(values.comment)
  resetForm()
})

watchEffect(() => contentStore.findandSetFeedback(props.id))
</script>

<template>
  <main class="feedback-details">
    <div class="row | l-flex">
      <BackLink />

      <RouterLink v-if="canEditFeedback" :to="`/feedback/${id}/edit`">
        <Button label="Edit Feedback" />
      </RouterLink>
    </div>

    <FeedbackCard v-if="feedback" :feedback="feedback" />

    <ContentCard v-if="feedback && feedback.commentCount > 0">
      <h3>{{ feedback.commentCount }} {{ commentLabel }}</h3>
      <UserComment v-for="comment of feedback.comments" :comment="comment" :key="comment.id" />
    </ContentCard>

    <ContentCard>
      <form @submit="onSubmit">
        <label for="comment" class="text-bold">Add Comment</label>
        <Textarea
          v-model="comment"
          auto-resize
          placeholder="Type your comment here"
          maxlength="250"
        />

        <div class="row | l-flex">
          <span>{{ 250 - comment.length }} Characters left</span>
          <Button type="submit" label="Post Comment" />
        </div>
      </form>
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

    h3,
    label {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      color: var(--color-primary-indigo-dark-2);
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
