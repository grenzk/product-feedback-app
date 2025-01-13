<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { uiStore } from '@/stores/ui'
import { useContentStore } from '@/stores/content'

import Button from 'primevue/button'
import ContentCard from './ContentCard.vue'

const contentStore = useContentStore()
</script>

<template>
  <aside class="l-flex" :data-state="uiStore.isSidebarActive ? 'active' : null">
    <ContentCard class="tags">
      <div class="row | l-flex">
        <Button label="All" severity="secondary" />
        <Button label="UI" severity="secondary" />
        <Button label="UX" severity="secondary" />
      </div>

      <div class="row | l-flex">
        <Button label="Enhancement" severity="secondary" />
        <Button label="Bug" severity="secondary" />
      </div>
      <Button label="Feature" severity="secondary" />
    </ContentCard>

    <ContentCard class="categories">
      <div class="row | l-flex">
        <h2>Roadmap</h2>
        <RouterLink class="text-semi-bold" to="/roadmap">View</RouterLink>
      </div>

      <ul class="l-flex">
        <li v-for="status of contentStore.statuses" class="l-flex" :key="status.title">
          <span class="circle"></span>
          <span>{{ status.title }}</span>
          <span class="text-bold">{{ status.count }}</span>
        </li>
      </ul>
    </ContentCard>
  </aside>
</template>

<style lang="scss">
body:has(aside[data-state='active']) {
  overflow-y: hidden;
}

aside {
  flex-direction: column;
  row-gap: 1.5rem;

  @media screen and (max-width: 767px) {
    position: fixed;
    background-color: var(--color-neutral-white-2);
    height: 100%;
    width: 16.938rem;
    right: -100%;
    top: 4.5rem;
    z-index: 2;
    padding: 1.5rem;
    transition: 0.3s ease-in-out;

    &[data-state='active'] {
      right: 0;
    }
  }

  .tags {
    padding: 1.5rem 1.125rem 2.25rem 1.5rem;

    .row {
      column-gap: 0.5rem;
      margin-bottom: 0.875rem;

      &:nth-child(2) {
        column-gap: 0.875rem;
      }
    }

    .p-button {
      padding: 0.375rem 1rem;
    }
  }

  .categories {
    padding: 1.188rem 1.5rem 1.5rem 1.5rem;

    > :not(:first-child) {
      margin-top: 1.5rem;
    }

    .row {
      justify-content: space-between;
      align-items: center;
    }

    h2 {
      letter-spacing: -0.25px;
      font-size: var(--font-size-l);
    }

    a {
      color: var(--color-primary-indigo);

      &:hover {
        color: hsl(230, 89%, 74%);
      }
    }

    ul {
      flex-direction: column;
      row-gap: 0.5rem;
    }

    li {
      align-items: center;
      column-gap: 1rem;
      font-size: var(--font-size-m);

      > :last-child {
        margin-left: auto;
      }

      .circle {
        display: inline-block;
        border-radius: 50%;
        width: 0.5rem;
        height: 0.5rem;
      }

      &:nth-child(1) > .circle {
        background-color: var(--color-secondary-orange-light);
      }
      &:nth-child(2) > .circle {
        background-color: var(--color-primary-purple);
      }
      &:nth-child(3) > .circle {
        background-color: var(--color-secondary-blue-light);
      }
    }
  }
}

@media screen and (min-width: 768px) {
  aside {
    .tags {
      padding-bottom: 1.5rem;
    }
  }
}
</style>
