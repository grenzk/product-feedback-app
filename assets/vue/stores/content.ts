import { router } from '@/router'
import { defineStore } from 'pinia'
import { http } from '@/utils/api'
import { useAuthStore } from './auth'

export const useContentStore = defineStore('content', () => {
  const authStore = useAuthStore()

  const allFeedback = ref<Feedback[]>([])
  const feedback = ref<Feedback | undefined>(undefined)
  const statuses = ref<Status[]>([
    { title: 'Planned', description: 'Ideas prioritized for research', count: 0 },
    { title: 'In-Progress', description: 'Features currently being developed', count: 0 },
    { title: 'Live', description: 'Released features', count: 0 }
  ])

  async function loadAllFeedback(): Promise<void> {
    try {
      const response = await http.get('/api/feedback')
      const data = await response.json()

      allFeedback.value = data.member

      for (const status of statuses.value) {
        status.count = filterFeedbackByStatus(status.title).length
      }
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  function findandSetFeedback(id: string): void {
    feedback.value = allFeedback.value.find((feedback: Feedback) => feedback.id === parseInt(id))
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

  async function editFeedback(formData: FeedbackForm): Promise<void> {
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

  async function toggleUpvote(id: number, upvote: Upvote | undefined): Promise<void> {
    if (!authStore.user) throw new Error('User is not defined.')

    const newUpvote = { feedback: { id: id } }

    try {
      if (upvote) {
        const upvotePosition = authStore.user.upvotes.indexOf(upvote)

        authStore.user.upvotes.splice(upvotePosition, 1)

        await http.delete(`/api/upvotes/${upvote.id}`)
      } else {
        authStore.user.upvotes.push(newUpvote)

        const response = await http.post(`/api/upvotes`, { feedback: `/api/feedback/${id}` })
        const data = await response.json()

        authStore.user.upvotes[authStore.user.upvotes.length - 1] = { ...newUpvote, id: data.id }
      }

      loadAllFeedback()
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  async function postComment(comment: string, parentCommentId?: number): Promise<void> {
    try {
      await http.post('/api/comments', {
        feedback: `/api/feedback/${feedback.value?.id}`,
        parentComment: parentCommentId ? `/api/comments/${parentCommentId}` : null,
        body: comment
      })

      loadAllFeedback()
    } catch (error) {
      authStore.showErrorMessage(error)
    }
  }

  function filterFeedbackByStatus(status: string): Feedback[] {
    return allFeedback.value.filter((feedback: Feedback) => feedback.status === status)
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
    statuses,
    loadAllFeedback,
    findandSetFeedback,
    postFeedback,
    editFeedback,
    removeFeedback,
    toggleUpvote,
    postComment,
    filterFeedbackByStatus
  }
})
