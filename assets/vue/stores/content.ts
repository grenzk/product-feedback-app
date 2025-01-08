import { router } from '@/router'
import { defineStore } from 'pinia'
import { http } from '@/utils/api'
import { useAuthStore } from './auth'

export const useContentStore = defineStore('content', () => {
  const authStore = useAuthStore()

  const allFeedback = ref<Feedback[]>([])
  const feedback = ref<Feedback | undefined>(undefined)

  async function loadAllFeedback(): Promise<void> {
    try {
      const response = await http.get('/api/feedback')
      const data = await response.json()

      allFeedback.value = data.member
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  function selectFeedback(id: string): void {
    feedback.value = allFeedback.value.find((feedback: Feedback) => {
      return feedback.id === parseInt(id)
    })
  }

  async function createFeedback(formData: FeedbackForm): Promise<void> {
    try {
      await http.post('/api/feedback', { ...formData })

      loadAllFeedback()
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  async function editFeedback(formData: FeedbackForm) {
    if (feedback.value) {
      try {
        await http.patch(`/api/feedback/${feedback.value.id}`, { ...formData })
        await loadAllFeedback()

        router.push(`/feedback/${feedback.value.id}`)
      } catch (error) {
        authStore.showErrorMessage(error)
      }
    }
  }

  async function removeFeedback(): Promise<void> {
    if (feedback.value) {
      try {
        await http.delete(`/api/feedback/${feedback.value.id}`)
        await loadAllFeedback()

        router.push('/')
      } catch (error) {
        authStore.showErrorMessage(error)
      }
    }
  }

  watchEffect(async () => {
    if (authStore.isLoggedIn) {
      try {
        await loadAllFeedback()
      } catch (error) {
        authStore.showErrorMessage(error)
      }
    }
  })

  return {
    allFeedback,
    feedback,
    loadAllFeedback,
    selectFeedback,
    createFeedback,
    editFeedback,
    removeFeedback
  }
})
