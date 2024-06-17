<script setup lang="ts">
import Button from 'primevue/button'
import Tag from 'primevue/tag'
</script>

<template>
  <header>
    <div>
      <h1>Frontend Mentor</h1>
      <span>Feedback Board</span>
    </div>

    <Button aria-label="toggle sidebar">
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
        <RouterLink to="/">View</RouterLink>
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

<style lang="scss"></style>
