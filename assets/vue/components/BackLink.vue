<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <RouterLink class="back-link | l-flex" to="/">
    <img src="../../images/shared/icon-arrow-left.svg" alt="" aria-hidden="true" class="icon" />
    <span class="text-bold">Go Back</span>
  </RouterLink>
</template>

<style lang="scss">
.back-link {
  align-items: center;
  column-gap: 1rem;
  text-decoration: none;
  color: var(--color-neutral-gray);
  align-self: center;
  justify-self: start;

  &:hover {
    text-decoration: underline;
  }
}

@media screen and (min-width: 768px) {
  .back-link {
    font-size: var(--font-size-xs);
  }
}
</style>
