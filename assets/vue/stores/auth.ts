import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(window.user)
  const tokens = ref(window.tokens)
  const errorMessage = ref<string>('')

  async function authenticateUser(email: string, password: string): Promise<void> {
    try {
      const response = await fetch('/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          email,
          password
        })
      })

      if (!response.ok) {
        const data = await response.json()
        throw new Error(data.error)
      }

      const userIri = response.headers.get('Location')

      onUserAuthenticated(userIri!)
    } catch (error) {
      errorMessage.value = getErrorMessage(error)
    }
  }

  async function onUserAuthenticated(userUri: string): Promise<void> {
    try {
      const response = await fetch(userUri)
      const data = await response.json()

      if (!response.ok) throw new Error(data.error)

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
    tokens,
    errorMessage,
    authenticateUser,
    onUserAuthenticated
  }
})
