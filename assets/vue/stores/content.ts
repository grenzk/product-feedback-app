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

  async function postFeedback(formData: FeedbackForm): Promise<void> {
    try {
      const response = await http.post('/api/feedback', { ...formData })
      const data = await response.json()

      await loadAllFeedback()

      router.push(`/feedback/${data.id}`)
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  async function editFeedback(formData: FeedbackForm) {
    try {
      await http.patch(`/api/feedback/${feedback.value?.id}`, { ...formData })
      await loadAllFeedback()

      router.push(`/feedback/${feedback.value?.id}`)
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  async function removeFeedback(): Promise<void> {
    try {
      await http.delete(`/api/feedback/${feedback.value?.id}`)
      await loadAllFeedback()

      router.push('/')
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  async function postComment(comment: string): Promise<void> {
    try {
      await http.post('/api/comments', {
        feedback: `/api/feedback/${feedback.value?.id}`,
        body: comment
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
    selectFeedback,
    postFeedback,
    editFeedback,
    removeFeedback,
    postComment
  }
})
