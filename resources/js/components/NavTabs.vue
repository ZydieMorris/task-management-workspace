<script setup lang="ts">
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'

const props = defineProps<{
    tabs: { label: string; href: string }[]
}>()

const page = usePage()
const isActive = (href: string) => page.url.startsWith(href)
</script>

<template>
    <nav class="flex gap-10 mb-6 border  bg-[#F1F5F0] px-5 pt-5 rounded-md border-gray-200">
        <Link
            v-for="tab in tabs"
            :key="tab.href"
            :href="tab.href"
            :class="isActive(tab.href)
                ? 'pb-3 text-sm font-medium -mb-px text-blue-600 border-b-2 border-blue-600'
                : 'pb-3 text-sm font-medium -mb-px text-gray-500 hover:text-blue-600'"
        >
            {{ tab.label }}
        </Link>
    </nav>
</template>
