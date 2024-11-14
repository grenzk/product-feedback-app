<script setup lang="ts">
import { RouterLink } from 'vue-router'

import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
import BackLink from '@/components/BackLink.vue'
import CustomDropdown from '@/components/CustomDropdown.vue'

const categories = ref(['Feature', 'UI', 'UX', 'Enhancement', 'Bug'])
const statuses = ref(['Suggestion', 'Planned', 'In-Progress', 'Live'])
const selectedCategory = ref('Feature')
const selectedStatus = ref('Suggestion')
</script>

<template>
  <main class="feedback-submission">
    <BackLink />

    <form class="l-flex">
      <div class="form-icon | l-flex">
        <img src="../../images/shared/form-icon-plus.svg" alt="" aria-hidden="true" />
      </div>

      <h1>Create New Feedback</h1>
      <div>
        <label class="text-bold">Feedback Title</label>
        <p>Add a short, descriptive headline</p>
        <InputText />
        <small></small>
      </div>

      <div>
        <label class="text-bold">Category</label>
        <p>Choose a category for your feedback</p>
        <CustomDropdown v-model="selectedCategory" :options="categories" />
        <small></small>
      </div>

      <div v-if="false">
        <label class="text-bold">Update Status</label>
        <p>Change feature state</p>
        <CustomDropdown v-model="selectedStatus" :options="statuses" />
        <small></small>
      </div>

      <div>
        <label class="text-bold">Feedback Detail</label>
        <p>Include any specific comments on what should be improved, added, etc.</p>
        <Textarea auto-resize />
        <small></small>
      </div>

      <div class="form-buttons l-flex">
        <RouterLink to="/"><Button label="Add feedback" /></RouterLink>
        <RouterLink to="/"><Button label="Cancel" /></RouterLink>
        <!-- <Button v-if="false" label="Delete" severity="danger" /> -->
      </div>
    </form>
  </main>
</template>

<style lang="scss">
.feedback-submission {
  form {
    position: relative;
    background-color: var(--color-neutral-white-1);
    border-radius: var(--border-radius-m);
    padding: 2.75rem 1.5rem 1.5rem 1.5rem;
    flex-direction: column;
    row-gap: 1.5rem;

    .form-icon {
      background: var(--color-gradient);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: 0;
      transform: translateY(-50%);
    }

    h1 {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
    }

    label {
      font-size: var(--font-size-xxs);
      color: var(--color-primary-indigo-dark-2);
      letter-spacing: -0.18px;
      margin-bottom: 3px;
    }

    p {
      margin-bottom: 1rem;
    }

    .p-inputtextarea {
      height: 7.5rem !important;
    }

    .form-buttons {
      margin-top: 1.5rem;
      flex-direction: column;
      row-gap: 1rem;

      a > .p-button {
        width: 100%;
        height: 2.5rem;
      }

      a:nth-child(2) > .p-button {
        background-color: var(--color-primary-indigo-dark-2);
      }
      a:nth-child(2) > .p-button:hover {
        background-color: var(--color-hover-indigo-dark);
      }
    }
  }
}

@media screen and (min-width: 768px) {
  .feedback-submission {
    form {
      padding: 3.25rem 2.625rem 2.5rem 2.625rem;

      .form-icon {
        width: 56px;
        height: 56px;

        img {
          width: 16px;
        }
      }

      h1 {
        font-size: var(--font-size-xxl);
        letter-spacing: -0.33px;
        margin-bottom: 1rem;
      }

      label {
        letter-spacing: -0.19px;
        font-size: var(--font-size-xs);
      }

      p {
        font-size: var(--font-size-xs);
      }

      .p-inputtextarea {
        height: 6rem !important;
      }

      .form-buttons {
        margin-top: 0.5rem;
        flex-direction: row-reverse;
        justify-content: flex-start;
        column-gap: 1rem;

        a > .p-button {
          height: 2.75rem;
        }

        a:first-child > .p-button {
          width: 9rem;
        }

        a:nth-child(2) > .p-button {
          width: 5.813rem;
        }
      }
    }
  }
}
</style>
