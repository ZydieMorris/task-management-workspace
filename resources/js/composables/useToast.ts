import { ref } from 'vue'

type ToastType = 'success' | 'error' | 'info' | 'warning'

type Toast = {
    id: number
    message: string
    type: ToastType
}

const toasts = ref<Toast[]>([])

export function useToast() {
    const show = (message: string, type: ToastType = 'success') => {
        const id = Date.now()
        toasts.value.push({ id, message, type })

        setTimeout(() => {
            toasts.value = toasts.value.filter(t => t.id !== id)
        }, 3000)
    }

    const remove = (id: number) => {
        toasts.value = toasts.value.filter(t => t.id !== id)
    }

    return { toasts, show, remove }
}

