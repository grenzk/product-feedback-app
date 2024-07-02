<script setup lang="ts">
import { RouterLink } from 'vue-router'

import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
</script>

<template>
  <main id="new-feedback" class="l-container">
    <RouterLink class="back-link l-flex" to="/">
      <img src="@/assets/images/shared/icon-arrow-left.svg" alt="" />
      <span>Go Back</span>
    </RouterLink>

    <form class="feedback-form l-flex">
      <div class="form-icon">
        <img src="@/assets/images/shared/form-icon-plus.svg" alt="" />
      </div>
      <h1 class="new-feedback-title">Create New Feedback</h1>
      <div>
        <label>Feedback Title</label>
        <p>Add a short, descriptive headline</p>
        <InputText />
        <small></small>
      </div>

      <div>
        <label>Category</label>
        <p>Choose a category for your feedback</p>
        <Dropdown />
        <small></small>
      </div>

      <div v-if="false">
        <label>Update Status</label>
        <p>Change feature state</p>
        <Dropdown />
        <small></small>
      </div>

      <div>
        <label>Feedback Detail</label>
        <p>Include any specific comments on what should be improved, added, etc.</p>
        <Textarea auto-resize />
        <small></small>
      </div>

      <div class="form-buttons l-flex">
        <Button label="Add feedback" />
        <RouterLink to="/">
          <Button class="cancel-button" label="Cancel" />
        </RouterLink>
        <!-- <Button v-if="false" label="Delete" severity="danger" /> -->
      </div>
    </form>
  </main>
</template>

<style lang="scss">
#new-feedback {
  padding-top: 2.125rem;
  padding-bottom: 4.813rem;

  .back-link {
    align-items: center;
    column-gap: 1rem;
    text-decoration: none;
    font-weight: 700;
    color: var(--color-neutral-gray);
    margin-bottom: 3.438rem;
  }

  .feedback-form {
    position: relative;
    background-color: var(--color-neutral-white-1);
    border-radius: var(--border-radius-m);
    padding: 2.75rem 1.5rem 1.5rem 1.5rem;
    flex-direction: column;
    row-gap: 1.5rem;

    .form-icon {
      background: linear-gradient(
        219deg,
        hsl(347, 77%, 61%) 0%,
        hsl(274, 91%, 59%) 53%,
        hsl(201, 84%, 54%) 100%
      );
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: 0;
      transform: translateY(-50%);
    }

    .new-feedback-title {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
    }

    label {
      font-size: var(--font-size-xxs);
      font-weight: 700;
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
      padding-top: 1.5rem;
      flex-direction: column;
      row-gap: 1rem;
    }

    .p-button {
      width: 100%;
      height: 2.5rem;
      font-size: var(--font-size-xxs);
    }

    .cancel-button {
      background-color: var(--color-primary-indigo-dark-2)
    }
  }
}
</style>
