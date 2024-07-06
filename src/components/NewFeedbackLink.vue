<script setup lang="ts">
import { RouterLink } from 'vue-router'
import Button from 'primevue/button'
</script>

<template>
  <RouterLink to="/feedback/new">
    <Button class="new-feedback-link | text-bold">
      <img src="@/assets/images/shared/icon-plus.svg" alt="" class="icon" aria-hidden="true" />
      <span>Add Feedback</span>
    </Button>
  </RouterLink>
</template>

<style lang="scss">
.new-feedback-link {
  color: var(--color-neutral-white-4);
  padding: 0.656rem 1.063rem;

  .icon {
    margin-right: 3px;
  }
}
</style>
