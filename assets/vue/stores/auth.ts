import { defineStore } from 'pinia'
import { http } from '@/utils/api'
import { router } from '@/router'

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(window.user)
  const errorMessage = ref('')

  const isLoggedIn = computed(() => {
    return !!user.value
  })

  async function authenticateUser(email: string, password: string): Promise<void> {
    try {
      const response = await http.post('/login', { email, password })
      const userIri = response.headers.get('Location')

      if (!userIri) {
        throw new Error('User IRI not found.')
      }

      onUserAuthenticated(userIri)
    } catch (error) {
      errorMessage.value = getErrorMessage(error)
    }
  }

  async function onUserAuthenticated(userUri: string): Promise<void> {
    try {
      const response = await http.get(userUri)
      const data = await response.json()

      user.value = data

      router.push('/')
    } catch (error) {
      errorMessage.value = getErrorMessage(error)
    }
  }

  function getErrorMessage(error: unknown): string {
    if (error instanceof Error) return error.message
    return String(error)
  }

  return {
    user,
    isLoggedIn,
    errorMessage,
    getErrorMessage,
    authenticateUser,
    onUserAuthenticated
  }
})
