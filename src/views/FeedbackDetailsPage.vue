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
      <div class="thread">
        <div class="comment">
          <div class="row | l-flex">
            <img src="@/assets/images/user-images/image-elijah.jpg" alt="" aria-hidden="true" />
            <div class="author">
              <span class="name | text-bold">Elijah Moss</span> <br />
              <span class="handle">@hexagon.bestagon</span>
            </div>
            <button class="text-semi-bold">Reply</button>
          </div>
          <p>
            Also, please allow styles to be applied based on system preferences. I would love to be
            able to browse Frontend Mentor in the evening after my device’s dark mode turns on
            without the bright background it currently has.
          </p>
        </div>
      </div>

      <hr />

      <div class="thread">
        <div class="comment">
          <div class="row | l-flex">
            <img src="@/assets/images/user-images/image-james.jpg" alt="" aria-hidden="true" />
            <div class="author">
              <span class="name | text-bold">James Skinner</span> <br />
              <span class="handle">@hummingbird1</span>
            </div>
            <button class="text-semi-bold">Reply</button>
          </div>
          <p>
            Second this! I do a lot of late night coding and reading. Adding a dark theme can be
            great for preventing eye strain and the headaches that result. It’s also quite a trend
            with modern apps and apparently saves battery life.
          </p>
        </div>
        <div class="thread">
          <div class="comment reply">
            <div class="row | l-flex">
              <img src="@/assets/images/user-images/image-anne.jpg" alt="" aria-hidden="true" />
              <div class="author">
                <span class="name | text-bold">Anne Valentine</span> <br />
                <span class="handle">@annev1990</span>
              </div>
              <button class="text-semi-bold">Reply</button>
            </div>
            <p>
              <span class="mentioned-handle | text-bold">@hummingbird1</span> While waiting for dark
              mode, there are browser extensions that will also do the job. Search for "dark theme”
              followed by your browser. There might be a need to turn off the extension for sites
              with naturally black backgrounds though.
            </p>
          </div>
        </div>
        <div class="thread">
          <div class="comment reply">
            <div class="row | l-flex">
              <img src="@/assets/images/user-images/image-ryan.jpg" alt="" aria-hidden="true" />
              <div class="author">
                <span class="name | text-bold">Ryan Welles</span> <br />
                <span class="handle">@voyager.344</span>
              </div>
              <button class="text-semi-bold">Reply</button>
            </div>
            <p>
              <span class="mentioned-handle | text-bold">@annev1990 </span> Good point! Using any
              kind of style extension is great and can be highly customizable, like the ability to
              change contrast and brightness. I'd prefer not to use one of such extensions, however,
              for security and privacy reasons.
            </p>
          </div>
        </div>
      </div>
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

  article:nth-child(3) {
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

      .thread:last-child:after,
      .comment:has(+ .thread) > p:after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 1px;
        background-color: hsla(224, 20%, 49%, 0.1);
      }

      .thread:last-child:after {
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
        font-family: inherit;
        background-color: transparent;
        border: none;
        color: var(--color-primary-indigo);
        margin-left: auto;
        cursor: pointer;
      }

      button:hover {
        text-decoration: underline;
      }

      p > .mentioned-handle {
        color: var(--color-primary-purple);
      }
    }

    hr {
      margin: 1.5rem 0;
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

@media screen and (min-width: 768px) {
  .feedback-details {
    a > .p-button {
      height: 2.75rem;
    }

    article:not(.feedback) {
      padding: 1.5rem 2rem 2rem 2rem;
    }

    article:nth-child(3) {
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

        .comment:has(+ .thread) > p:after {
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
  }
}
</style>
