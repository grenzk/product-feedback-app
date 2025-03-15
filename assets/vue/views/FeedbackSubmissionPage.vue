<script setup lang="ts">
import { RouterLink, useRoute } from 'vue-router'
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { useContentStore } from '@/stores/content'

import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
import BackLink from '@/components/BackLink.vue'
import CustomDropdown from '@/components/CustomDropdown.vue'

const props = defineProps<{
  id?: string
}>()

const contentStore = useContentStore()
const route = useRoute()

const isSubmitting = ref(false)
const isDeleting = ref(false)

const isEditing = computed(() => route.name === 'edit feedback')
const formTitle = computed(() => {
  return isEditing.value ? `Editing '${contentStore.feedback?.title}'` : 'Create New Feedback'
})
const formButtonLabel = computed(() => (isEditing.value ? 'Save Changes' : 'Add feedback'))
const prevRoute = computed(() => (isEditing.value ? `/feedback/${props.id}` : '/'))

const categories = ['Feature', 'UI', 'UX', 'Enhancement', 'Bug']
const statuses = ['Suggestion', 'Planned', 'In-Progress', 'Live']

const schema = {
  title: yup.string().required("Can't be empty").label('Feedback Title'),
  category: yup.string().required().label('Category'),
  status: yup.string().required().label('Update Status'),
  detail: yup.string().required("Can't be empty").label('Feedback Detail')
}

const { defineField, handleSubmit, resetForm, errors } = useForm<FeedbackForm>({
  validationSchema: schema,
  initialValues: {
    category: 'Feature',
    status: 'Suggestion'
  }
})

const [title] = defineField('title')
const [category] = defineField('category')
const [status] = defineField('status')
const [detail] = defineField('detail')

const onSubmit = handleSubmit(async (values): Promise<void> => {
  isSubmitting.value = true
  if (isEditing.value) {
    await contentStore.editFeedback(values)
  } else {
    await contentStore.postFeedback(values)
    resetForm()
  }
  isSubmitting.value = false
})

async function handleRemoveFeedback() {
  isDeleting.value = true
  await contentStore.removeFeedback()
  isDeleting.value = false
}

watchEffect(() => {
  if (isEditing.value && props.id) {
    contentStore.findandSetFeedback(props.id)

    if (contentStore.feedback) {
      title.value = contentStore.feedback.title
      category.value = contentStore.feedback.category
      status.value = contentStore.feedback.status
      detail.value = contentStore.feedback.detail
    }
  }
})
</script>

<template>
  <main class="feedback-submission">
    <BackLink />

    <form class="l-flex" @submit="onSubmit">
      <div class="form-icon | l-flex">
        <img src="../../images/shared/form-icon-plus.svg" alt="" aria-hidden="true" />
      </div>

      <h1>{{ formTitle }}</h1>
      <div class="field">
        <label for="title" class="text-bold">Feedback Title</label>
        <p>Add a short, descriptive headline</p>

        <InputText
          v-model="title"
          aria-describedby="title-help"
          :class="{ 'p-invalid': errors.title }"
        />
        <small id="title-help" class="p-error">{{ errors.title }}</small>
      </div>

      <div class="field">
        <label for="category" class="text-bold">Category</label>
        <p>Choose a category for your feedback</p>

        <CustomDropdown v-model="category" :options="categories" aria-describedby="category-help" />
        <small id="category-help" class="p-error">{{ errors.category }}</small>
      </div>

      <div v-if="isEditing">
        <label for="status" class="text-bold">Update Status</label>
        <p>Change feature state</p>

        <CustomDropdown v-model="status" :options="statuses" aria-describedby="status-help" />
        <small id="status-help" class="p-error">{{ errors.status }}</small>
      </div>

      <div class="field">
        <label for="detail" class="text-bold">Feedback Detail</label>
        <p>Include any specific comments on what should be improved, added, etc.</p>

        <Textarea
          v-model="detail"
          auto-resize
          aria-describedby="detail-help"
          :class="{ 'p-invalid': errors.detail }"
        />
        <small id="detail-help" class="p-error">{{ errors.detail }}</small>
      </div>

      <div class="form-buttons l-flex">
        <Button type="submit" :loading="contentStore.isLoading">
          <i v-if="isSubmitting" class="pi pi-spin pi-spinner"></i>
          <span class="text-bold">{{ formButtonLabel }}</span>
        </Button>

        <RouterLink :to="prevRoute" :data-state="contentStore.isLoading ? 'disabled-link' : null">
          <Button :disabled="contentStore.isLoading" label="Cancel" />
        </RouterLink>

        <Button
          v-if="isEditing"
          severity="danger"
          :loading="contentStore.isLoading"
          @click="handleRemoveFeedback"
        >
          <i v-if="isDeleting" class="pi pi-spin pi-spinner"></i>
          <span class="text-bold">Delete</span>
        </Button>
      </div>
    </form>
  </main>
</template>

<style lang="scss">
.feedback-submission {
  form {
    position: relative;
    background-color: var(--color-neutral-white-1);
    border-radius: var(--border-radius-m);
    padding: 2.75rem 1.5rem 1.5rem 1.5rem;
    flex-direction: column;
    row-gap: 1.5rem;

    .form-icon {
      background: var(--color-gradient);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: 0;
      transform: translateY(-50%);
    }

    h1 {
      font-size: var(--font-size-l);
      letter-spacing: -0.25px;
    }

    label {
      font-size: var(--font-size-xxs);
      color: var(--color-primary-indigo-dark-2);
      letter-spacing: -0.18px;
      margin-bottom: 3px;
    }

    p {
      margin-bottom: 1rem;
    }

    .p-inputtextarea {
      height: 7.5rem !important;
    }

    .form-buttons {
      margin-top: 1.5rem;
      flex-direction: column;
      row-gap: 1rem;

      .p-button {
        width: 100%;
        height: 2.5rem;
        justify-content: center;
        column-gap: 0.5rem;
      }

      a > .p-button {
        background-color: var(--color-primary-indigo-dark-2);
      }
      a > .p-button:hover {
        background-color: var(--color-hover-indigo-dark);
      }
      a[data-state='disabled-link'] {
        pointer-events: none;
      }

      > .p-button:last-child {
        background-color: var(--color-secondary-red);
      }
      > .p-button:last-child:hover {
        background-color: var(--color-hover-red);
      }
    }
  }
}

@media screen and (min-width: 768px) {
  .feedback-submission {
    form {
      padding: 3.25rem 2.625rem 2.5rem 2.625rem;

      .form-icon {
        width: 56px;
        height: 56px;

        img {
          width: 16px;
        }
      }

      h1 {
        font-size: var(--font-size-xxl);
        letter-spacing: -0.33px;
        margin-bottom: 1rem;
      }

      label {
        letter-spacing: -0.19px;
        font-size: var(--font-size-xs);
      }

      p {
        font-size: var(--font-size-xs);
      }

      .form-buttons {
        margin-top: 0.5rem;
        flex-direction: row-reverse;
        justify-content: flex-start;
        column-gap: 1rem;

        .p-button {
          height: 2.75rem;
        }

        > .p-button:first-child {
          width: 9.3rem;
        }

        .p-button:last-child {
          width: 5.813rem;
          margin-right: auto;
        }
      }
    }
  }
}
</style>
