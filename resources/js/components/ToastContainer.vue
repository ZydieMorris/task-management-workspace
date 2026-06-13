<template>
    <div class="fixed top-4 right-4 flex flex-col gap-2 z-50">
        <transition-group name="toast">
            <div
                v-for="toast in toasts"
                :key="toast.id"
                class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white text-sm min-w-[250px]"
                :class="{
                    'bg-green-500' : toast.type === 'success',
                    'bg-red-500'   : toast.type === 'error',
                    'bg-blue-500'  : toast.type === 'info',
                    'bg-yellow-500': toast.type === 'warning',
                }"
            >
                <span class="flex-1">{{ toast.message }}</span>
                <button @click="remove(toast.id)" class="opacity-70 hover:opacity-100">✕</button>
            </div>
        </transition-group>
    </div>
</template>

<script setup lang="ts">
import { useToast } from '@/composables/useToast'
const { toasts, remove } = useToast()
</script>

<style scoped>
.toast-enter-active, .toast-leave-active { transition: all 0.3s ease; }
.toast-enter-from { opacity: 0; transform: translateX(100%); }
.toast-leave-to   { opacity: 0; transform: translateX(100%); }
</style>
