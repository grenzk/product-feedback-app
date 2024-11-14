<script setup lang="ts">
import CustomDropdown from './CustomDropdown.vue'
import NewFeedbackLink from './NewFeedbackLink.vue'

const sortOptions = ref(['Most Upvotes', 'Least Upvotes', 'Most Comments', 'Least Comments'])
const selectedOption = ref('Most Upvotes')
</script>

<template>
  <section class="suggestions | l-flex">
    <div class="column">
      <img src="../../images/suggestions/icon-suggestions.svg" alt="" aria-hidden="true" />
      <h2>6 Suggestions</h2>
    </div>

    <div class="column">
      <CustomDropdown v-model="selectedOption" :options="sortOptions" />
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
