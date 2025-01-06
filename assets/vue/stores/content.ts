import { defineStore } from 'pinia'
import { http } from '@/utils/api'
import { useAuthStore } from './auth'

export const useContentStore = defineStore('content', () => {
  const authStore = useAuthStore()

  const allFeedback = ref<Feedback[]>([])

  async function loadAllFeedback(): Promise<void> {
    try {
      const response = await http.get('/api/feedback')
      const data = await response.json()

      allFeedback.value = data.member
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  async function createFeedback(formData: CreateFeedback): Promise<void> {
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
    loadAllFeedback,
    createFeedback,
  }
})
