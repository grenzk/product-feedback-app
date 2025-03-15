import { router } from '@/router'
import { defineStore } from 'pinia'
import { http } from '@/utils/api'
import { useAuthStore } from './auth'
import { useNotifications } from '@/utils/notifications'

export const useContentStore = defineStore('content', () => {
  const authStore = useAuthStore()
  const notifications = useNotifications()

  const allFeedback = ref<Feedback[]>([])
  const allFeedbackCopy = ref<Feedback[]>([])
  const feedback = ref<Feedback | undefined>(undefined)
  const feedbackSort = ref<SortOption>('Most Upvotes')
  const feedbackCategory = ref<CategoryOption>('All')
  const statuses = ref<Status[]>([
    { title: 'Planned', description: 'Ideas prioritized for research', count: 0 },
    { title: 'In-Progress', description: 'Features currently being developed', count: 0 },
    { title: 'Live', description: 'Released features', count: 0 }
  ])
  const isLoading = ref(false)

  async function loadAllFeedback(): Promise<void> {
    try {
      const response = await http.get('/api/feedback')
      const data = await response.json()

      allFeedback.value = data.member
      allFeedbackCopy.value = data.member

      for (const status of statuses.value) {
        status.count = filterFeedbackByStatus(status.title).length
      }
    } catch (error) {
      notifications.showToast(error)
    }
  }

  function findandSetFeedback(id: string): void {
    feedback.value = allFeedback.value.find((feedback: Feedback) => feedback.id === parseInt(id))
  }

  async function postFeedback(formData: FeedbackForm): Promise<void> {
    isLoading.value = true
    try {
      const response = await http.post('/api/feedback', { ...formData })
      const data = await response.json()

      await loadAllFeedback()

      router.push(`/feedback/${data.id}`)

      notifications.showToast('Feedback has been posted.')
    } catch (error) {
      notifications.showToast(error)
    } finally {
      isLoading.value = false
    }
  }

  async function editFeedback(formData: FeedbackForm): Promise<void> {
    isLoading.value = true
    try {
      await http.patch(`/api/feedback/${feedback.value?.id}`, { ...formData })
      await loadAllFeedback()

      router.push(`/feedback/${feedback.value?.id}`)

      notifications.showToast('Feedback has been updated.')
    } catch (error) {
      notifications.showToast(error)
    } finally {
      isLoading.value = false
    }
  }

  async function removeFeedback(): Promise<void> {
    isLoading.value = true
    try {
      await http.delete(`/api/feedback/${feedback.value?.id}`)
      await loadAllFeedback()

      router.push('/')

      notifications.showToast('Feedback has been deleted.')
    } catch (error) {
      notifications.showToast(error)
    } finally {
      isLoading.value = false
    }
  }

  async function toggleUpvote(id: number, upvote: Upvote | undefined): Promise<void> {
    if (!authStore.user) throw new Error('User is not defined.')

    const feedback = allFeedback.value.find((feedback: Feedback) => feedback.id === id)
    if (!feedback) throw new Error('Feedback is not found.')

    const newUpvote = { feedback: { id: id } }

    try {
      if (upvote) {
        const upvotePosition = authStore.user.upvotes.indexOf(upvote)

        authStore.user.upvotes.splice(upvotePosition, 1)
        feedback.upvotes--

        await http.delete(`/api/upvotes/${upvote.id}`)
      } else {
        authStore.user.upvotes.push(newUpvote)
        feedback.upvotes++

        const response = await http.post(`/api/upvotes`, { feedback: `/api/feedback/${id}` })
        const data = await response.json()

        authStore.user.upvotes[authStore.user.upvotes.length - 1] = { ...newUpvote, id: data.id }
      }
    } catch (error) {
      notifications.showToast(error)
    }
  }

  async function postComment(comment: string, parentCommentId?: number): Promise<void> {
    isLoading.value = true
    try {
      await http.post('/api/comments', {
        feedback: `/api/feedback/${feedback.value?.id}`,
        parentComment: parentCommentId ? `/api/comments/${parentCommentId}` : null,
        body: comment
      })

      loadAllFeedback()
    } catch (error) {
      notifications.showToast(error)
    } finally {
      isLoading.value = false
    }
  }

  function $reset(): void {
    allFeedback.value = allFeedbackCopy.value
    sortFeedback()
  }

  function filterFeedbackByStatus(status: string): Feedback[] {
    return allFeedback.value.filter((feedback: Feedback) => feedback.status === status)
  }

  function filterFeedbackByCategory(category?: CategoryOption): void {
    if (category) feedbackCategory.value = category
    if (feedbackCategory.value === 'All') return

    allFeedback.value = allFeedback.value.filter((feedback: Feedback) => {
      return feedback.category === feedbackCategory.value
    })
  }

  function sortFeedback(option?: SortOption): void {
    const sortBy = option ?? feedbackSort.value

    const sortOptions = {
      'Most Upvotes': (f1: Feedback, f2: Feedback) => f2.upvotes - f1.upvotes,
      'Least Upvotes': (f1: Feedback, f2: Feedback) => f1.upvotes - f2.upvotes,
      'Most Comments': (f1: Feedback, f2: Feedback) => f2.commentCount - f1.commentCount,
      'Least Comments': (f1: Feedback, f2: Feedback) => f1.commentCount - f2.commentCount
    }

    allFeedback.value.sort(sortOptions[sortBy])
  }

  watchEffect(async () => {
    if (authStore.isLoggedIn) {
      isLoading.value = true
      try {
        await loadAllFeedback()

        sortFeedback()
        filterFeedbackByCategory()
      } finally {
        isLoading.value = false
      }
    }
  })

  return {
    allFeedback,
    allFeedbackCopy,
    feedback,
    feedbackSort,
    feedbackCategory,
    statuses,
    isLoading,
    loadAllFeedback,
    findandSetFeedback,
    postFeedback,
    editFeedback,
    removeFeedback,
    toggleUpvote,
    postComment,
    $reset,
    filterFeedbackByStatus,
    filterFeedbackByCategory,
    sortFeedback
  }
})
