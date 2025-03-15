import { defineStore } from 'pinia'
import { http } from '@/utils/api'
import { router } from '@/router'
import { useContentStore } from './content'

export const useAuthStore = defineStore('auth', () => {
  const contentStore = useContentStore()

  const user = ref<User | null>(window.user)
  const errorMessage = ref('')

  const isLoggedIn = computed(() => !!user.value)

  async function authenticateUser(email: string, password: string): Promise<void> {
    contentStore.isLoading = true
    try {
      const response = await http.post('/login', { email, password })
      const userIri = response.headers.get('Location')

      if (!userIri) {
        throw new Error('User IRI not found.')
      }

      login(userIri)
    } catch (error) {
      showErrorMessage(error)
    } finally {
      contentStore.isLoading = false
    }
  }

  async function login(userIri: string): Promise<void> {
    try {
      const response = await http.get(userIri)
      const data = await response.json()

      user.value = data

      router.push('/')
    } catch (error) {
      showErrorMessage(error)
    }
  }

  function logout() {
    window.location.href = '/logout'
  }

  function showErrorMessage(error: unknown): void {
    if (error instanceof Error) {
      errorMessage.value = error.message
    } else {
      errorMessage.value = String(error)
    }
  }

  return {
    user,
    isLoggedIn,
    errorMessage,
    authenticateUser,
    login,
    logout,
    showErrorMessage
  }
})
