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

  function getFeedback(id: string) {
    return allFeedback.value.find((feedback: Feedback) => {
      return feedback.id === parseInt(id)
    })
  }

    try {
      await http.post('/api/feedback', {
        title: formData.title,
        category: formData.category,
        status: 'Suggestion',
        detail: formData.detail
      })

      loadAllFeedback()
    } catch (error) {
      authStore.showErrorMessage(error)
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
    getFeedback,
    createFeedback,
  }
})
