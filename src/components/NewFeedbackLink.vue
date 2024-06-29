<script setup lang="ts">
import Button from 'primevue/button'
</script>

<template>
  <RouterLink to="/feedback/new">
    <Button class="new-feedback-link">
      <img src="../assets/images/shared/icon-plus.svg" alt="" class="icon" />
      <span>Add Feedback</span>
    </Button>
  </RouterLink>
</template>

<style lang="scss">
.new-feedback-link {
  font-size: var(--font-size-xxs);
  font-weight: 700;
  color: var(--color-neutral-white-4);
  padding: 0.656rem 1.063rem;

  .icon {
    margin-right: 3px;
  }
}
</style>
