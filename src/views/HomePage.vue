<script setup lang="ts">
import Button from 'primevue/button'
import Tag from 'primevue/tag'

const isOpen = ref(false)
</script>

<template>
  <header id="header" class="l-flex">
    <div class="left-column l-flex">
      <h1 class="header-title">Frontend Mentor</h1>
      <span class="header-description">Feedback Board</span>
    </div>

    <Button text aria-label="toggle sidebar" @click="isOpen = !isOpen">
      <img v-if="isOpen" src="@/assets/images/shared/mobile/icon-close.svg" alt="" />
      <img v-else src="@/assets/images/shared/mobile/icon-hamburger.svg" alt="" />
    </Button>
  </header>

  <aside id="sidebar" :class="{ 'is-visible': isOpen }">
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

  <div id="feedback-controls" class="l-flex">
    <!-- <div>
      <img src="@/assets/images/suggestions/icon-suggestions.svg" alt="" />
      <h2>Suggestions</h2>
    </div> -->
    <div class="sort-by">
      <Button text>
        <span>Sort by :</span>
        <span>Most Upvotes</span>
        <img src="@/assets/images/shared/icon-arrow-down.svg" alt="" class="icon" />
      </Button>
    </div>

    <RouterLink to="/feedback/new">
      <Button>
        <img src="../assets/images/shared/icon-plus.svg" alt="" class="icon" />
        <span>Add Feedback</span>
      </Button>
    </RouterLink>
  </div>

  <main>
    <section>
      <div>
        <div>
          <h3>Add tags for solutions</h3>
          <p>Easier to search for solutions based on a specific</p>
          <Tag value="Enhancement"></Tag>
        </div>

        <div>
          <img src="@/assets/images/shared/icon-arrow-up.svg" alt="" />
          <span>112</span>
        </div>
      </div>

      <div>
        <img src="@/assets/images/shared/icon-comments.svg" alt="" />
        <span>2</span>
      </div>
    </section>
  </main>

  <Transition name="fade">
    <div v-show="isOpen" class="dimmed-layer"></div>
  </Transition>
</template>

<style lang="scss">
#header {
  position: relative;
  background-image: url('../assets/images/suggestions/mobile/background-header.png');
  background-repeat: no-repeat;
  height: 4.5rem;
  justify-content: space-between;
  padding: 1rem 1rem 1rem 1.5rem;
  z-index: 2;

  .left-column {
    flex-direction: column;
  }

  .header-title {
    color: var(--color-neutral-white-1);
    font-size: var(--font-size-s);
    font-weight: 700;
    letter-spacing: -0.19px;
  }

  .header-description {
    color: var(--color-neutral-white-1);
    font-size: var(--font-size-xxs);
    font-weight: 500;
    opacity: 75%;
  }

  .p-button {
    padding: 0.5rem;
  }
}

#sidebar {
  @media screen and (max-width: 767px) {
    background-color: var(--color-neutral-white-2);
    position: fixed;
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

  &.is-visible {
    right: 0;
  }
}

#feedback-controls {
  background-color: var(--color-primary-indigo-dark-1);
  justify-content: space-between;
  align-items: center;
  height: 3.5rem;
  padding: 0.5rem 1.5rem;

  .sort-by {
    .p-button {
      display: inline-flex;
      color: hsl(230, 86%, 97%);
      font-size: var(--font-size-xxs);
      padding: 0;
      cursor: pointer;
      gap: 5px;

      span:first-child {
        font-weight: 400;
      }

      .icon {
        margin-left: 2px;
        filter: invert(1%) sepia(1%) saturate(1%) hue-rotate(1deg) brightness(1000%) contrast(100%);
      }

      &:hover {
        opacity: 75%;
      }
    }
  }

  .p-button {
    font-size: var(--font-size-xxs);
    font-weight: 700;
    color: hsl(230, 86%, 97%);
    padding: 0.656rem 1.063rem;

    .icon {
      margin-right: 3px;
    }
  }
}

.dimmed-layer {
  background-color: rgba(0, 0, 0, 0.7);
  position: fixed;
  height: 100%;
  width: 100%;
  top: 0;
  z-index: 1;

  &.fade-enter-active,
  &.fade-leave-active {
    transition: opacity 0.3s ease;
  }

  &.fade-enter-from,
  &.fade-leave-to {
    opacity: 0;
  }
}
</style>
