<script setup lang="ts">
import { RouterLink } from 'vue-router'

import Tag from 'primevue/tag'
import NewFeedbackLink from '@/components/NewFeedbackLink.vue'
</script>

<template>
  <header>
    <RouterLink to="/">
      <img src="@/assets/images/shared/icon-arrow-left.svg" alt="" />
      <span>Go Back</span>
    </RouterLink>
    <h1>Roadmap</h1>
    <NewFeedbackLink />
  </header>

  <nav>
    <ul>
      <li>Planned(2)</li>
      <li>In-Progress(3)</li>
      <li>Live(1)</li>
    </ul>
  </nav>

  <h2>In-Progress(3)</h2>
  <p>Features</p>

  <div>
    <div>
      <div>
        <span></span>
        In Progress
      </div>
      <h3>One-click portfolio generation</h3>

      <p>Add ability to create professional looking portfolio from profile.</p>
      <Tag value="Feature" />
    </div>

    <div>
      <div>
        <img src="@/assets/images/shared/icon-arrow-up.svg" alt="" />
        <span>112</span>
      </div>

      <div>
        <img src="@/assets/images/shared/icon-comments.svg" alt="" />
        <span>2</span>
      </div>
    </div>
  </div>
</template>

<style lang="scss"></style>
