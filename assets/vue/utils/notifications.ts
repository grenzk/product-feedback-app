import { useToast } from 'primevue/usetoast'

export function useNotifications() {
  const toast = useToast()

  function showToast(messageorError: string | unknown, type: SeverityOption = 'success'): void {
    let message = ''

    if (typeof messageorError === 'string') {
      message = messageorError
    } else if (messageorError instanceof Error) {
      message = messageorError.message
      type = 'error'
    } else {
      message = String(messageorError)
      type = 'error'
    }

    toast.add({
      severity: type,
      summary: type === 'error' ? 'Error' : 'Success',
      detail: message,
      life: 5000,
      closable: false
    })
  }

  return {
    showToast
  }
}
