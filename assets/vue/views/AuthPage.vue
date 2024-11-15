<script setup lang="ts">
import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
</script>

<template>
  <main class="auth">
    <Card>
      <template #title>Sign in to your account</template>

      <template #content>
        <div class="field">
          <label class="text-medium">Email</label>
          <InputText />
          <small></small>
        </div>

        <div class="field">
          <label class="text-medium">Password</label>
          <InputText />
          <small></small>
        </div>
      </template>

      <template #footer>
        <Button label="Sign in" />
      </template>
    </Card>
  </main>
</template>

<style lang="scss">
.auth {
  .p-card {
    border-radius: var(--border-radius-m);

    &-title {
      font-size: 1.5rem !important;
      letter-spacing: -0.25px;
      margin-bottom: 0.5rem;
    }

    .p-inputtext {
      margin: 0.5rem 0 1rem 0;
      height: 2.5rem;
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .field:last-child > .p-inputtext {
      margin-bottom: 1.5rem;
    }

    .p-button {
      width: 100%;
      font-size: var(--font-size-m);
      border-radius: var(--border-radius-s);
    }
  }
}
</style>
