<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { uiStore } from '@/stores/ui'

import Button from 'primevue/button'
</script>

<template>
  <aside id="sidebar" :class="{ 'is-active': uiStore.isSidebarActive }">
    <div class="tags">
      <div class="row l-flex">
        <Button label="All" severity="secondary" />
        <Button label="UI" severity="secondary" />
        <Button label="UX" severity="secondary" />
      </div>

      <div class="row l-flex">
        <Button label="Enhancement" severity="secondary" />
        <Button label="Bug" severity="secondary" />
      </div>
      <Button label="Feature" severity="secondary" />
    </div>

    <div class="categories">
      <div class="row l-flex">
        <h2 class="categories-title">Roadmap</h2>
        <RouterLink to="/roadmap">View</RouterLink>
      </div>

      <ul class="list l-flex">
        <li class="list-item l-flex">
          <span class="circle"></span>
          <span>Planned</span>
          <span>2</span>
        </li>

        <li class="list-item l-flex">
          <span class="circle"></span>
          <span>In-Progress</span>
          <span>3</span>
        </li>

        <li class="list-item l-flex">
          <span class="circle"></span>
          <span>Live</span>
          <span>1</span>
        </li>
      </ul>
    </div>
  </aside>
</template>

<style lang="scss">
#sidebar {
  @media screen and (max-width: 767px) {
    position: fixed;
    background-color: var(--color-neutral-white-2);
    height: 100%;
    width: 16.938rem;
    right: -100%;
    z-index: 2;
    padding: 1.5rem;
    transition: 0.3s ease-in-out;
  }

  .tags {
    background-color: var(--color-neutral-white-1);
    border-radius: var(--border-radius-m);
    padding: 1.5rem 1.125rem 2.25rem 1.5rem;

    .row {
      column-gap: 0.5rem;
      margin-bottom: 0.875rem;

      &:nth-child(2) {
        column-gap: 0.875rem;
      }
    }

    .p-button {
      font-size: var(--font-size-xxs);
      padding: 0.375rem 1rem;
    }
  }

  .categories {
    background-color: var(--color-neutral-white-1);
    padding: 1.188rem 1.5rem 1.5rem 1.5rem;
    border-radius: var(--border-radius-m);
    margin-top: 1.5rem;

    .row {
      justify-content: space-between;
      align-items: center;

      &:nth-child(1) {
        margin-bottom: 1.5rem;
      }
    }

    .categories-title {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
    }

    a {
      color: var(--color-primary-indigo);
      font-size: var(--font-size-xxs);
      font-weight: 600;
    }

    .list {
      flex-direction: column;
      row-gap: 0.5rem;
    }

    .list-item {
      align-items: center;
      column-gap: 1rem;
      font-size: var(--font-size-m);

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

      span:last-child {
        margin-left: auto;
        font-weight: 700;
      }
    }
  }

  &.is-active {
    right: 0;
  }
}
</style>
