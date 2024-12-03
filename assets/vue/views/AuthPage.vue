<script setup lang="ts">
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { useAuthStore } from '@/stores/auth'

import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import Message from 'primevue/message'

const schema = {
  email: yup
    .string()
    .required('Please enter your email')
    .email('Invalid email address')
    .label('Email'),
  password: yup.string().required('Please enter your password').label('Password')
}

const { defineField, handleSubmit, resetForm, errors } = useForm<User>({
  validationSchema: schema
})

const [email] = defineField('email')
const [password] = defineField('password')

const onSubmit = handleSubmit((values): void => {
  useAuthStore().authenticateUser(values.email, values.password)
  resetForm()
})
</script>

<template>
  <Transition name="fade">
    <Message
      v-if="useAuthStore().errorMessage.length > 0"
      severity="error"
      @close="useAuthStore().errorMessage = ''"
    >
      {{ useAuthStore().errorMessage }}
    </Message>
  </Transition>

  <main class="auth">
    <form @submit="onSubmit">
      <Card>
        <template #title>Sign in to your account</template>

        <template #content>
          <div class="field">
            <label for="email" class="text-medium">Email</label>
            <InputText
              v-model="email"
              aria-describedby="email-help"
              :class="{ 'p-invalid': errors.email }"
            />
            <small v-if="errors.email" id="email-help" class="p-error">{{ errors.email }}</small>
          </div>

          <div class="field">
            <label for="password" class="text-medium">Password</label>
            <InputText
              v-model="password"
              type="password"
              aria-describedby="password-help"
              :class="{ 'p-invalid': errors.password }"
            />
            <small id="password-help" class="p-error">{{ errors.password }}</small>
          </div>
        </template>

        <template #footer>
          <Button label="Sign in" type="submit" />
        </template>
      </Card>
    </form>
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

    .field {
      margin-bottom: 1rem;

      &:last-child {
        margin-bottom: 1.5rem;
      }
    }

    .p-inputtext {
      margin-top: 0.5rem;
      height: 2.5rem;
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .p-button {
      width: 100%;
      font-size: var(--font-size-m);
      border-radius: var(--border-radius-s);
    }
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
