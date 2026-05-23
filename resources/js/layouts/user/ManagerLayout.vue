<script setup lang="ts">
import { LayoutGrid, Users, ClipboardList } from 'lucide-vue-next';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem, NavGroup } from '@/types';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();

const groups: NavGroup[] = [
    {
        label: 'ManagePr',
        items: [
            { title: 'Dashboard', href: '/manager/dashboard', icon: LayoutGrid },
        ],
    },
];
</script>

<template>
    <AppSidebarLayout :breadcrumbs="breadcrumbs" :groups="groups">
        <slot />
    </AppSidebarLayout>
</template>
