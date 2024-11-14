<script setup lang="ts">
import { useRoute } from 'vue-router'

import Dropdown from 'primevue/dropdown'

defineProps<{
  options: string[]
}>()

const route = useRoute()
const modelValue = defineModel<string>()
</script>

<template>
  <Dropdown v-model="modelValue" :options="options">
    <template v-if="route.name === 'home'" #value="slotProps">
      <div v-if="slotProps.value" class="dropdown-value | l-flex">
        <span>Sort by : </span>
        <span class="text-bold">{{ slotProps.value }}</span>
      </div>
    </template>

    <template #option="slotProps">
      <div class="dropdown-option | l-flex">
        <span>{{ slotProps.option }}</span>
        <img
          v-if="modelValue === slotProps.option"
          src="../../images/shared/icon-check.svg"
          alt=""
          aria-hidden="true"
        />
      </div>
    </template>
  </Dropdown>
</template>

<style lang="scss">
.suggestions > .column:nth-child(2) > .p-dropdown {
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
</style>
