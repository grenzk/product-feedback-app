<script setup lang="ts">
import Dropdown from 'primevue/dropdown'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'

const sortOptions = ref(['Most Upvotes', 'Least Upvotes', 'Most Comments', 'Least Comments'])
const selectedOption = ref('Most Upvotes')
</script>

<template>
  <section class="suggestions | l-flex">
    <div class="column">
      <img src="@/assets/images/suggestions/icon-suggestions.svg" alt="" aria-hidden="true" />
      <h2>6 Suggestions</h2>
    </div>

    <div class="column">
      <Dropdown v-model="selectedOption" :options="sortOptions">
        <template #value="slotProps">
          <div v-if="slotProps.value" class="dropdown-value | l-flex">
            <span>Sort by : </span>
            <span class="text-bold">{{ slotProps.value }}</span>
          </div>
        </template>
        <template #option="slotProps">
          <div class="dropdown-option | l-flex">
            <span>{{ slotProps.option }}</span>
            <img
              v-if="selectedOption === slotProps.option"
              src="@/assets/images/shared/icon-check.svg"
              alt=""
              aria-hidden="true"
            />
          </div>
        </template>
      </Dropdown>
    </div>
    <NewFeedbackLink />
  </section>
</template>

<style lang="scss">
.suggestions {
  background-color: var(--color-primary-indigo-dark-1);
  align-items: center;
  padding: 0.5rem 1.5rem;

  .column:first-child {
    display: none;
    align-items: center;
    column-gap: 1rem;

    h2 {
      font-size: var(--font-size-l);
      color: var(--color-neutral-white-1);
      letter-spacing: -0.25px;
    }
  }

  .column:nth-child(2) {
    .p-dropdown {
      background: transparent;
      column-gap: 0.5rem;
      outline: 0;

      &:hover {
        opacity: 75%;
      }

      .p-dropdown-label {
        color: var(--color-neutral-white-4);
        padding: 0;
      }

      .p-dropdown-trigger {
        width: 0.7rem;
        filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
      }

      .dropdown-value {
        column-gap: 5px;
      }
    }
  }

  a {
    margin-left: auto;
  }
}

@media screen and (max-width: 350px) {
  .column:nth-child(2) > .p-dropdown > .p-dropdown-label > .dropdown-value {
    flex-direction: column;
    text-align: center;
  }
}

@media screen and (min-width: 768px) {
  .suggestions {
    border-radius: var(--border-radius-m);
    padding: 0.875rem 0.75rem 0.875rem 1.5rem;
    column-gap: 2.375rem;

    .column:first-child {
      display: inline-flex;

      h2 {
        padding-bottom: 2px;
      }
    }
  }
}

@media screen and (min-width: 1200px) {
  .suggestions {
    padding-right: 1rem;
  }
}
</style>
