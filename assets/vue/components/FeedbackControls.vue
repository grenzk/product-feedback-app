<script setup lang="ts">
import { useContentStore } from '@/stores/content'

import CustomDropdown from './CustomDropdown.vue'
import NewFeedbackLink from './NewFeedbackLink.vue'
import Skeleton from 'primevue/skeleton'

const contentStore = useContentStore()

const sortOptions = ref<SortOption[]>([
  'Most Upvotes',
  'Least Upvotes',
  'Most Comments',
  'Least Comments'
])

const suggestionLabel = computed(() => {
  return contentStore.allFeedback.length === 1 ? 'Suggestion' : 'Suggestions'
})

onMounted(() => {
  const savedOption = localStorage.getItem('selectedSortOption')

  if (savedOption) contentStore.feedbackSort = savedOption as SortOption
})

watch(
  () => contentStore.feedbackSort,
  newOption => {
    localStorage.setItem('selectedSortOption', newOption)

    contentStore.sortFeedback(newOption)
  }
)
</script>

<template>
  <section class="suggestions | l-flex">
    <div class="column">
      <img src="../../images/suggestions/icon-suggestions.svg" alt="" aria-hidden="true" />

      <Skeleton v-if="contentStore.isLoading" width="7rem" height="1rem"></Skeleton>
      <h2 v-else>{{ contentStore.allFeedback.length }} {{ suggestionLabel }}</h2>
    </div>

    <div class="column">
      <Skeleton v-if="contentStore.isLoading" width="7rem" height="1rem"></Skeleton>
      <CustomDropdown v-else v-model="contentStore.feedbackSort" :options="sortOptions" />
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
