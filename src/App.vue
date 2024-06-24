<script setup lang="ts"></script>

<template>
  <RouterView />
</template>

<style lang="scss">
// Customize PrimeVue theme

#app {
  --font-family: var(--font-family-sans);
}

.p-inputtext.p-variant-filled,
.p-dropdown.p-variant-filled,
.p-inputtextarea.p-variant-filled {
  background-color: var(--color-neutral-white-2);
  color: var(--color-primary-indigo-dark-2);
  border-radius: var(--border-radius-s);
  border: none;

  &:focus {
    outline-color: var(--color-primary-indigo);
  }
}

.p-button {
  background-color: var(--color-primary-purple);
  border-radius: var(--border-radius-m);
  border: none;

  &:hover {
    background-color: var(--color-hover-purple);
  }

  &.p-button-secondary {
    color: var(--color-primary-indigo);
    background-color: var(--color-neutral-white-3);

    .p-button-label {
      font-weight: 600;
    }

    &:hover {
      background-color: var(--color-hover-indigo-light);
    }
  }
}
</style>
