<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'
import { useContentStore } from '@/stores/content'

import CustomDropdown from './CustomDropdown.vue'
import NewFeedbackLink from './NewFeedbackLink.vue'
import Skeleton from 'primevue/skeleton'
import Button from 'primevue/button'
import Avatar from 'primevue/avatar'
import Menu from 'primevue/menu'

const authStore = useAuthStore()
const contentStore = useContentStore()

const sortOptions = ref<SortOption[]>([
  'Most Upvotes',
  'Least Upvotes',
  'Most Comments',
  'Least Comments'
])
const menu = ref<InstanceType<typeof Menu> | null>(null)
const menuItems = ref([
  {
    label: authStore.user?.fullName,
    disabled: true,
    icon: 'pi pi-user'
  },
  { separator: true },
  {
    label: 'Sign out',
    icon: 'pi pi-sign-out',
    command: () => authStore.logout()
  }
])

const firstName = computed(() => authStore.user?.fullName.toLowerCase().split(' ')[0])

const suggestionLabel = computed(() => {
  return contentStore.allFeedback.length === 1 ? 'Suggestion' : 'Suggestions'
})

function toggleMenu(event: Event) {
  menu.value?.toggle(event)
}

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

    <div class="column | l-flex">
      <NewFeedbackLink />

      <Button text @click="toggleMenu" aria-haspopup="true" aria-controls="overlay-menu">
        <Avatar :image="`/user-images/image-${firstName}.jpg`" shape="circle" />
      </Button>
      <Menu ref="menu" id="overlay-menu" :model="menuItems" :popup="true" />
    </div>
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

  .column:last-child {
    margin-left: auto;
    column-gap: 0.5rem;

    > .p-button-text {
      padding: 0;

      &:hover {
        background: transparent;
        opacity: 75%;
      }

      > span {
        display: none;
      }
    }
  }
}

@media screen and (max-width: 350px) {
  .suggestions {
    padding: 0.5rem;
  }
}

@media screen and (min-width: 0px) and (max-width: 400px) {
  .suggestions > .column:nth-child(2) > .p-dropdown > .p-dropdown-label > .dropdown-value {
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

    .column:last-child {
      column-gap: 1rem;
    }
  }
}

@media screen and (min-width: 1200px) {
  .suggestions {
    padding-right: 1rem;
  }
}
</style>
