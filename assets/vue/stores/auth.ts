import { defineStore } from 'pinia'
import { http } from '@/utils/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(window.user)
  const errorMessage = ref<string>('')

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
    } catch (error) {
      errorMessage.value = getErrorMessage(error)
    }
  }

  function getErrorMessage(error: unknown) {
    if (error instanceof Error) return error.message
    return String(error)
  }

  return {
    user,
    errorMessage,
    getErrorMessage,
    authenticateUser,
    onUserAuthenticated
  }
})
