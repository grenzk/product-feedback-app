<script setup lang="ts">
import Button from 'primevue/button'
import Tag from 'primevue/tag'
</script>

<template>
  <header id="header" class="l-flex">
    <div class="left-column l-flex">
      <h1 class="header-title">Frontend Mentor</h1>
      <span class="header-description">Feedback Board</span>
    </div>

    <Button text aria-label="toggle sidebar">
      <img src="@/assets/images/shared/mobile/icon-hamburger.svg" alt="" />
    </Button>
  </header>

  <div v-if="false">
    <div>
      <img src="@/assets/images/suggestions/icon-suggestions.svg" alt="" />
      <h2>Suggestions</h2>
    </div>
    <div>
      Sort by:
      <span>
        Most Upvotes
        <img src="@/assets/images/shared/icon-arrow-down.svg" alt="" />
      </span>
    </div>

    <RouterLink to="/feedback/new">
      <Button>
        <img src="../assets/images/shared/icon-plus.svg" alt="" />
        <span>Add feedback</span>
      </Button>
    </RouterLink>
  </div>

  <aside>
    <div>
      <Button label="All" severity="secondary" />
      <Button label="UI" severity="secondary" />
      <Button label="UX" severity="secondary" />
      <Button label="Enhancement" severity="secondary" />
      <Button label="Bug" severity="secondary" />
      <Button label="Feature" severity="secondary" />
    </div>
    <div>
      <div>
        <h2>Roadmap</h2>
        <RouterLink to="/roadmap">View</RouterLink>
      </div>
      <ul>
        <li>
          <span></span>
          Planned
        </li>
        <li>
          <span></span>
          In-progress
        </li>
        <li>
          <span></span>
          Live
        </li>
      </ul>
    </div>
  </aside>

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
</template>

<style lang="scss">
#header {
  background-image: url('../assets/images/suggestions/mobile/background-header.png');
  background-repeat: no-repeat;
  height: 4.5rem;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1rem 1rem 1.5rem;

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
</style>
