<script setup lang="ts">
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'

const props = defineProps<{
    tabs: { label: string; href: string; exact?: boolean }[]
}>()

const page = usePage()
const isActive = (tab: { label: string; href: string; exact?: boolean }) => {
    if (tab.exact) return page.url === tab.href
    return page.url.startsWith(tab.href)
}
</script>

<template>
    <nav class="flex gap-10 mb-3      px-5 pt-5 ">
        <Link
            v-for="tab in tabs"
            :key="tab.href"
            :href="tab.href"
            :class="isActive(tab)
                ? 'pb-3 text-sm font-medium -mb-px text-blue-600 border-b-2 border-blue-600'
                : 'pb-3 text-sm font-medium -mb-px text-gray-500 hover:text-blue-600'"
        >
            {{ tab.label }}
        </Link>
    </nav>
</template>
