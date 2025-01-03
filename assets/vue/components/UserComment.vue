<script setup lang="ts">
import Button from 'primevue/button'
import Textarea from 'primevue/textarea'

const props = defineProps<{
  comment: UserComment
  isReply?: boolean
}>()

const userWantsToReply = ref(false)
const firstName = props.comment.ownedBy.fullName.split(' ')[0].toLowerCase()
const imageUrl = `/user-images/image-${firstName}.jpg`

function handleReply(): void {
  userWantsToReply.value = !userWantsToReply.value
}
</script>

<template>
  <div class="thread">
    <div class="comment" :class="{ '| reply': isReply }">
      <div class="row | l-flex">
        <img :src="imageUrl" alt="" aria-hidden="true" />

        <div class="author">
          <span class="name | text-bold">{{ comment.ownedBy.fullName }}</span> <br />
          <span class="handle">@{{ comment.ownedBy.username }}</span>
        </div>

        <Button v-if="userWantsToReply" label="Cancel Reply" @click="handleReply" />
        <Button v-else label="Reply" @click="handleReply" />
      </div>

      <p>
        {{ comment.body }}
      </p>

      <form v-if="userWantsToReply" class="l-flex">
        <Textarea auto-resize placeholder="Type your comment here" />
        <Button label="Post Reply" />
      </form>
    </div>

    <template v-if="comment.replies.length > 0">
      <UserComment v-for="reply of comment.replies" :comment="reply" is-reply />
    </template>
  </div>
  <hr />
</template>

<style lang="scss">
.thread:has(.reply) {
  .thread {
    position: relative;
    padding-left: 1.5rem;
  }

  .thread:not(:last-child) {
    border-left: 1px solid hsla(224, 20%, 49%, 0.1);
    padding-bottom: 1.5rem;
  }

  .comment:has(+ .thread) > p {
    position: relative;
  }

  .thread:last-child::after,
  .comment:has(+ .thread) > p::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 1px;
    background-color: hsla(224, 20%, 49%, 0.1);
  }

  .thread:last-child::after {
    height: 20px;
  }

  .comment:has(+ .thread) {
    padding-bottom: 1.5rem;
  }
}

.comment {
  .row {
    justify-content: flex-start;
    column-gap: 1rem;
    margin-bottom: 1rem;
  }

  .row > .p-button {
    font: inherit;
    padding: 0;
    background: transparent;
    color: var(--color-primary-indigo);
    margin-left: auto;
    cursor: pointer;
  }

  .row > .p-button:hover {
    text-decoration: underline;
    background: transparent;
  }

  .row > .p-button > .p-button-label {
    font-weight: var(--font-weight-semi-bold);
  }

  img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }

  form {
    flex-direction: column;
    gap: 1rem;
  }

  form > .p-button {
    align-self: flex-end;
  }

  .author > .name {
    letter-spacing: -0.18px;
    color: var(--color-primary-indigo-dark-2);
  }
  .author > .handle {
    color: var(--color-neutral-gray);
  }

  p > .mentioned-handle {
    color: var(--color-primary-purple);
  }

  &:has(form) > p {
    margin-bottom: 1rem;
  }
}

hr {
  margin: 1.5rem 0;
  border: none;
  height: 1px;
  background-color: hsla(231, 20%, 63%, 0.25);

  &:last-child {
    display: none;
  }
}

@media screen and (min-width: 768px) {
  .thread:has(.reply) {
    .thread {
      margin-left: 1.25rem;
    }

    .thread:not(:last-child) {
      padding-bottom: 1rem;
    }

    .comment:has(+ .thread) {
      padding-bottom: 2rem;
    }

    .comment:has(+ .thread) > p::after {
      height: calc(100% + 2rem);
    }
  }

  .comment {
    .row {
      column-gap: 2rem;
    }

    &.reply > .row {
      margin-bottom: 0.625rem;
    }

    form {
      margin-left: 4.438rem;
      flex-direction: row;
    }

    form > .p-inputtextarea {
      max-width: 28.813rem;
    }

    form > .p-button {
      align-self: flex-start;
      width: 7.313rem;
      height: 2.75rem;
    }

    .author > .name {
      font-size: var(--font-size-xs);
      letter-spacing: -0.19px;
    }
    .author > .handle {
      font-size: var(--font-size-xs);
    }

    p {
      font-size: var(--font-size-s);
      padding-left: 3.188rem;
      margin-left: 1.25rem;
    }
  }

  hr {
    margin: 2rem 0;
  }
}
</style>
