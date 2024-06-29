<script setup lang="ts">
import { RouterLink } from 'vue-router'

import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
</script>

<template>
  <main>
    <RouterLink to="/">
      <img src="@/assets/images/shared/icon-arrow-left.svg" alt="" />
      <span>Go Back</span>
    </RouterLink>

    <form>
      <h1>Create New Feedback</h1>

      <div>
        <label>Feedback Title</label>
        <p>Add a short, descriptive headline</p>
        <InputText />
        <small>Input error</small>
      </div>

      <div>
        <label>Category</label>
        <p>Choose a category for your feedback</p>
        <Dropdown />
        <small>Input error</small>
      </div>

      <div v-if="false">
        <label>Update Status</label>
        <p>Change feature state</p>
        <Dropdown />
        <small>Input error</small>
      </div>

      <div>
        <label>Feedback Detail</label>
        <p>Include any specific comments on what should be improved, added, etc.</p>
        <Textarea auto-resize />
        <small>Input error</small>
      </div>

      <Button label="Add feedback" />
      <RouterLink to="/">
        <Button label="Cancel" />
      </RouterLink>
      <Button v-if="false" label="Delete" severity="danger" />
    </form>
  </main>
</template>

<style lang="scss"></style>
